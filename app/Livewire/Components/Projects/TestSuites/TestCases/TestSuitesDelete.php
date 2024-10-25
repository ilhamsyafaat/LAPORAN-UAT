<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases;

use App\Models\TestSuite;
use Livewire\Attributes\Layout;
use Livewire\Component;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class TestSuitesDelete extends Component
{
    public $testSuiteId; // Properti untuk menyimpan ID test suite yang akan dihapus
    public $testSuiteName; // Properti untuk menyimpan nama test suite yang akan dihapus

    public function mount($testSuiteId)
    {
        $this->testSuiteId = $testSuiteId; // Menyimpan ID test suite
        $this->testSuiteName = TestSuite::findOrFail($this->testSuiteId)->judul; // Mengambil judul test suite
    }

    public function deleteTestSuite()
    {
        // Mencari test suite berdasarkan ID
        $testSuite = TestSuite::findOrFail($this->testSuiteId);

        // Cek jika ada test case yang terkait
        if ($testSuite->testCases()->count() > 0) {
            session()->flash('error', 'Test Suite tidak bisa dihapus karena ada test Case!');

            // Redirect ke halaman indeks test case
            return redirect()->route('testcase.index', ['projectId' => $testSuite->project_id, 'testSuiteId' => $testSuite->id]);
        }

        // Simpan ID proyek untuk redirect setelah penghapusan
        $projectId = $testSuite->project_id;
        $testSuite->delete(); // Menghapus test suite

        session()->flash('success', 'Test Suite berhasil dihapus!');

        // Redirect ke halaman indeks test suite
        return redirect()->route('testsuite.index', ['projectId' => $projectId]);
    }

    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-suites-delete');
    }
}
