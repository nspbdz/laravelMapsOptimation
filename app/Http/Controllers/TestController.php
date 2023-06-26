<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $endLocation = Lokasi::get()->toArray();

        $startLocations = [
            [
                'name' => 'parung panjang',
                'lat' => -6.368107,
                'lng' => 106.553387
            ],

            [
                'name' => 'Indramayu',
                'lat' => -6.327583,
                'lng' => 108.324936
            ],


            [
                'name' => 'Jakarta Location 1',
                'lat' => -6.200,
                'lng' => 106.700,
            ],
        ];


        $totalEndLocations = count($endLocation); // Jumlah total lokasi yang akan dibagi
        $totalDrivers = count($startLocations); // Jumlah total driver

        $locationsPerDriver = floor($totalEndLocations / $totalDrivers); // Jumlah lokasi per driver (pembulatan ke bawah)

        $remainingItems = $totalEndLocations % $totalDrivers; // Sisa lokasi setelah pembagian

        // Menginisialisasi array untuk menyimpan jumlah lokasi per driver
        $itemCounts = array_fill(0, $totalDrivers, $locationsPerDriver);

        // Memasukkan sisa lokasi ke driver pertama
        for ($i = 0; $i < $remainingItems; $i++) {
            $itemCounts[$i]++;
        }

        // Menyusun hasil pembagian ke dalam array
        for ($i = 0; $i < $totalDrivers; $i++) {
            $outputArray[] = array(
                'driver' => ($i + 1),
                'itemCount' => $itemCounts[$i]
            );
        }


        $data = array();
        for ($i = 0; $i < count($startLocations); $i++) {
            $data['driver' . $i] = $startLocations[$i];

            for ($j = 0; $j < $outputArray[$i]['itemCount']; $j++) {
                $data['driver' . $i][$j] = $this->getNearestLocation($startLocations[$i]['lat'], $startLocations[$i]['lng'], $endLocation);

                $key = array_search($data['driver' . $i][$j], $endLocation);
                if ($key !== false) {
                    unset($endLocation[$key]);
                }
            }
        }
        dd($data);



        return view('test.index');
    }

    function getNearestLocation($startLat, $startLng, $locations)
    {
        $nearestLocation = null;
        $nearestDistance = null;

        foreach ($locations as $location) {
            $lat = $location['lat'];
            $lng = $location['lng'];

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
