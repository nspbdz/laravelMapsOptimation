<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {

        // $startLat = -6.175392; // Latitude titik awal
        // $startLng = 106.827153; // Longitude titik awal
        $startLocations = [
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

        // dd(count($startLocations));


        $endLocation = [
            [
                'name' => 'Jakarta Location 1',
                'latitude' => -6.200,
                'longitude' => 106.700,
            ],
            [
                'name' => 'Jakarta Location 2',
                'latitude' => -6.201,
                'longitude' => 106.701,
            ],
            [
                'name' => 'Jakarta Location 3',
                'latitude' => -6.202,
                'longitude' => 106.702,
            ],
            [
                'name' => 'Jakarta Location 4',
                'latitude' => -6.203,
                'longitude' => 106.703,
            ],
            [
                'name' => 'Jakarta Location 5',
                'latitude' => -6.204,
                'longitude' => 106.704,
            ],
            [
                'name' => 'Jakarta Location 6',
                'latitude' => -6.205,
                'longitude' => 106.705,
            ],
            [
                'name' => 'Jakarta Location 7',
                'latitude' => -6.206,
                'longitude' => 106.706,
            ],
            [
                'name' => 'Jakarta Location 8',
                'latitude' => -6.207,
                'longitude' => 106.707,
            ],
            [
                'name' => 'Jakarta Location 9',
                'latitude' => -6.208,
                'longitude' => 106.708,
            ],
            [
                'name' => 'Jakarta Location 10',
                'latitude' => -6.209,
                'longitude' => 106.709,
            ],
            [
                'name' => 'Jakarta Location 11',
                'latitude' => -6.210,
                'longitude' => 106.710,
            ],
            [
                'name' => 'Jakarta Location 12',
                'latitude' => -6.211,
                'longitude' => 106.711,
            ],
            [
                'name' => 'Jakarta Location 13',
                'latitude' => -6.212,
                'longitude' => 106.712,
            ],
            [
                'name' => 'Jakarta Location 14',
                'latitude' => -6.213,
                'longitude' => 106.713,
            ],
            [
                'name' => 'Jakarta Location 15',
                'latitude' => -6.214,
                'longitude' => 106.714,
            ],
        ];

        // $data = array();
        // for ($i = 0; $i < count($startLocations); $i++) {
        //     $data['awal' . $i] = $startLocations[$i];
        //     for ($j = 0; $j < count($startLocations); $j++) {
        //         // dd($startLocations[$i]['latitude']);
        //         $data['awal' . $i][$j] = $this->getNearestLocation($startLocations[$i]['latitude'], $startLocations[$i]['longitude'], $endLocation);
        //         dd($data['awal0'][0]);
        //         unset($array[1]);
        //     }
        // }

        $data = array();
        for ($i = 0; $i < count($startLocations); $i++) {
            $data['awal' . $i] = $startLocations[$i];
            for ($j = 0; $j < count($startLocations); $j++) {
                // dd($startLocations[$i]['latitude']);
                $data['awal' . $i][$j] = $this->getNearestLocation($startLocations[$i]['latitude'], $startLocations[$i]['longitude'], $endLocation);
                // dd($data['awal0'][0]);

                $key = array_search($data['awal' . $i][$j], $endLocation);
                // dd($key);
                if ($key !== false) {
                    unset($endLocation[$key]);
                }
                // dd($endLocation);
            }
        }
        // dd($data);




        // $nearestLocation = $this->getNearestLocation($startLat, $startLng, $locations);

        // echo "Lokasi terdekat: " . $nearestLocation['name'] . "\n";

        return view('test.index', ['nearestLocation' => $data]);
        // return view('test.index', ['nearestLocation' => $nearestLocation]);
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
