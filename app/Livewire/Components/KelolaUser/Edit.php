<?php

namespace App\Livewire\Components\KelolaUser;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Edit extends Component
{
    // Properti untuk menyimpan data pengguna dan role yang akan diubah
    public $userId;
    public $name;
    public $email;
    public $roles = [];
    public $availableRoles = [];
    public $user;

    // Fungsi mount untuk mengambil data pengguna yang akan diedit
    public function mount($userId)
    {
        $this->userId = $userId;

        $this->user = User::findOrFail($userId);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        // Mengambil role yang saat ini dimiliki oleh pengguna
        $this->roles = $this->user->userRoles->pluck('role_id')->toArray();
        // Mengambil semua role yang tersedia
        $this->availableRoles = Role::all()->toArray();
    }

    // Fungsi untuk memperbarui data pengguna
    public function updateUser()
    {
        // Validasi data yang akan diperbarui
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->userId,
            'roles' => 'required|array',
        ]);
        
        // Cari pengguna berdasarkan ID dan update data
        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Hapus role lama dan tambahkan role baru
        UserRole::where('user_id', $user->id)->delete();
        foreach ($this->roles as $roleId) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
        }

        session()->flash('success', 'Pengguna berhasil diperbarui.');

        // Redirect kembali ke halaman daftar pengguna
        return redirect()->route('kelola-user.index');
    }

    // Fungsi render untuk menampilkan form edit
    public function render()
    {
        return view('livewire.components.kelola-user.edit');
    }
}
