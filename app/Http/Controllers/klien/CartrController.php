<?php

namespace App\Http\Controllers\klien;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Dekor;
use App\Models\Paket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartrController extends Controller
{
    public function addToCart($slug)
{
    $user = Auth::user();
    $user_id = $user->id;
    $paket = Paket::where('slug', $slug)->first();
    
    if ($paket) {
        $cartItems = Cart::where('user_id', $user_id)->get();
        $cartDekorIds = $cartItems->pluck('dekor_id')->toArray();
    
        $existingDekorInCart = false;
        foreach ($cartDekorIds as $cartDekorId) {
            $existingDekor = Dekor::find($cartDekorId);
            if ($existingDekor && $existingDekor->paket_id != $paket->id) {
                $existingDekorInCart = true;
                break;
            }
        }
    
        if ($existingDekorInCart) {
            session()->flash('error', 'Maaf, paket lain tidak bisa ditambahkan. Hanya satu paket yang diperbolehkan di keranjang.');
        } else {
            foreach ($paket->dekors as $dekor) {
                $cartItem = Cart::where('dekor_id', $dekor->id)->where('user_id', $user_id)->first();
                if (!$cartItem) {
                    if ($dekor->stok > 0) {
                        Cart::create([
                            'dekor_id' => $dekor->id,
                            'user_id' => $user_id,
                            'paket_id' => $paket->id,
                            'slug' => Str::random(20),
                            'quantity' => 1,
                        ]);
                        session()->flash('success', 'Paket berhasil ditambahkan ke keranjang.');
                    } else {
                        session()->flash('error', 'Maaf, stok hanya satu.');
                    }
                } else {
                    session()->flash('error', 'Maaf, paket lain tidak bisa ditambahkan. Hanya satu paket yang diperbolehkan di keranjang.');
                }
            }
        }
    } else {
        $dekor = Dekor::where('slug', $slug)->firstOrFail();
        $cartItem = Cart::where('dekor_id', $dekor->id)->where('user_id', $user_id)->first();
    
        // Cek apakah ada paket di keranjang
        $existingPaketInCart = Cart::where('user_id', $user_id)->whereNotNull('paket_id')->exists();
    
        if ($existingPaketInCart) {
            session()->flash('error', 'Maaf, dekor tidak bisa ditambahkan karena ada paket di keranjang.');
        } else {
            if (!$cartItem) {
                if ($dekor->stok > 0) {
                    Cart::create([
                        'dekor_id' => $dekor->id,
                        'user_id' => $user_id,
                        'slug' => Str::random(20),
                        'quantity' => 1,
                    ]);
                    session()->flash('success', 'Dekor berhasil ditambahkan ke keranjang');
                } else {
                    session()->flash('error', 'Maaf, stok tidak ada.');
                }
            } else {
                session()->flash('error', 'Maaf, item sudah ada di keranjang.');
            }
        }
    }

    return redirect()->back();
}


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        
        $cartItem = Cart::where('paket_id', $request->id)->first();

        if ($cartItem){
            if($cartItem->quantity==$cartItem->dekor->stok){
                session()->flash('error', 'Maaf Stok hanya satu');
            }else  {
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
                session()->flash('success', 'Keranjang berhasil di update');
            }
        }else{
            $cartItem = Cart::where('dekor_id', $request->id)->first();

            if($cartItem->quantity==$cartItem->dekor->stok){
                session()->flash('error', 'Maaf Stok hanya satu');
            }else  {
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
                session()->flash('success', 'Keranjang berhasil di update');
            }
        }
    }
    

    public function remove(Request $request)
    {
        $cartItem = Cart::where('dekor_id', $request->id)->first();

        if ($cartItem) {
            $cartItem->delete();
            session()->flash('success', 'Dekor berhasil di hapus');
        } else{
            $cartItems = Cart::where('paket_id', $request->id)->get();

            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }
            session()->flash('success', 'Paket berhasil di hapus');
        
        }
    }
}