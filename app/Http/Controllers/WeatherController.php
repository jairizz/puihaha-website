<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class WeatherController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $data = $request->validate([
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lon' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $key = config('services.openweather.key');

        if (! $key) {
            return response()->json([
                'message' => 'Weather service is not configured yet.',
            ], 503);
        }

        $cacheKey = 'weather:' . number_format((float) $data['lat'], 3, '.', '') . ':' . number_format((float) $data['lon'], 3, '.', '');

        try {
            $weather = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($data, $key): array {
                return Http::timeout(10)
                    ->get('https://api.openweathermap.org/data/2.5/weather', [
                        'lat' => $data['lat'],
                        'lon' => $data['lon'],
                        'units' => 'metric',
                        'appid' => $key,
                    ])
                    ->throw()
                    ->json();
            });
        } catch (Throwable) {
            return response()->json([
                'message' => 'Weather is currently unavailable.',
            ], 502);
        }

        return response()->json([
            'place' => $weather['name'] ?? 'Selected location',
            'temperature' => $weather['main']['temp'] ?? null,
            'description' => $weather['weather'][0]['description'] ?? null,
            'humidity' => $weather['main']['humidity'] ?? null,
        ]);
    }
}
