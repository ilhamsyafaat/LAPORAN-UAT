<?php

namespace App\Livewire\Components\KelolaUser;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Delete extends Component
{
    // Properti untuk menyimpan ID pengguna yang akan dihapus
    public $userId;
    public $users;

    // Listener untuk menangani event deleteUser
    protected $listeners = ['deleteUser'];

    // Fungsi mount untuk mengambil semua data pengguna
    public function mount()
    {
        $this->users = User::all(); // Ambil semua data pengguna
    }

    // Fungsi untuk menghapus pengguna berdasarkan ID
    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            // to do : belum menambahkan pesan error pada saat users masih ditugaskan
            // Hapus semua data terkait pengguna seperti test results dan role
            $user->testResults()->delete();
            $user->userRoles()->delete();
            $user->delete();

            // Redirect ke route dengan pesan sukses
            return redirect()->route('kelola-user.index')->with('success', 'Pengguna berhasil dihapus.');
        }
    }

    // Fungsi render untuk menampilkan view delete
    public function render()
    {
        return view('livewire.components.kelola-user.delete', [
            'users' => $this->users, // Kirimkan data pengguna ke view
        ]);
    }
}
