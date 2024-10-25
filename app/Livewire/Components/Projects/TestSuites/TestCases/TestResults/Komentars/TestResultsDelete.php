<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults\Komentars;

use App\Models\TestResult;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TestResultsDelete extends Component
{
    // Inisialisasi properti yang akan digunakan
    public $testResultId;
    public $projectId;
    public $testSuiteId;
    public $testCaseId;
    public $testResult;

    // Fungsi mount untuk inisialisasi data ketika komponen pertama kali dijalankan
    public function mount($testResultId)
    {
        $this->testResult = TestResult::findOrFail($testResultId);
    }

    // Fungsi untuk menghapus Test Result dari basis data
    public function deleteTestResult()
    {
        // Mengambil Test Result berdasarkan ID yang diberikan
        $testResult = TestResult::findOrFail($this->testResultId);
        $testResult->delete(); // Menghapus Test Result

        session()->flash('success', 'Test Result berhasil dihapus');

        // Mengarahkan pengguna kembali ke halaman daftar Test Result
        return redirect()->route('testresult.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuiteId,
            'testCaseId' => $this->testCaseId,
        ]);
    }

    // Fungsi render untuk menampilkan tampilan halaman delete
    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.komentars.test-results-delete');
    }
}
