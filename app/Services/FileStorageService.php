<?php

namespace App\Services;

use App\Services\Contracts\FileStorageServiceContract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile as UploadedFileAlias;

class FileStorageService implements FileStorageServiceContract
{

    public static function upload(UploadedFileAlias|string $file): string
    {
        if(is_string($file)){
            return str_replace('public/storage', '', $file);
        }

       $filePath = 'public/' . static::randomName() . '.' . $file->getClienOriginalExtansion();
        Storage::put($filePath, File::get($file));

        return $filePath;
    }

    public static function remove(string $file)
    {
        // TODO: Implement remove() method.
    }

    protected static function randomName(): string
    {
        return Str::random() . '_' . time();
    }
}
