<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserTelegramAuth extends CI_Controller {


    private $bot_token = '7317706746:AAEK-rcHrnxtjf-AyEhsqbzfHSnw119fLKE'; // Замените на реальный токен

    // Метод, который отображает страницу с виджетом
    public function index() {
        $this->load->view('telegram');
    }

    // Метод, который принимает и проверяет данные от виджета
    public function callback() {
        // 1. Получаем данные POST от виджета
        $auth_data = $this->input->post();

        // 2. Проверяем наличие обязательных полей
        if (empty($auth_data['hash']) || empty($auth_data['auth_date'])) {
            echo json_encode(['error' => 'Invalid data']);
            return;
        }

        // 3. Проверяем подпись данных
        $check_result = $this->verify_telegram_data($auth_data);

        if ($check_result) {
            // 4. Данные проверены - можно авторизовать пользователя
            $user_data = [
                'id' => $auth_data['id'],
                'first_name' => $auth_data['first_name'],
                'last_name' => isset($auth_data['last_name']) ? $auth_data['last_name'] : '',
                'username' => isset($auth_data['username']) ? $auth_data['username'] : '',
                'auth_date' => $auth_data['auth_date']
            ];

            // 5. Сохраняем в сессию или БД
            $this->session->set_userdata('telegram_user', $user_data);

            echo json_encode(['success' => true, 'user' => $user_data]);
        } else {
            echo json_encode(['error' => 'Data verification failed']);
        }
    }

    // Основная функция проверки подписи Telegram
    private function verify_telegram_data($auth_data) {
        $bot_token = $this->bot_token;
        
        // 1. Извлекаем хэш и удаляем его из данных для проверки
        $received_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        
        // 2. Сортируем поля в алфавитном порядке
        ksort($auth_data);
        
        // 3. Формируем строку данных
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        $data_check_string = implode("\n", $data_check_arr);
        
        // 4. Вычисляем секретный ключ из токена бота
        $secret_key = hash('sha256', $bot_token, true);
        
        // 5. Вычисляем HMAC-хэш
        $hmac_hash = hash_hmac('sha256', $data_check_string, $secret_key);
        
        // 6. Сравниваем вычисленный хэш с полученным
        if (strcmp($hmac_hash, $received_hash) === 0) {
            // 7. Дополнительно проверяем свежесть данных (не старше 1 дня)
            if ((time() - $auth_data['auth_date']) < 86400) {
                return true;
            }
        }
        
        return false;
    }
}