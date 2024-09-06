<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('admin.user.index',compact('users'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $request->validate([
            
            'email' => 'required',
            'password' => 'required',
            'jenis_kelamin' => 'required',
            'gambar' => 'required||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'noHp' => 'required',

        ]);
            $data = $request->all();
            $data['user_id'] = $user_id;
            $data['slug'] = Str::random(20);
            $data['type'] = 0;

            if ($request->hasFile('gambar')) { // Periksa apakah ada file gambar yang diunggah
                $gambar = $request->file('gambar');
                $destinationPath = 'img/admin/fotoUser/';
                $profileGambar = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
                $gambar->move(public_path($destinationPath), $profileGambar); // Simpan file gambar ke dalam folder public/gambar
                $data['gambar'] =  $profileGambar; // Simpan path gambar ke dalam database
            } else {
                return redirect()->back()->withInput()->withErrors(['gambar' => 'The gambar field is required.']);
            }
            
        
        User::create($data);

         
        return redirect()->route('user.index')

                        ->with('success','User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([

            'email' => 'required',
            'jenis_kelamin' => 'required',
            'gambar' => 'nullable||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'noHp' => 'required',

        ]);

        $input = $request->all();
        $input['slug'] = Str::random(20);

        if ($request->hasFile('gambar')) {

            if ($user->gambar) {
                $oldImagePath = public_path('img/admin/fotoUser/' . $user->gambar);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $gambar = $request->file('gambar');
            $destinationPath = 'img/admin/fotoUser/';
            $profileGambar = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
            $gambar->move(public_path($destinationPath), $profileGambar);
            $input['gambar'] = "$profileGambar";
        } else {
            unset($input['gambar']); 
        }
        
        $user->update($input);
        
        return redirect()->route('user.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->gambar) {
            $imagePath = public_path('img/admin/fotoUser/' . $user->gambar);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $user->delete();

         
        return redirect()->route('user.index')

                        ->with('success','User deleted successfully');
    }

    public function profilAdmin(Request $request){
        $user = Auth::user();

        return view('admin.profilAdmin');
    }
    
    public function profilKlien(Request $request){
        $user = Auth::user();

        return view('klien.profilKlien');
    }
    
}
