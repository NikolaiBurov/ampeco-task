<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chart_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crypto_symbol_id');
            $table->decimal('price', 16, 3);
            $table->timestamp('created_at');

            $table->foreign('crypto_symbol_id')
                ->references('id')
                ->on('crypto_symbols')
                ->onDelete('cascade');

        });

        Artisan::call('db:seed', [
            '--class' => 'ChartMetricSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('chart_metrics');
    }
};
