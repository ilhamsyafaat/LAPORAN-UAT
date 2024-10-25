<?php

namespace App\Livewire\Pages\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Index extends Component
{
    // Inisialisasi variabel yang akan digunakan dalam komponen
    public string $name;
    public string $email;
    public string $roles;

    // Fungsi yang dijalankan saat komponen pertama kali dipanggil
    public function mount()
    {
        $user = Auth::user();  // Ambil data pengguna yang sedang login
        $this->name = $user->name;  // Menyimpan nama pengguna
        $this->email = $user->email;  // Menyimpan email pengguna
        // Mengambil semua roles pengguna dan menggabungkannya menjadi string
        $this->roles = implode(', ', $user->userRoles->pluck('role.nama')->toArray());
    }

    // Fungsi untuk merender tampilan komponen ini
    public function render()
    {
        // Ambil data terbaru dari pengguna yang sedang login untuk memastikan profil selalu up-to-date
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;

        // Mengembalikan tampilan view dari halaman profil pengguna
        return view('livewire.pages.profile.index');
    }
}
