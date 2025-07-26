<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GeneralSettingsRequest;
use App\Modules\Storage\Impl\ObjectStorage;
use App\Modules\Storage\StorageInterface;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class GeneralSettingsController extends Controller
{
    private StorageInterface $storage;

    public function __construct(ObjectStorage $storage)
    {
        $this->storage = $storage;
    }

    public function show(GeneralSettings $settings)
    {
        return response()->json([
            'status'  => true,
            'data'    => [
                'setting' => [
                    'name'     => $settings->name,
                    'logo_url' => $settings->logoUrl(),
                ],
            ],
            'message' => '',
        ], 200);
    }

    public function update(
        GeneralSettingsRequest $request,
        GeneralSettings $settings
    ) {
        $settings->name = $request->input('name');
        $settings->save();

        return response()->json([
            'status'  => true,
            'data'    => [
                'setting' => [
                    'name'     => $settings->name,
                    'logo_url' => $settings->logoUrl(),
                ],
            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function uploadLogo(Request $request, GeneralSettings $settings)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $new_path = $this->storage->store("logos", $request->file('logo'));

        if ($settings->logo) {
            $this->storage->delete($settings->logo);
        }

        $settings->logo = $new_path;
        $settings->save();

        return response()->json([
            'status'  => true,
            'data'    => [
                'setting' => [
                    'name'     => $settings->name,
                    'logo_url' => $settings->logoUrl(),
                ],
            ],
            'message' => 'Successfully uploaded',
        ], 200);
    }
}
