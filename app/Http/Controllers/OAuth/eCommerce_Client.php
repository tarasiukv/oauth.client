<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
//use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class eCommerce_Client extends Controller
{
    public function getLogin (Request $request) {
        $request->session()->put('state', $state =  Str::random(40));
        $query = http_build_query([
            'client_id' => '9503f541-722a-426e-8d87-8f549338ae7f',
            'redirect_uri' => 'http://127.0.0.1:8001/callback',
            'response_type' => 'code',
            'scope' => 'view-user',
            'state' => $state
        ]);
        return redirect('http://127.0.0.1:8000/oauth/authorize?' . $query);
    }
    public function getCallback (Request $request) {
        $state = $request->session()->pull('state');

        throw_unless(strlen($state) > 0 && $state == $request->state, InvalidArgumentException::class);

        $response = Http::asForm()->post('http://127.0.0.1:8000/oauth/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => '9503f541-722a-426e-8d87-8f549338ae7f',
                'client_secret' => '5N9RcBgYtxoidvbnGD7Sq9BU5PwSJyiZT9swgFEg',
                'redirect_uri' => 'http://127.0.0.1:8001/callback',
                'code' =>$request->code
            ]);
        $request->session()->put($response->json());
        return redirect(route('oauth.connect'));
    }
    public function connectUser (Request $request) {
        $access_token = $request->session()->get('access_token');
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization'  => 'Bearer ' . $access_token
        ])->get('http://127.0.0.1:8000/api/user');
        return $response->json();
    }
}
