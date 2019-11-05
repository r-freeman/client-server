<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redirect', function () {

    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://client-server.loc/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    return redirect('http://community-poll.loc/oauth/authorize?'.$query);
});

Route::get('/callback', function (Illuminate\Http\Request $request) {
    $http = new \GuzzleHttp\Client;

    $response = $http->post('http://community-poll.loc/oauth/token', [
        'form_params' => [
            'client_id' => '3',
            'client_secret' => 'm7Pd2ZSBWIMZNgIKvNPr4zOD1FMCXdAu9O35bINb',
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'http://client-server.loc/callback',
            'code' => $request->code,
        ],
    ]);
    return json_decode((string) $response->getBody(), true);
});
