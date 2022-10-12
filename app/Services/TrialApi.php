<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TrialApi
{
 protected $url;
 protected $api_key;

 public function __construct()
 {
     $this->url = 'https://trial.craig.mtcserver15.com/api/properties';
     $this->api_key = env('TEST_API_KEY');
 }

 public function getResponse(){
    $url = $this->url;
    $api_key = $this->api_key;
        $response = Http::get($url,[
            'api_key' => $api_key
        ]);
        return $response->body();
 }
}
?>