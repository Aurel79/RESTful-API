<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $apiKey = 'f22fcc1cb4f56bda58224c17';

    try {
        $response = Http::timeout(10)->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");

        if ($response->failed()) {
            throw new \Exception('Failed to fetch exchange rates');
        }

        $rates = $response->json();
    } catch (\Exception $e) {
        Log::error('Error fetching exchange rates: ' . $e->getMessage());
        $rates = ['conversion_rates' => ['Error' => 'Failed to fetch data']];
    }

    return view('index', compact('rates'));
});

Route::post('/convert', function (Request $request) {
    $apiKey = 'f22fcc1cb4f56bda58224c17';
    $amount = $request->input('amount');
    $currency = $request->input('currency');

    try {
        $response = Http::timeout(10)->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");

        if ($response->failed()) {
            throw new \Exception('Failed to fetch exchange rates');
        }

        $rates = $response->json();
        $convertedAmount = isset($rates['conversion_rates'][$currency]) ? $amount * $rates['conversion_rates'][$currency] : 'Invalid currency';
    } catch (\Exception $e) {
        Log::error('Error fetching exchange rates: ' . $e->getMessage());
        $convertedAmount = 'Failed to fetch data';
    }

    return response()->json(['converted_amount' => $convertedAmount]);
});