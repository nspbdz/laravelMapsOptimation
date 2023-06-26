<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MapsController extends Controller
{
    public function index()
    {

        $locations = [
            ['Mumbai', 19.0760, 72.8777],
            ['Pune', 18.5204, 73.8567],
            ['Bhopal ', 23.2599, 77.4126],
            ['Agra', 27.1767, 78.0081],
            ['Delhi', 28.7041, 77.1025],
            ['Rajkot', 22.2734719, 70.7512559],
        ];

        $lines = [
            ["lat" => 19.0760, "lng" => 72.8777],
            ["lat" => 18.5204, "lng" => 73.8567],
            ["lat" => 23.2599, "lng" => 77.4126],
            ["lat" => 27.1767, "lng" => 78.0081],
            ["lat" => 28.7041, "lng" => 77.1025],
            ["lat" => 22.2734719, "lng" => 70.7512559],
        ];

        // $locations = DB::table('lokasi')->get();
        return view('maps.maps', ['locations' => $locations, 'lines' => $lines]);
    }
}
