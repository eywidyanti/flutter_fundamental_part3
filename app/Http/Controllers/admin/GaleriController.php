<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $galeris = Galeri::where('user_id', $user->id)->latest()->paginate(5);

        return view('admin.galeri.index', compact('galeris'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $request->validate([
            'gambar' => 'required||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar1' => 'nullable||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar2' => 'nullable||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:20480',
            'deskripsi' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = $user_id;
        $data['slug'] = Str::random(20);

        $gambarFields = ['gambar', 'gambar1', 'gambar2'];
        $destinationPath = 'img/admin/gambarGaleri/';

        // Loop untuk menyimpan gambar
        foreach ($gambarFields as $gambarField) {
            if ($request->hasFile($gambarField)) {
                $gambar = $request->file($gambarField);
                $filename = date('YmdHis') . "_" . $gambarField . "." . $gambar->getClientOriginalExtension();
                $gambar->move(public_path($destinationPath), $filename);
                $data[$gambarField] = $filename;
            }
        }

        //video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $destinationPath = 'img/admin/videoGaleri/';
            $videoName = date('YmdHis') . "." . $video->getClientOriginalExtension();
            $video->move(public_path($destinationPath), $videoName);
            $data['video'] = "$videoName";
        }


        Galeri::create($data);

        return redirect()->route('galeri.index')
            ->with('success', 'galeri created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gambar2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:20480',
            'deskripsi' => 'required',
        ]);

        $input = $request->all();
        $input['slug'] = Str::random(20);

        $gambarFields = ['gambar', 'gambar1', 'gambar2'];
        $destinationPath = 'img/admin/gambarGaleri/';

        // Loop untuk menyimpan gambar
        foreach ($gambarFields as $gambarField) {
            if ($request->hasFile($gambarField)) {
                // Hapus gambar lama jika ada
                if ($galeri->$gambarField) {
                    $oldImagePath = public_path($destinationPath . $galeri->$gambarField);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
                // Simpan gambar baru
                $gambar = $request->file($gambarField);
                $filename = date('YmdHis') . "_" . $gambarField . "." . $gambar->getClientOriginalExtension();
                $gambar->move(public_path($destinationPath), $filename);
                $input[$gambarField] = $filename;
            } else {
                unset($input[$gambarField]);
            }
        }

        // Video
        if ($request->hasFile('video')) {
            // Hapus video lama jika ada
            if ($galeri->video) {
                $oldVideoPath = public_path('img/admin/videoGaleri/' . $galeri->video);
                if (File::exists($oldVideoPath)) {
                    File::delete($oldVideoPath);
                }
            }
            // Simpan video baru
            $video = $request->file('video');
            $videoDestinationPath = 'img/admin/videoGaleri/';
            $videoName = date('YmdHis') . "." . $video->getClientOriginalExtension();
            $video->move(public_path($videoDestinationPath), $videoName);
            $input['video'] = $videoName;
        } else {
            $input['video'] = $galeri->video; 
        }

        $galeri->update($input);

        return redirect()->route('galeri.index')
            ->with('success', 'Galeri updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        //hapus galeri dan video
        if ($galeri->gambar) {
            $oldImagePath = public_path('img/admin/gambarGaleri/' . $galeri->gambar);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        if ($galeri->video) {
            $oldVideoPath = public_path('img/admin/videoGaleri/' . $galeri->video);
            if (File::exists($oldVideoPath)) {
                File::delete($oldVideoPath);
            }
        }

        $galeri->delete();

        return redirect()->route('galeri.index')
            ->with('success', 'galeri deleted successfully');
    }
}
