<?php
header('Content-Type: application/json');
require_once('../vendor/autoload.php');

use Helper\Storage;
use Models\Animal;
use Models\AnimalImage;
use Models\UserAccessToken;
use Models\UserMeta;
use Rakit\Validation\Validator;

$authorization = get_bearer_token();
if (!$authorization['status']) {
    return error_response($authorization['message'], null, 401);
}

$token = $authorization['message'];
$isLogin = UserAccessToken::where('token', $token)->first();
if (!$isLogin || is_null($isLogin)) {
    return error_response('Kredensial tidak valid', null, 401);
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $total = Animal::count(); // Total of records
        $current_page = $_GET['page'] ?? 1; // Page indicator
        $per_page = 5; // Limit per page
        $offset = ($current_page - 1) * $per_page; // Skip records
        $last_page = ceil($total / $per_page); // Total page

        $prev_page_url = $current_page < 2 ? null : base_url('api/partners.php?page=' .  ($current_page - 1)); // Previous page link
        $next_page_url = $current_page == $last_page ? null : base_url('api/partners.php?page=' . ($current_page + 1)); // Next page link

        $animal_data = Animal::with(['user_meta.user', 'user_meta.village', 'animal_images', 'animal_type', 'animal_breed'])
            ->findByPartner($isLogin->user_id)
            ->findByStatus($_GET['status'] ?? 'pending')
            ->offset($offset)
            ->limit($per_page)
            ->orderBy('id', 'DESC');

        $data = [
            'current_page' => $current_page,
            'data' => $animal_data->get(),
            'form' => $offset + 1,
            'next_page_url' => $next_page_url,
            'per_page' => $per_page,
            'prev_page_url' => $prev_page_url,
            'to' => $offset + $per_page,
        ];

        return success_response('Berhasil mengambil data', $data);
    case 'POST':
        if (isset($_GET['method']) && $_GET['method'] == 'update') {
            return updateData();
        } else {
            return insertData();
        }
    default:
        return error_response('Method not allowed');
}

function insertData()
{
    if (count($_POST) < 1) {
        $_POST = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'images' => 'required|array',
        'animal_type_id' => 'required',
        'animal_breed_id' => 'required',
        'title' => 'required',
        'description' => 'required',
        'is_paid' => 'required|boolean',
        'price' => 'required',
        'gender' => 'required',
        'primary_color' => 'required',
        'secondary_color' => 'required'
    ]);

    if ($validation->fails()) {
        $errors = $validation->errors();

        return error_response('Error Validasi', $errors->firstOfAll(), 400);
    }

    $user_meta = UserMeta::where('user_id', $GLOBALS['isLogin']->user_id)->where('type', 'petowner')->first();

    $animal = Animal::create([
        'animal_type_id' => $_POST['animal_type_id'],
        'animal_breed_id' => $_POST['animal_breed_id'],
        'user_meta_id' => $user_meta->id,
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'is_paid' => $_POST['is_paid'],
        'price' => $_POST['price'],
        'gender' => $_POST['gender'],
        'primary_color' => $_POST['primary_color'],
        'secondary_color' => $_POST['secondary_color'],
        'status' => 'pending'
    ]);

    foreach ($_POST['images'] as $image) {
        $images = Storage::uploadFromBase64($image, 'storage/images/animals');
        AnimalImage::create([
            'animal_id' => $animal->id,
            'path' => $images
        ]);
    }

    return success_response('Berhasil menambahkan data', 201);
}


function updateData()
{
    if (count($_POST) < 1) {
        $_POST = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    $validator = new Validator;
    $validation = $validator->validate($_POST, [
        'id' => 'required',
        'images' => 'required',
        'animal_type_id' => 'required',
        'animal_breed_id' => 'required',
        'title' => 'required',
        'description' => 'required',
        'is_paid' => 'required',
        'price' => 'required',
        'gender' => 'required',
        'primary_color' => 'required',
        'secondary_color' => 'required'
    ]);

    if ($validation->fails()) {
        $errors = $validation->errors();

        return error_response('Error Validasi', $errors->firstOfAll(), 400);
    }

    Animal::findOrFail($_POST['id'])->update([
        'animal_type_id' => $_POST['animal_type_id'],
        'animal_breed_id' => $_POST['animal_breed_id'],
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'is_paid' => $_POST['is_paid'],
        'price' => $_POST['price'],
        'gender' => $_POST['gender'],
        'primary_color' => $_POST['primary_color'],
        'secondary_color' => $_POST['secondary_color'],
        'status' => 'pending'
    ]);

    $animalImages = AnimalImage::where('animal_id', $_POST['id'])->get();
    foreach ($animalImages as $animalImage) {
        Storage::delete('storage/images/animal', $animalImage->get);
        $animalImage->delete();
    }

    foreach ($_POST['images'] as $image) {
        $images = Storage::uploadFromBase64($image, 'storage/images/animals');
        AnimalImage::create([
            'animal_id' => $_POST['id'],
            'path' => $images
        ]);
    }

    return success_response('Berhasil mengubah data', 202);
}
