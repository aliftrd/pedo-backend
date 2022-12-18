<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Helper\Storage;
use Models\UserAccessToken;
use Models\UserUpgradeRequest;
use Rakit\Validation\Validator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Models\UserUpgradeRequestImage;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $authorization = get_bearer_token();
        if (!$authorization['status']) {
            return error_response($authorization['message'], null, 401);
        }

        $user = UserAccessToken::where('token', $authorization['message']);
        if ($user->count() < 1) {
            return error_response('Kredensial tidak valid', null, 401);
        }

        $requestPending = UserUpgradeRequest::where('user_id', $user->first()->user_id)->where('status', 'Pending')->count();

        if ($requestPending > 0) {
            return error_response('Anda sudah memiliki request upgrade yang belum selesai', null, 400);
        }

        $validator = new Validator;
        $imageValidatorRule = 'required|uploaded_file|max:2M|mimes:jpeg,png';
        $validation = $validator->validate($_POST, [
            'pet' => $imageValidatorRule,
            'pet_with_you' => $imageValidatorRule,
            'pet_home' => $imageValidatorRule,
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
