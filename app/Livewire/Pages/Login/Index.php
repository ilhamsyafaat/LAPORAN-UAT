<?php

namespace App\Livewire\Pages\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class index extends Component
{
    public $email;  // untuk menyimpan input email dari user
    public $password;  // untuk menyimpan input password dari user

    protected $rules = [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ];

    /**
     * Fungsi login untuk memproses login user.
     */
    public function login()
    {
        $this->validate();

        // Mengatur credentials dengan input email dan password
        $credentials = ['email' => $this->email, 'password' => $this->password];

        // Jika email dan password cocok, login berhasil
        if (Auth::attempt($credentials)) {
            session()->flash('success', 'Login berhasil.');

            return redirect()->intended('/');
        }

        session()->flash('error', 'Email atau kata sandi salah.');
    }

    /**
     * Fungsi render untuk menampilkan view login.
     */
    public function render()
    {
        return view('livewire.pages.login.index');
    }
}
