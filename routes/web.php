<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/find_halyk_pos", function (Request $request) {
    $client = new Client(['headers' => ['Content-Type' => 'application/json'], 'timeout' => 2]);
    $iPs = [];
    for ($i = 100; $i < 254; $i++) {
        $ip = "10.11.12.{$i}";
        try {
            $client->request("POST", "http://{$ip}:8080", [
                "json" => (object)[
                    "task" => "ping",
                    "data" => (object) [
                        "amount" => "0"
                    ]
                ]
            ]);
            $iPs[] = $ip;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    return response()->json($iPs);
});
