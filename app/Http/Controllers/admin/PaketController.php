<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dekor;
use App\Models\Paket;
use App\Models\PaketDekor;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $pakets = Paket::where('user_id', $user->id)->latest()->paginate(5);

        return view('admin.paket.index', compact('pakets'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.paket.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $request->validate([
            'nama' => 'required',
            'gambar' => 'required||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required',

        ]);
        $data = $request->all();
        $data['user_id'] = $user_id;
        $data['slug'] = Str::random(20);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $destinationPath = 'img/admin/gambarpaket/';
            $profileGambar = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
            $gambar->move(public_path($destinationPath), $profileGambar);
            $data['gambar'] =  $profileGambar;
        } else {
            return redirect()->back()->withInput()->withErrors(['gambar' => 'The gambar field is required.']);
        }


        Paket::create($data);


        return redirect()->route('paket.index')

            ->with('success', 'paket berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Paket $paket)
    {
        $paketDekors = PaketDekor::where('paket_id', $paket->id)->get();

        return view('admin.paket.show', compact('paket', 'paketDekors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        return view('admin.paket.edit', compact('paket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paket $paket)
    {
        $request->validate([

            'nama' => 'required',
            'gambar' => 'nullable||mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required',

        ]);

        $input = $request->all();
        $input['slug'] = Str::random(20);

        if ($request->hasFile('gambar')) {

            if ($paket->gambar) {
                $oldImagePath = public_path('img/admin/gambarpaket/' . $paket->gambar);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $gambar = $request->file('gambar');
            $destinationPath = 'img/admin/gambarpaket/';
            $profileGambar = date('YmdHis') . "." . $gambar->getClientOriginalExtension();
            $gambar->move(public_path($destinationPath), $profileGambar);
            $input['gambar'] = "$profileGambar";
        } else {
            unset($input['gambar']);
        }

        $paket->update($input);

        return redirect()->route('paket.index')
            ->with('success', 'paket berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        // Hapus gambar jika ada
        if ($paket->gambar) {
            $imagePath = public_path('img/admin/gambarpaket/' . $paket->gambar);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $paket->paketDekors()->delete();

        $paket->delete();

        return redirect()->route('paket.index')
            ->with('success', 'Paket berhasil dihapus');
    }


    public function DragnDropAdmin()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $dekors = Dekor::whereDoesntHave('paketDekors')->get();

        $position = Position::where('user_id', $user->id)->get();
        if ($position->isEmpty()) {
            return view('admin.paket.index', compact('dekors', 'position'));
        } else {
            $maxId = $position->sortByDesc('id')->first();
            $pecah = explode('},{', $maxId->x);
            return view('admin.paket.create', compact('dekors', 'pecah',  'position'));
        }
    }


    public function simpanDragnDrop(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $position = new Position;
        $position->x = $request->x;
        $position->user_id = $user_id;
        $position->save();

        // return response()->json(['status' => 'success']);
        return redirect()->route('paketDragndrop');
    }

    public function paket_drag_n_drop(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $nama_paket = $request->nama;
        $deskripsi_paket = $request->deskripsi;

        $dataDekor = [];
        $harga = 0;
        $data = explode(',', $request->x);
        foreach ($data as $val) {
            $posisi = explode('#', $val);
            if (floatval($posisi[2]) != 0) {
                $ids = explode('-', $posisi[0]);
                $id = $ids[1];
                $dekor = Dekor::where('id', $id)->first();
                $harga += $dekor->harga;
                $dataDekor[] = $dekor->id;
            } else {
                session()->flash('error', 'Drag dekorasi gagal');
            }
        }

        $jml = $harga * 0.1;
        $hargatotal = $harga - $jml;

        $paket = new Paket;
        $paket->user_id = $user_id;
        $paket->dekor_id =  $dekor->id;
        $paket->nama = $nama_paket;
        $paket->harga = $hargatotal;
        $paket->slug = Str::random(20);
        $paket->deskripsi = $deskripsi_paket;
        $paket->save();

        $IDPaket = $paket->id;
        foreach ($dataDekor as $val) {
            $paketdekor = new PaketDekor;
            $paketdekor->paket_id = $IDPaket;
            $paketdekor->dekor_id = $val;
            $paketdekor->save();
        }
        session()->flash('success', 'Paket dekorasi berhasil');
        return redirect()->route('paket.index');
    }
}
