<?php

namespace App\Livewire\Components\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Edit extends Component
{
    // Inisialisasi variabel yang akan digunakan dalam komponen
    public string $name;
    public string $email;

    // Fungsi yang dijalankan saat komponen pertama kali dipanggil
    public function mount()
    {
        // Ambil data pengguna saat ini
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    // Fungsi untuk mengupdate profil pengguna
    public function updateProfile()
    {
        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login

        // Validasi data yang dimasukkan oleh pengguna
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        // Update data pengguna di database
        $user->update($validatedData);

        session()->flash('success', 'Profil berhasil diperbarui');
        
        return redirect()->route('profile.index');
    }

    // Fungsi untuk merender tampilan komponen ini
    public function render()
    {
        return view('livewire.components.profile.edit');
    }
}
