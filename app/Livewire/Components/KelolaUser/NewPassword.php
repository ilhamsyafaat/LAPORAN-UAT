<?php

namespace App\Livewire\Components\KelolaUser;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class NewPassword extends Component
{
    // Properti untuk menyimpan data input pengguna
    public $newPassword;
    public $userName;

    protected $listeners = ['showNewPassword'];

    // Fungsi yang dipanggil saat event 'showNewPassword' diterima
    public function showNewPassword($password, $name)
    {
        // Menyimpan password baru yang diterima dari event
        $this->newPassword = $password;
        // Menyimpan nama pengguna yang diterima dari event
        $this->userName = $name;

        // Mengirim event untuk membuka modal yang akan menampilkan password baru
        $this->dispatch('openNewPasswordModal');
    }

    // Fungsi untuk merender tampilan komponen ini
    public function render()
    {
        return view('livewire.components.kelola-user.new-password');
    }
}
