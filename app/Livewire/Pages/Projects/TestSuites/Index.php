<?php

namespace App\Livewire\Pages\Projects\TestSuites;

use App\Models\Project;
use App\Models\TestSuite;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class Index extends Component
{
    // Menggunakan trait WithPagination untuk menambahkan dukungan paginasi
    use WithPagination;

    public $projectId;// Properti untuk menyimpan ID proyek
    public $search; // Menetapkan tema paginasi
    protected $paginationTheme = 'bootstrap'; // Metode yang dijalankan saat komponen di-mount

    public function mount($projectId)
    {
        // Menyimpan ID proyek yang diterima dari parameter
        $this->projectId = $projectId;
    }

    public function updatingSearch()
    {
        // Reset halaman paginasi saat pencarian diperbarui
        $this->resetPage();
    }

    public function render()
    {
        // Ambil proyek berdasarkan ID yang disimpan di properti
        $project = Project::findOrFail($this->projectId);

        // Query untuk mendapatkan test suite yang terkait dengan proyek tertentu
        $query = TestSuite::where('project_id', $this->projectId);

        // Jika ada kata kunci pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode', 'like', "%{$this->search}%")
                    ->orWhere('judul', 'like', "%{$this->search}%");
            });
        }
        // Hitung jumlah test suite
        $testSuiteCount = $query->count();

        // Paginate hasil query
        $testSuite = $query->paginate(5);

        // Kembalikan tampilan dengan data yang diperlukan
        return view('livewire.pages.projects.test-suites.index', [
            'project' => $project, // Mengirimkan data proyek ke view
            'testSuite' => $testSuite, // Mengirimkan data test suite yang dipaginasi ke view
            'testSuiteCount' => $testSuiteCount, // Mengirimkan jumlah test suite yang ditemukan ke view
        ]);
    }
}
