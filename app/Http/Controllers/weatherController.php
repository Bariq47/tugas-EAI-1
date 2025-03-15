<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class weatherController extends Controller
{
    public function index(Request $request)
    {
        $city = $request->query('city', 'Jakarta');
        $weatherData = null;
        $error = null;

        if ($city) {
            $apiKey = env('WEATHERSTACK_API');
            $url = "http://api.weatherstack.com/current?access_key={$apiKey}&query={$city}";

            $response = Http::get($url);
            $data = $response->json();

            if (isset($data['error'])) {
                $error = $data['error']['info'];
            } else {
                $weatherData = [
                    'city' => $data['location']['name'],
                    'temperature' => $data['current']['temperature'],
                    'description' => $data['current']['weather_descriptions'][0],
                    'humidity' => $data['current']['humidity'],
                    'wind_speed' => $data['current']['wind_speed'],
                    'feels_like' => $data['current']['feelslike'],
                ];
            }
        }

        return view('welcome', compact('weatherData', 'error', 'city'));
    }
}
