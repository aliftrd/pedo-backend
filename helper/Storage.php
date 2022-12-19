<?php

namespace Helper;

class Storage
{

    public static function uploadFromBase64(string $base64string, string $path = "storage")
    {
        $path = self::getRootPath($path); // storage path

        $filename = md5(microtime() . uniqid()) . '.jpg'; // Generate random filename
        $outputfile = $path . $filename; //save as image.jpg in uploads/ folder

        if (!file_exists($path)) {
            mkdir($path, 0777, true); // Create directory if not exists
        }

        $filehandler = fopen($outputfile, 'wb'); //file open with "w" mode treat as text file, and file open with "wb" mode treat as binary file

        fwrite($filehandler, base64_decode($base64string)); // we could add validation here with ensuring count($data)>1

        fclose($filehandler); // clean up the file resource
        return $filename;
    }

    /**
     * Upload file to storage
     *
     * @param array $file
     * @param string $path
     * @return string
     */
    public static function upload(array $file, string $path = "storage")
    {
        $path = self::getRootPath($path); // storage path

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Get file extension
        $filename = md5(microtime() . uniqid()) . '.' . $extension; // Generate random filename

        if (!file_exists($path)) {
            mkdir($path, 0777, true); // Create directory if not exists
        }

        if (move_uploaded_file($file['tmp_name'], $path . $filename)) return $filename;

        return false; // Return false if failed
    }

    /**
     * Delete file from storage
     *
     * @param string $filename
     * @param string $path
     * @return boolean
     */
    public static function delete($path, $lastImageName): bool
    {
        $uri = self::getRootPath($path) . $lastImageName; // storage path

        if (file_exists($uri) && !empty($lastImageName)) { // Check if file exists
            return unlink($uri); // Delete file
        }

        return false; // Return false if failed
    }

    public static function getRootPath(string $path)
    {
        // add trailing slash if not exists
        if (substr($path, -1) != "/") {
            $path .= "/";
        }

        // remove leading slash if exists
        if (substr($path, 0, 1) == '/') return $_SERVER['DOCUMENT_ROOT'] . substr($path, 1);

        // return path
        return $_SERVER['DOCUMENT_ROOT'] . $path;
    }
}
