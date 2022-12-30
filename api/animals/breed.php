<?php
header('Content-Type: application/json');
require_once('../../vendor/autoload.php');

use Models\AnimalBreed;
use Models\UserAccessToken;
use Rakit\Validation\Validator;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $authorization = get_bearer_token();
        if (!$authorization['status']) {
            return error_response($authorization['message'], null, 401);
        }

        $user = UserAccessToken::where('token', $authorization['message'])->count();
        if ($user < 1) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        $validator = new Validator();
        $validation = $validator->validate($_GET, [
            'animal_type_id' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            return error_response('Error Validasi', $errors->firstOfAll(), 400);
        }

        $data = AnimalBreed::getByAnimalType($_GET['animal_type_id'])
            ->orderBy('title', 'ASC')
            ->get();

        return success_response('Berhasil mengambil data', $data);
    default:
        return error_response('Method Not Allowed');
}
