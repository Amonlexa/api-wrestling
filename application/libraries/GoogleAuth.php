<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Googleauth {

    public function verify_token($id_token)
    {
        // Подключаем автозагрузчик Composer
        require_once FCPATH . 'vendor/autoload.php';

        // Создаем клиент Google
        $client = new \Google_Client(); // <-- обрати внимание на "\" и "new"
        $client->setClientId('437866241489-ogfvd7r0a8njpals5qks4kdh3h3348qh.apps.googleusercontent.com');

        try {
            $payload = $client->verifyIdToken($id_token);

            if ($payload) {
                return $payload;
            }
        } catch (\Exception $e) {
            log_message('error', 'Google Auth Error: ' . $e->getMessage());
        }

        return false;
    }
}