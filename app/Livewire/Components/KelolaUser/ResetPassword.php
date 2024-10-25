<?php

namespace App\Livewire\Components\KelolaUser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ResetPassword extends Component
{
    // Properti untuk menyimpan data input pengguna
    public $userId;
    public $user;
    public $newPassword;

    // Fungsi yang dijalankan saat komponen pertama kali dipanggil
    public function mount($userId)
    {
        // Menyimpan ID pengguna yang akan di-reset
        $this->userId = $userId;
        // Mencari pengguna berdasarkan ID yang diberikan
        $this->user = User::findOrFail($userId);
    }

    // Fungsi untuk melakukan reset password pengguna
    public function resetPassword()
    {
        // Generate password baru secara acak sepanjang 16 karakter
        $this->newPassword = Str::random(16);

        // Mencari pengguna berdasarkan ID dan update password-nya di database
        $user = User::findOrFail($this->userId);
        $user->update([
            'password' => Hash::make($this->newPassword),
        ]);

        // Mengirim event 'resetPassword' untuk memberitahukan bahwa password telah direset
        $this->dispatch('resetPassword', $this->userId);
        // Mengirim event 'showNewPassword' untuk menampilkan password baru kepada pengguna
        $this->dispatch('showNewPassword', $this->newPassword, $this->user->name);

        session()->flash('success', 'Reset Password berhasil!!!');
    }

    // Fungsi untuk merender tampilan komponen reset password
    public function render()
    {
        return view('livewire.components.kelola-user.reset-password');
    }
}
