<?php

namespace App\Livewire\Components\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class UbahPassword extends Component
{
    // Inisialisasi variabel yang akan digunakan dalam komponen
    public string $old_password;
    public string $new_password;
    public string $new_password_confirmation;

    // Fungsi yang dijalankan saat komponen pertama kali dipanggil
    public function updatePassword()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login

        // Validasi input password
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'old_password.required' => 'Masukkan password lama',
            'new_password.required' => 'Masukkan password baru',
        ]);

        // Memeriksa apakah password lama yang dimasukkan cocok dengan password yang ada di database
        if (!Hash::check($this->old_password, $user->password)) {
            // Jika tidak cocok, tampilkan pesan error
            return $this->addError('old_password', 'Password lama tidak cocok');
        }

        // Update password baru pada pengguna di database
        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        // Reset input password setelah berhasil diubah
        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Password berhasil diubah');

        return redirect()->route('profile.index');
    }

    // Fungsi untuk merender tampilan komponen ini
    public function render()
    {
        return view('livewire.components.profile.ubah-password');
    }
}
