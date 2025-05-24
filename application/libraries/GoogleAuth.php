<?php defined('BASEPATH') OR exit('No direct script access allowed');

 class Googleauth {

    public function verifyToken($id_token)
    {
   

        $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($id_token);
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return false;
        }

        $payload = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $payload ?: false;
    }

   
}