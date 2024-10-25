<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults\Komentars;

use App\Models\MStatus;
use App\Models\TestResult;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TestResultsEdit extends Component
{
    // Inisialisasi properti yang akan digunakan
    public $testResultId;
    public $testResult;
    public $harapan;
    public $realisasi;
    public $userIdPenugasan;
    public $kStatus;
    public $users;
    public $mStatus;
    public $projectId;
    public $testSuiteId;
    public $testCaseId;

    // Fungsi mount untuk inisialisasi data ketika komponen pertama kali dijalankan
    public function mount($testResultId, $projectId, $testSuiteId, $testCaseId)
    {
        // Mengambil data Test Result berdasarkan ID yang diberikan dan mengisi properti yang relevan
        $this->testResultId = $testResultId;
        $this->testResult = TestResult::findOrFail($testResultId);
        $this->harapan = $this->testResult->harapan;
        $this->realisasi = $this->testResult->realisasi;
        $this->userIdPenugasan = $this->testResult->user_id_penugasan;
        $this->kStatus = $this->testResult->k_status;

        // Inisialisasi ID proyek, Test Suite, dan Test Case terkait
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;
        $this->testCaseId = $testCaseId;

        // Mendapatkan semua pengguna yang tersedia
        $this->users = User::all();

        // Mengambil semua status yang tersedia
        $this->mStatus = MStatus::all();
    }

    // Fungsi untuk memperbarui data Test Result
    public function update()
    {
        // Validasi input
        $this->validate([
            'userIdPenugasan' => 'required|exists:users,id',
            'harapan' => 'required|string',
            'realisasi' => 'nullable|string',
            'kStatus' => 'required',
        ]);

        // Mengambil data Test Result berdasarkan ID yang diberikan
        $testResult = TestResult::findOrFail($this->testResultId);
        
        // Memperbarui data Test Result dengan input yang baru
        $testResult->update([
            'user_id_penugasan' => $this->userIdPenugasan,
            'harapan' => $this->harapan,
            'realisasi' => $this->realisasi,
            'k_status' => $this->kStatus,
        ]);

        // Menyimpan pesan sukses ke sesi
        session()->flash('success', 'Test Result berhasil diubah');

        // Mengarahkan pengguna kembali ke halaman komentar terkait Test Result
        return redirect()->route('komentar.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuiteId,
            'testCaseId' => $this->testCaseId,
            'testResultId' => $this->testResultId,
        ]);
    }

    // Fungsi render untuk menampilkan tampilan halaman edit
    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.komentars.test-results-edit');
    }
}
