<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    private $baseUrl = 'https://countriesnow.space/api/v0.1';

    /**
     * Get all countries
     */
    public function getCountries()
{
    try {
        $response = Http::timeout(15)
            ->withoutVerifying()   // fixes SSL issues on localhost
            ->get('https://countriesnow.space/api/v0.1/countries/positions');

        if ($response->successful()) {
            return response()->json($response->json()['data']);
        }

        return response()->json([], 500);

    } catch (\Exception $e) {
        \Log::error('Country API Error: ' . $e->getMessage());
        return response()->json([], 500);
    }
}


    /**
     * Get states for a specific country
     */
    public function getStates($country)
    {
        try {
            $response = Http::timeout(10)
    ->withoutVerifying()
    ->post($this->baseUrl . '/countries/states', [
        'country' => $country
    ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']['states']) && is_array($data['data']['states'])) {
                    $states = collect($data['data']['states'])
                        ->map(function ($state) {
                            return [
                                'state_name' => is_array($state) ? $state['name'] : $state
                            ];
                        })
                        ->sortBy('state_name')
                        ->values()
                        ->toArray();
                    
                    return response()->json($states);
                }
            }

            return response()->json([]);

        } catch (\Exception $e) {
            Log::error('Error fetching states for ' . $country . ': ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch states', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get cities for a specific state and country
     */
    public function getCities(Request $request, $state)
    {
        try {
            $country = $request->query('country');
            
            if (!$country) {
                return response()->json(['error' => 'Country parameter is required'], 400);
            }

            $response = Http::timeout(10)
    ->withoutVerifying()
    ->post($this->baseUrl . '/countries/state/cities', [
        'country' => $country,
        'state' => $state
    ]);


            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['data']) && is_array($data['data'])) {
                    $cities = collect($data['data'])
                        ->sort()
                        ->values()
                        ->map(function ($city) {
                            return ['city_name' => $city];
                        })
                        ->toArray();
                    
                    return response()->json($cities);
                }
            }

            return response()->json([]);

        } catch (\Exception $e) {
            Log::error('Error fetching cities for ' . $state . ', ' . $country . ': ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch cities', 'message' => $e->getMessage()], 500);
        }
    }
}