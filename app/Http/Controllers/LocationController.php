<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    private string $baseUrl = 'https://countriesnow.space/api/v0.1';

    /**
     * Get all countries
     */
    public function getCountries()
    {
        try {
            return Cache::remember('countries_list', 86400, function () {

                $response = Http::withHeaders([
                        'Accept' => 'application/json',
                    ])
                    ->withoutVerifying()
                    ->timeout(20)
                    ->get($this->baseUrl . '/countries/positions');

                if ($response->successful() && isset($response->json()['data'])) {
                    return response()->json($response->json()['data']);
                }

                Log::error('Countries API failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return response()->json([], 500);
            });

        } catch (\Exception $e) {
            Log::error('Country API Error: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Get states for a specific country
     */
    public function getStates(string $country)
    {
        try {
            $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])
                ->withoutVerifying()
                ->timeout(20)
                ->post($this->baseUrl . '/countries/states', [
                    'country' => $country,
                ]);

            if ($response->successful()) {

                $states = collect($response->json('data.states', []))
                    ->map(function ($state) {
                        return [
                            'state_name' => is_array($state) ? ($state['name'] ?? '') : $state,
                        ];
                    })
                    ->filter(fn ($s) => !empty($s['state_name']))
                    ->sortBy('state_name')
                    ->values();

                return response()->json($states);
            }

            Log::error('States API failed', [
                'country' => $country,
                'status'  => $response->status(),
                'body'    => $response->body(),
            ]);

            return response()->json([]);

        } catch (\Exception $e) {
            Log::error("State API Error ($country): " . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Get cities for a specific state and country
     */
    public function getCities(Request $request, string $state)
    {
        $country = $request->query('country');

        if (!$country) {
            return response()->json([], 400);
        }

        try {
            $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])
                ->withoutVerifying()
                ->timeout(20)
                ->post($this->baseUrl . '/countries/state/cities', [
                    'country' => $country,
                    'state'   => $state,
                ]);

            if ($response->successful()) {

                $cities = collect($response->json('data', []))
                    ->sort()
                    ->map(fn ($city) => ['city_name' => $city])
                    ->values();

                return response()->json($cities);
            }

            Log::error('Cities API failed', [
                'country' => $country,
                'state'   => $state,
                'status'  => $response->status(),
                'body'    => $response->body(),
            ]);

            return response()->json([]);

        } catch (\Exception $e) {
            Log::error("City API Error ($state, $country): " . $e->getMessage());
            return response()->json([], 500);
        }
    }
}
