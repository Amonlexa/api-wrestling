<?php
include_once (dirname(__FILE__) ."/..". "/services/Parameters.php");
defined('BASEPATH') OR exit('No direct script access allowed');
class CityAdd extends Parameters {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('cities');
    }

    public function index()
    {
        $dt = $this->getParameters();
        $name = $dt['requests']['name'] ?? null;
        $type = $dt['requests']['type'] ?? null;
        $region = $dt['requests']['region'] ?? null;
        $guid = $dt['requests']['guid'] ?? null;
        $lat = $dt['requests']['lat'] ?? null;
        $lon = $dt['requests']['lon'] ?? null;
        $code = $dt['requests']['code'] ?? null;
        $district = $dt['requests']['district'] ?? null;


        $dt['response']['add'] = [
            'message' => "Есть город с таким уникальным номером",
            'id' => "Не отправлено"
        ];

        if($this->cities->isDuplicateCity($guid)) {
            if (isset($name) && isset($region) && isset($type)) {
                $cityId = $this->cities->add();
                $data = [
                    'id' => $cityId,
                    'status' => "1",
                    'name'=> $name,
                    'type'=> $type,
                    'region'=> $region,
                    'guid' => $guid,
                    'latitude' => $lat,
                    'longitude' => $lon,
                    'code' => $code,
                    'district' => $district,                    
                ];
                $this->cities->setById($data);
                $dt['response']['add'] = [
                    'message' => "Успешно добавлен",
                    'id' => strval($cityId)
                ];
        }
    }
    $this->load->view('message', $dt);
}

    
}