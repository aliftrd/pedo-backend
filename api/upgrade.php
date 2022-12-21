<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Helper\Storage;
use Models\UserAccessToken;
use Models\UserUpgradeRequest;
use Rakit\Validation\Validator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Models\UserUpgradeRequestImage;

$authorization = get_bearer_token();
if (!$authorization['status']) {
    return error_response($authorization['message'], null, 401);
}

$user = UserAccessToken::where('token', $authorization['message']);
if ($user->count() < 1) {
    return error_response('Kredensial tidak valid', null, 401);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $requestPending = UserUpgradeRequest::where('user_id', $user->first()->user_id)->where('status', 'Pending')->count();

        if ($requestPending > 0) {
            return error_response('Anda sudah memiliki request upgrade yang belum selesai', null, 400);
        }

        return success_response('Anda tidak memiliki request upgrade yang belum selesai', null, 200);
    case 'POST':
        if (count($_POST) < 1) {
            $_POST = json_decode(file_get_contents('php://input'), true) ?? [];
        }

        $requestPending = UserUpgradeRequest::where('user_id', $user->first()->user_id)->where('status', 'Pending')->count();

        if ($requestPending > 0) {
            return error_response('Anda sudah memiliki request upgrade yang belum selesai', null, 400);
        }

        $validator = new Validator;
        $validation = $validator->validate($_POST, [
            'village_id' => 'required|numeric',
            'phone' => 'required|numeric',
            'pet' => 'required',
            'pet_with_you' => 'required',
            'pet_home' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            return error_response('Error Validasi', $errors->firstOfAll(), 400);
        }

        $imagePath = 'storage/images/user/upgrade';
        $imageNames = [
            Storage::uploadFromBase64($_POST['pet'], $imagePath), // Pet Image
            Storage::uploadFromBase64($_POST['pet_with_you'], $imagePath), // Pet with you Image
            Storage::uploadFromBase64($_POST['pet_home'], $imagePath), // Pet Home Image
        ];
        try {
            Capsule::beginTransaction();
            $userUpgradeRequest = UserUpgradeRequest::create([
                'user_id' => $user->first()->user_id,
                'village_id' => $_POST['village_id'],
                'phone' => $_POST['phone'],
                'status' => UserUpgradeRequest::PENDING,
            ]);

            foreach ($imageNames as $imageName) {
                UserUpgradeRequestImage::create([
                    'user_upgrade_request_id' => $userUpgradeRequest->id,
                    'path' => $imageName,
                ]);
            }
            Capsule::commit();
            return success_response('Permintaan upgrade berhasil dikirim', null, 201);
        } catch (\Exception $e) {
            Capsule::rollback();
            foreach ($imageNames as $imageName) {
                Storage::delete($imagePath, $imageName);
            }

            return error_response('Terjadi kesalahan', 'Server Error', 500);
        }
    default:
        return error_response('Method Not Allowed');
}
