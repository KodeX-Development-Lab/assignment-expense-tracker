<?php
namespace App\Settings;

use App\Modules\Storage\Impl\ObjectStorage;
use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $name;
    public string $logo;

    public static function group(): string
    {
        return 'general';
    }

    public function logoUrl()
    {
        $storage = new ObjectStorage;

        return ($this->logo && $storage->checkFileExists($this->logo)) ? $storage->getUrl( $this->logo) : null;
    }

}
