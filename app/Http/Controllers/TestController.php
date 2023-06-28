<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TestController extends Controller
{
    public function index()
    {
        //data tambahan
        $tpaPecuk = Lokasi::find(1)->toArray();
        //data tambahan

        $endLocation = Lokasi::where('id', '!=', 1)->get()->toArray();

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

        // dd($outputArray[1]['itemCount']);
        $data = array();
        for ($i = 0; $i < count($startLocations); $i++) {
            $data[$i][0] = $startLocations[$i]; //memasukan data driver
            $data[$i][1] = $tpaPecuk; //memasukan data tpa pecuk ke setiap driver

            for ($j = 2; $j <= $outputArray[$i]['itemCount'] + 1; $j++) {
                // $data[$i][$j] = $startLocations[$i];

                $data[$i][$j] = $this->getNearestLocation($startLocations[$i]['lat'], $startLocations[$i]['lng'], $endLocation);

                $key = array_search($data[$i][$j], $endLocation);
                if ($key !== false) {
                    unset($endLocation[$key]);
                }
            }
        }
        // dd($data);

        $locations = [];

        foreach ($data as $item) {
            foreach ($item as $location) {

                $locations[] = [

                    $location["name"],
                    $location["lng"],
                    $location["lat"],
                ];
            }
        }

        $lines = [];
        foreach ($data as $item) {
            foreach ($item as $location) {
                $lines[] = [

                    "lng" => $location["lng"],
                    "lat" => $location["lat"],
                ];
            }
        }
        // dd($lines);
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
