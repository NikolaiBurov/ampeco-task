<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PriceNotificationPostRequest;
use App\Http\Services\ChartService;
use App\Http\Services\PriceNotificationService;
use App\Models\CryptoSymbol;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChartController extends Controller
{
    public function __construct(
        private readonly ChartService $chartService,
        private readonly PriceNotificationService $priceNotificationService
    ) {
    }

    public function index(): View
    {
        $data = $this->chartService->getTradesBySymbol(CryptoSymbol::BTCN_SYMBOL);

        return view('chart/index', [
            'chartData' => [
                'hours' => $data['hours'],
                'values' => $data['values']
            ],
        ]);
    }

    public function createPriceNotification(PriceNotificationPostRequest $request): RedirectResponse
    {
        $formData = $request->except('_token');

        try {
            $this->priceNotificationService->updateOrCreateNotification($formData);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', 'Something went wrong.');

            return redirect()->route('charts.index');
        }

        $request->session()->flash('message', 'Successfully saved data !');

        return redirect()->route('charts.index');
    }
}