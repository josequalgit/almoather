<?php

namespace App\Voluum;
use App\Voluum\Endpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Voluum{

    private $headers = [
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json',
        'charset'       => 'utf-8'
    ];

    private $params = [];

    private $endPoint = '';

    function __construct(){}

    public function auth(){
        if($this->checkAuth()){
            return $this;
        }

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'charset'       => 'utf-8'
        ];

        $response = Http::withHeaders($headers)->post(Endpoints::authEndpoint(),[
            "accessId" => "d0e7ac4f-6645-4525-95d2-42a4777fee8a",
            "accessKey" => "7cifGHxYF5zzlaArQk8eQPZWXqUKfJd8RAhd"
        ]);

        $response->onError(function($error){
            $this->log($error);
            return $error;
        });
        $response->throw();
        $response = $response->json();

        if($response && isset($response['token'])){
            $this->setAuthStorage($response['token']);
        }

        return $this;
    }

    public function checkAuth(){
        if(!Storage::disk('local')->exists('voluum/auth')){
            return false;
        }

        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'charset'       => 'utf-8',
            'cwauth-token'  => $this->getAuthStorage()
        ];

        $response = Http::withHeaders($headers)->get(Endpoints::checkAuthEndpoint());
        $response->onError(function($error){
            $this->log($error);
            return $error;
        });
        //$response->throw();
        $response = $response->json();

        if($response && isset($response['alive'])){
            return $response['alive'];
        }
        return false;

    }

    public function get($endPoint,$params = [],$headers = []){
        return $this->auth()->setEndpoint($endPoint)->setHeaders($headers)->setParams($params)->getRequest();
    }

    public function post($endPoint,$params = [],$headers = []){
        return $this->auth()->setEndpoint($endPoint)->setHeaders($headers)->setParams($params)->postRequest();
    }

    public function put($endPoint,$params = [],$headers = []){
        return $this->auth()->setEndpoint($endPoint)->setHeaders($headers)->setParams($params)->putRequest();
    }

    private function getRequest(){
        $response = Http::withHeaders($this->getHeaders())->get($this->getEndpoint(), $this->getParams());
        $response->onError(function($error){
            $this->log($error);
            return $error;
        });
        $response->throw();
        return $response->json();
    }

    private function postRequest(){
        $response = Http::withHeaders($this->getHeaders())->post($this->getEndpoint(), $this->getParams());
        $response->onError(function($error){
            $this->log($error);
            return $error;
        });
        $response->throw();
        return $response->json();
    }

    private function putRequest(){
        $response = Http::withHeaders($this->getHeaders())->put($this->getEndpoint(), $this->getParams());
        $response->onError(function($error){
            $this->log($error);
            return $error;
        });
        $response->throw();
        return $response->json();
    }

    protected function log($error){
        Log::build([
            'driver' => 'single',
            'path' => storage_path().'/logs/vlouum.log',
        ])->error($error);
    }

    public function setHeaders($headers = [],$auth = true){

        if($auth){
            $authValue = $this->getAuthStorage();
            $this->headers['cwauth-token'] = $authValue;
        }

        $this->headers = array_merge($this->headers,$headers);

        return $this;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function setParams($params = []){
        $this->params = $params;
        return $this;
    }

    public function getParams(){
        return $this->params;
    }

    public function setEndpoint($endpoint = []){
        $this->endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint(){
        return $this->endpoint;
    }

    private function getAuthStorage(){
        return Storage::disk('local')->get('voluum/auth');
    }

    private function setAuthStorage($token){
        Storage::disk('local')->put('voluum/auth',$token);
    }

    private function getRequestErrors($error){
        return [
            'url' => $this->getEndpoint(),
            'status' => $error->getStatusCode(),
            'message' => $error->getReasonPhrase(),
        ];
    }

}