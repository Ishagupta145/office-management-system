<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    private $baseUrl = 'https://countriesnow.space/api/v0.1';

    public function getCountries()
    {
        try {
            $countries = Cache::remember('countries', 86400, function () {
                $response = Http::timeout(15)
                    ->get($this->baseUrl . '/countries/positions');

                if (!$response->successful()) {
                    throw new \Exception('Countries API failed');
                }

                return $response->json('data') ?? [];
            });

            return response()->json($countries);

        } catch (\Exception $e) {
            Log::error('Country API Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStates($country)
    {
        try {
            $states = Cache::remember("states_{$country}", 86400, function () use ($country) {
                $response = Http::timeout(10)
                    ->post($this->baseUrl . '/countries/states', [
                        'country' => $country
                    ]);

                if (!$response->successful()) {
                    throw new \Exception('States API failed');
                }

                return collect($response->json('data.states') ?? [])
                    ->map(fn ($s) => ['state_name' => $s['name'] ?? $s])
                    ->sortBy('state_name')
                    ->values()
                    ->toArray();
            });

            return response()->json($states);

        } catch (\Exception $e) {
            Log::error("States API Error ({$country}): " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCities(Request $request, $state)
    {
        $country = $request->query('country');

        if (!$country) {
            return response()->json([], 400);
        }

        try {
            $cities = Cache::remember("cities_{$country}_{$state}", 86400, function () use ($country, $state) {
                $response = Http::timeout(10)
                    ->post($this->baseUrl . '/countries/state/cities', [
                        'country' => $country,
                        'state' => $state
                    ]);

                if (!$response->successful()) {
                    throw new \Exception('Cities API failed');
                }

                return collect($response->json('data') ?? [])
                    ->sort()
                    ->map(fn ($city) => ['city_name' => $city])
                    ->values()
                    ->toArray();
            });

            return response()->json($cities);

        } catch (\Exception $e) {
            Log::error("Cities API Error ({$state}, {$country}): " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
