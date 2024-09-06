<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function update(Request $request, User $user)
    {
        if ($request->ajax()) {
            $field = $request->name; 
            $value = $request->value;

            $user->find($request->pk)->update([$field => $value]);
            return response()->json(['success' => true]);
        }

    }

    public function updateAdmin(Request $request, User $user)
    {
        if ($request->ajax()) {
            $field = $request->name; 
            $value = $request->value;

            $user->find($request->pk)->update([$field => $value]);
            return response()->json(['success' => true]);
        }

    }

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img/admin/fotoUser');
            $image->move($destinationPath, $name);

            // Hapus gambar lama jika ada
            if ($user->gambar) {
                $oldImage = public_path('/img/admin/fotoUser/'.$user->gambar);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            // Simpan nama gambar baru di database
            $user->gambar = $name;
            $user->save();
        }

        return response()->json(['success' => true, 'image' => asset('img/admin/fotoUser/' . $name)]);
    }
    public function updateProfileAdmin(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img/admin/fotoUser');
            $image->move($destinationPath, $name);

            // Hapus gambar lama jika ada
            if ($user->gambar) {
                $oldImage = public_path('/img/admin/fotoUser/'.$user->gambar);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            // Simpan nama gambar baru di database
            $user->gambar = $name;
            $user->save();
        }

        return response()->json(['success' => true, 'image' => asset('img/admin/fotoUser/' . $name)]);
    }
}