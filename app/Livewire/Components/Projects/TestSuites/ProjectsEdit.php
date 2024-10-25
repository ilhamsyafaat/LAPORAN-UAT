<?php

namespace App\Livewire\Components\Projects\TestSuites;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ProjectsEdit extends Component
{
    public $projectId;
    public $nama;
    public $deskripsi;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
    ];

    /**
     * Menginisialisasi nilai project berdasarkan projectId yang diterima.
     * Mengisi form dengan data project yang ada.
     *
     * @param int $projectId
     */
    public function mount($projectId)
    {
        // Mengambil data project berdasarkan ID atau gagal jika tidak ditemukan
        $project = Project::findOrFail($projectId);

        // Menyimpan projectId dan mengisi form dengan nilai nama dan deskripsi dari project yang ada
        $this->projectId = $project->id;
        $this->nama = $project->nama;
        $this->deskripsi = $project->deskripsi;
    }

    /**
     * Memperbarui data project yang sudah ada dengan nilai baru
     * yang diisi oleh user pada form.
     */
    public function updateProject()
    {
        // Validasi input sesuai aturan yang telah ditentukan
        $this->validate();

        // Mencari project berdasarkan ID atau gagal jika tidak ditemukan
        $project = Project::findOrFail($this->projectId);

        // Memperbarui data project dengan input yang baru
        $project->update([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        Session()->flash('success', 'Project berhasil diperbarui!');

        return redirect()->route('testsuite.index', ['projectId' => $project->id]);
    }

    /**
     * Render tampilan untuk form edit project.
     */
    public function render()
    {
        return view('livewire.components.projects.test-suites.projects-edit');
    }
}
