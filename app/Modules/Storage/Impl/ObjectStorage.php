<?php
namespace App\Modules\Storage\Impl;

use App\Modules\Storage\StorageInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ObjectStorage implements StorageInterface
{
    public function getFilePathFromUrl($url)
    {
        $url  = parse_url($url);
        $path = $url['path'] ?? '';

        return Str::replace('/uploads/', '', $path);
    }

    public function checkFileExists($path)
    {
        return Storage::disk('s3')->exists($path) ? true : false;
    }

    public function getFile($path)
    {
        return Storage::disk('s3')->get($path);
    }

    public function getFileAsResponse($path)
    {
        return Storage::disk('s3')->response($path);
    }

    public function getFileSize($path)
    {
        return Storage::disk('s3')->size($path);
    }

    public static function getUrl($file_path)
    {
        if (Storage::disk('s3')->exists($file_path)) {
            return asset('uploads/' . $file_path);
        }

        return null;
    }

    public function store($path, $file, $name = '')
    {
        if ($name) {
            $url = Storage::disk('s3')->putFileAs($path ?? 'files', $file, $name);

            return $url;
        }

        $url = Storage::disk('s3')->put($path ?? 'files', $file);

        return $url;
    }

    public function getUniqueIfHasSameFileName($basename, $same_name_counts)
    {
        $file_name = pathinfo($basename)['filename'];
        $file_type = pathinfo($basename)['extension'] ?? '';

        return $file_name . '-' . $same_name_counts . '.' . $file_type;
    }

    public function delete($path)
    {
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        }

        return true;
    }
}
