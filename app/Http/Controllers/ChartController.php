<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Services\ChartService;
use App\Models\CryptoSymbol;
use Illuminate\View\View;

class ChartController extends Controller
{
    public function __construct(private readonly ChartService $chartService)
    {
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
}