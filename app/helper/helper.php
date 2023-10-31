<?php
if (!function_exists('apiResponse')) {
    function apiResponse($message = null, $status = 200, $data = null) {
        return response()->json(['message' => $message, 'data' => $data, 'status'=>$status], $status);
    }
}


if (!function_exists('createFolder')) {
    function createFolder($folderPath) {
        $storageDisk = config('filesystems.default');

        if ($storageDisk === 's3') {
            Storage::disk('s3')->put($folderPath . '/', '');
        } else {
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
        }
    }
}

  if (!function_exists('uploadToS3')) {
    function uploadToS3($image, $directory, $fileName) {
        $imagePath = Storage::disk('s3')->put($directory, $image, $fileName);
        return Storage::disk('s3')->url($imagePath);
    }
}
if (!function_exists('uploadToLocal')) {
    function uploadToLocal($image, $filePath, $fileName) {
        $image->move(public_path($filePath), $fileName);
        return $filePath . $fileName;
    }
}

if (!function_exists('uploadWebp')) {
    function uploadWebp($image, $filePath, $fileName) {
        $image = ImageUpload::make($image);
        $image->encode('webp', 75);
        $image->save(public_path($filePath . $fileName . '.webp'));
        return $filePath . $fileName . '.webp';
    }
}



if (!function_exists('uploadImage')) {
    function uploadImage($image, $fileName, $filePath) {
        createFolder($filePath);
        $ext = $image->getClientOriginalExtension();
        $fileName = Str::slug($fileName) . '-' . time();
        $fileFullName = time() . '-' . $image->getClientOriginalName();
        $storageDisk = config('filesystems.default');

        if (in_array($ext, ['pdf', 'svg', 'jiff', 'webp'])) {
            if ($storageDisk === 's3') {
                $imagePath = uploadToS3($image, 'img', $fileFullName);
            } else {
                $imagePath = uploadToLocal($image, $filePath, $fileFullName);
            }
        } else {
            if ($storageDisk === 's3') {
                $imagePath = uploadToS3($image, 'img', $fileFullName);
            } else {
                $imagePath = uploadWebp($image, $filePath, $fileName);
            }
        }

        return $imagePath;
    }
}


if (!function_exists('removeImage')) {
    function removeImage($image) {
        $storageDisk = config('filesystems.default');

        if ($storageDisk === 's3') {
            $imagePath = str_replace(Storage::disk('s3')->url('/'), '', $image);
            Storage::disk('s3')->delete($imagePath);
        } else {
            $imagePath = str_replace(env('APP_URL'), '', $image);
            $imagePath = str_replace(env('AWS_URL',env('APP_URL')), '', $image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
}
