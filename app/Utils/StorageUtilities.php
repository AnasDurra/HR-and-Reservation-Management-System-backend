<?php


namespace App\Utils;


use Illuminate\Support\Facades\Storage;

class StorageUtilities
{

    // store personal photo in local storage
    public static function storePersonalPhoto($file): string
    {
        // store file in local storage
        $file->store('public/personal_photos');

        // get file name
        $fileName = $file->hashName();

        // return image url
        return asset('storage/personal_photos/' . $fileName);
    }

    // delete personal photo from local storage
    public static function deletePersonalPhoto($url): void
    {
        // get file name
        $fileName = basename($url);

        // delete file from local storage
        unlink(storage_path('app/public/personal_photos/' . $fileName));
    }

    // store certificate in local storage
    public static function storeCertificate($file): string
    {
        // store file in local storage
        $file->store('public/certificates');

        // get file name
        $fileName = $file->hashName();

        // return image url
        return asset('storage/certificates/' . $fileName);
    }


    public static function replaceCertificate($oldFileUrl, $newFile): string
    {
        // delete the old file
        if (Storage::disk('public')->exists($oldFileUrl)) {
            Storage::disk('public')->delete($oldFileUrl);
        }

        // upload the new file
        $fileName = time() . '_' . $newFile->getClientOriginalName();
        $filePath = 'certificates/' . $fileName;
        Storage::disk('public')->put($filePath, file_get_contents($newFile));

        // return file url
        return asset('storage/' . $filePath);
    }

    public static function deleteFiles($urls): void
    {
        foreach ($urls as $url) {
            if (Storage::disk('public')->exists($url)) {
                Storage::disk('public')->delete($url);
            }
        }
    }

}
