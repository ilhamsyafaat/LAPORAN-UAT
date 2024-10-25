<?php

namespace App\Livewire\Components\KelolaUser;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CreatePassword extends Component
{
    // Properti untuk menyimpan password baru dan nama pengguna
    public $createPassword;
    public $userName;

    protected $listeners = ['showCreatePassword'];

    // Fungsi untuk menangkap event dan menetapkan password serta nama pengguna
    public function showCreatePassword($password, $name)
    {
        $this->createPassword = $password;
        $this->userName = $name;
        // Mengirimkan event untuk membuka modal yang menampilkan password
        $this->dispatch('openCreatePasswordModal');
    }

    // Fungsi render untuk menampilkan view modal password
    public function render()
    {
        return view('livewire.components.kelola-user.create-password');
    }
}
