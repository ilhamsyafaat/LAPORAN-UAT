<?php

namespace App\Livewire\Pages\KelolaUser;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class Index extends Component
{
    // Menggunakan trait untuk mendukung pagination pada Livewire
    use WithPagination;

    // Menetapkan tema pagination menggunakan Bootstrap
    protected $paginationTheme = 'bootstrap';

    // Mendengarkan event yang dikirim dari komponen lain
    protected $listeners = [
        'userStored', // Mendengarkan event 'userStored'
        'resetPassword' => 'render', // Render ulang halaman ketika password direset
    ];

    // Fungsi render untuk mengambil data pengguna dan menampilkannya ke view
    public function render()
    {
        // Mengambil data pengguna dengan relasi role melalui userRoles dan melakukan pagination
        $users = User::with('userRoles.role')->paginate(10);

        // Mengembalikan view dengan data pengguna yang diambil
        return view('livewire.pages.kelola-user.index', [
            'users' => $users,
        ]);
    }
}
