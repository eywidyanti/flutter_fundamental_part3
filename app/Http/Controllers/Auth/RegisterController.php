<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'jenis_kelamin' => ['required'],
            'noHp' => ['required'],
            'gambar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ], $this->messages());
    }

    protected function messages()
    {
        return [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Kolom nama harus berupa string.',
            'name.max' => 'Kolom nama maksimal 255 karakter.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.string' => 'Kolom email harus berupa string.',
            'email.email' => 'Kolom email harus berisi email yang valid.',
            'email.max' => 'Kolom email maksimal 255 karakter.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kolom kata sandi wajib diisi.',
            'password.string' => 'Kolom kata sandi harus berupa string.',
            'password.min' => 'Kolom kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin wajib diisi.',
            'noHp.required' => 'Kolom nomor HP wajib diisi.',
            'gambar.required' => 'Kolom gambar wajib diisi.',
            'gambar.image' => 'Kolom gambar harus berupa gambar.',
            'gambar.mimes' => 'Kolom gambar harus berupa file bertipe: jpeg, png, jpg, gif, svg.',
            'gambar.max' => 'Kolom gambar tidak boleh lebih dari 2048 kilobyte.',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $profilegambar = 'default.png';

        // Periksa apakah ada file gambar yang diunggah
        if (isset($data['gambar']) && $data['gambar']->isValid()) {
            $gambar = $data['gambar'];
            $destinationPath = 'img/admin/fotoUser/';
            $profilegambar = Str::random(20) . "." . $gambar->getClientOriginalExtension();
            $gambar->move(public_path($destinationPath), $profilegambar);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'jenis_kelamin' => $data['jenis_kelamin'],
            'noHp' => $data['noHp'],
            'gambar' =>  $profilegambar,
        ]);
    }
}
