<?php

namespace Helper;

class Storage
{
    /**
     * Upload file to storage
     *
     * @param array $file
     * @param string $path
     * @return string
     */
    public static function upload(array $file, string $path = "storage")
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . $path; // storage path
        if (substr($path, -1) != "/") { // add trailing slash if not exists
            $path .= "/";
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // Get file extension
        $filename = md5(microtime() . uniqid()) . '.' . $extension; // Generate random filename

        if (!file_exists($path)) {
            mkdir($path, 0777, true); // Create directory if not exists
        }

        if (move_uploaded_file($file['tmp_name'], $path . $filename)) { // Move file to storage
            return $filename; // Return filename
        }

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
        if (substr($path, -1) != "/") { // add trailing slash if not exists
            $path .= "/";
        }

        $uri = $_SERVER['DOCUMENT_ROOT'] . $path . $lastImageName; // storage path

        if (file_exists($uri) && !empty($lastImageName)) { // Check if file exists
            return unlink($uri); // Delete file
        }

        return false; // Return false if failed
    }
}
