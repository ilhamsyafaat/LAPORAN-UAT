<?php

namespace App\Livewire\Components\Projects;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    public $nama;
    public $deskripsi;

    /**
     * Method untuk menyimpan project baru
     * setelah melakukan validasi.
     */
    public function store()
    {
        // Validasi input yang diterima
        $this->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // Simpan data project ke database
        $project = Project::create([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        // Reset input setelah berhasil menyimpan
        $this->nama = null;
        $this->deskripsi = null;

        Session()->flash('success', 'Project berhasil ditambahkan!');

        // Redirect ke halaman test suite
        return redirect()->route('testsuite.index', ['projectId' => $project->id]);
    }

    /**
     * Render view untuk form pembuatan project.
     */
    public function render()
    {
        return view('livewire.components.projects.create');
    }
}
