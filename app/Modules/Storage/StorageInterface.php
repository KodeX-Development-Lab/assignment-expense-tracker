<?php
namespace App\Modules\Storage;

interface StorageInterface
{
    public function store($path, $file);
    public function getFilePathFromUrl($url);
    public function delete($path);
}
