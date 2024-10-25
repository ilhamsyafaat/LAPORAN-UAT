<?php

namespace App\Livewire\Components\KelolaUser;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    // Properti untuk menyimpan data input pengguna
    public $name;
    public $email;
    public $roles = [];
    public $createPassword;

    // Fungsi render untuk menampilkan view form create pengguna
    public function render()
    {
        // Mengambil semua role yang tersedia dan mengirimkannya ke view
        return view('livewire.components.kelola-user.create', [
            'availableRoles' => Role::all(),
        ]);
    }

    // Fungsi untuk menyimpan data pengguna baru
    public function store()
    {
        // Melakukan validasi input
        $this->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'roles' => 'required|array',
        ], [
            'name.required' => 'Kolom Nama harus diisi.',
            'name.unique' => 'Pengguna dengan Nama ini sudah ada.',
            'name.string' => 'Kolom Nama harus berupa teks.',
            'name.max' => 'Kolom Nama maksimal 255 karakter.',
            'email.required' => 'Kolom Email harus diisi.',
            'email.unique' => 'Pengguna dengan Email ini sudah ada.',
            'email.email' => 'Kolom Email harus berupa email.',
            'email.string' => 'Kolom Email harus berupa teks.',
            'email.max' => 'Kolom Email maksimal 255 karakter.',
        ]);

        // Generate password acak untuk pengguna baru
        $password = Str::random(16);
        $this->createPassword = $password;

        // Menyimpan data pengguna baru ke database
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($password),
        ]);

        // Menyimpan role yang dipilih untuk pengguna baru
        foreach ($this->roles as $roleId) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
        }

        // Mengirimkan event bahwa pengguna baru berhasil disimpan
        $this->dispatch('userStored');
        // Mengirimkan event untuk menampilkan password baru kepada pengguna
        $this->dispatch('showCreatePassword', $this->createPassword, $this->name);

        session()->flash('success', 'Pengguna berhasil ditambahkan.');
        // Mereset properti form setelah data disimpan
        $this->reset(['name', 'email', 'roles']);
    }
}
