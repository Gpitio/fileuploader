<?php

namespace gpit\fileuploader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileUploader
{
    public static function uploadFile(Request $req) {
        ini_set('max_execution_time', 600);
        ini_set('upload_max_filesize', '50M');
        ini_set('post_max_size', '50M');

        try {
            $name = $req->input('name');
            $file = $req->input('file');
            
            if (!$name || !$file) {
                throw new Exception('Invalid file or name provided.');
            }

            $filename = uniqid() . '_' . basename($name);
            $pathname = "files/" . $filename;

            if (!self::isValidBase64($file)) {
                throw new Exception('Invalid base64 file data.');
            }

            Storage::put('public/' . $pathname, base64_decode($file));

            return ['success' => true, 'path' => $pathname];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private static function isValidBase64($string) {
        $decoded = base64_decode($string, true);
        return $decoded !== false && base64_encode($decoded) === $string;
    }
}
