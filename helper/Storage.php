<?php

namespace Helper;

class Storage
{
    public static function upload(array $file, string $path = "storage")
    {
        if (substr($path, -1) != "/") {
            $path .= "/";
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = md5(microtime() . uniqid()) . '.' . $extension;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // upload file to folder path
        if (move_uploaded_file($file['tmp_name'], $path . $filename)) {
            return $filename;
        }

        return false;
    }
}
