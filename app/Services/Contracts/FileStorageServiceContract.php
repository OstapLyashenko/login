<?php

namespace App\Services\Contracts;

use GuzzleHttp\Psr7\UploadedFile;

interface FileStorageServiceContract
{
public static function upload(UploadedFile|string $file): string;
public static function remove(string $file);
}
