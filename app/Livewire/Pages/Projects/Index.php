<?php

namespace App\Livewire\Pages\Projects;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    protected string $paginationTheme = 'bootstrap';

    /**
     * Metode yang dipanggil ketika properti pencarian ($search) diperbarui.
     * Ini akan mereset halaman ke halaman pertama.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Metode render untuk menampilkan halaman dan melakukan query project.
     */
    public function render()
    {
        // Query dasar untuk mengambil semua project beserta jumlah test suite yang belum dan sudah selesai
        $query = Project::withCount([
            'testSuites as belum_selesai_count' => function ($query) {
                $query->where('progress', '<', 100);
            },
            'testSuites as sudah_selesai_count' => function ($query) {
                $query->where('progress', '=', 100);
            },
        ]);

        // Jika ada kata kunci pencarian, filter query berdasarkan nama project
        if ($this->search) {
            $query->where('nama', 'like', '%'.$this->search.'%');
        }
        // Menghitung total jumlah project
        $totalProjects = $query->count();

        // Mengambil data project dengan pagination
        $projects = $query->paginate(10);

        // Mengembalikan view dengan data project dan total project
        return view('livewire.pages.projects.index', [
            'projects' => $projects,
            'totalProjects' => $totalProjects,
        ]);
    }
}
