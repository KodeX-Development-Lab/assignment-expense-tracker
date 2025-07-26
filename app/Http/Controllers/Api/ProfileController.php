<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Storage\Impl\ObjectStorage;
use App\Modules\Storage\StorageInterface;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private StorageInterface $storage;

    public function __construct(ObjectStorage $storage)
    {
        $this->storage = $storage;
    }

    public function show()
    {
        $user = auth()->user();

        return response()->json([
            'status'  => true,
            'data'    => [
                'user' => $user,
            ],
            'message' => '',
        ], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1',
            'bio'  => 'nullable|string',
        ]);

        $user       = auth()->user();
        $user->name = $request->name;
        $user->bio  = $request->bio ?? $user->bio;
        $user->save();

        return response()->json([
            'status'  => true,
            'data'    => [
                'user' => $user,

            ],
            'message' => 'Successfully updated',
        ], 200);
    }

    public function uploadProfile(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $user = auth()->user();

        $new_path = $this->storage->store("profiles", $request->file('photo'));

        $old_path = $user->photo ? $this->storage->getFilePathFromUrl($user->photo) : null;

        if ($old_path) {
            $this->storage->delete($old_path);
        }

        $user->photo = $new_path;
        $user->save();

        return response()->json([
            'status'  => true,
            'data'    => [
                'user' => $user,
            ],
            'message' => 'Successfully uploaded',
        ], 200);
    }
}
