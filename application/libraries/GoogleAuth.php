<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use \Google_Client;
use \Google_Service_Oauth2;


class GoogleAuth {

    public function verify_token($id_token)
    {
        require_once FCPATH . 'vendor/autoload.php';

        $client = new \Google_Client();
        $client->setClientId('YOUR_CLIENT_ID');

        try {
            $payload = $client->verifyIdToken($id_token);
            return $payload ? $payload : false;
        } catch (\Exception $e) {
            log_message('error', 'Google Auth Error: ' . $e->getMessage());
            return false;
        }
    }
}