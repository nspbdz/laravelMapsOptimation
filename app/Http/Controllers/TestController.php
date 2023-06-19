<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {

        $startLat = -6.175392; // Latitude titik awal
        $startLng = 106.827153; // Longitude titik awal
        $locations = [

            [
                'name' => 'Indramayu',
                'latitude' => -6.327583,
                'longitude' => 108.324936
            ],

            [
                'name' => 'parung panjang',
                'latitude' => -6.368107,
                'longitude' => 106.553387
            ],
            [
                'name' => 'tegal parang',
                'latitude' => -6.249095,
                'longitude' => 106.828162
            ],




        ];
        $nearestLocation = $this->getNearestLocation($startLat, $startLng, $locations);

        // echo "Lokasi terdekat: " . $nearestLocation['name'] . "\n";

        return view('test.index', ['nearestLocation' => $nearestLocation]);
    }

    function getNearestLocation($startLat, $startLng, $locations)
    {
        $nearestLocation = null;
        $nearestDistance = null;

        foreach ($locations as $location) {
            $lat = $location['latitude'];
            $lng = $location['longitude'];

            $distance = $this->haversineDistance($startLat, $startLng, $lat, $lng);

            if ($nearestDistance === null || $distance < $nearestDistance) {
                $nearestLocation = $location;
                $nearestDistance = $distance;
            }
        }

        return $nearestLocation;
    }

    function haversineDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Radius of the earth in kilometers

        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLng = deg2rad($lng2 - $lng1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($deltaLng / 2) * sin($deltaLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }
}
