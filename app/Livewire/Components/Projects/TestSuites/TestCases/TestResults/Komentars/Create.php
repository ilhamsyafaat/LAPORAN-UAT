<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults\Komentars;

use App\Models\Komentar;
use App\Models\MStatus;
use App\Models\TestResult;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    public $testResultId;
    public $userIdPenugasan;
    public $kStatus;
    public $komentar;
    public $users;
    public $mStatus;
    public $projectId;
    public $testSuiteId;
    public $testCaseId;

    /**
     * Metode mount untuk inisialisasi data sebelum komponen dirender.
     * Mengambil data dari $testResultId, $projectId, $testSuiteId, dan $testCaseId.
     *
     * @param mixed $testResultId
     * @param mixed $projectId
     * @param mixed $testSuiteId
     * @param mixed $testCaseId
     */
    public function mount($testResultId, $projectId, $testSuiteId, $testCaseId)
    {
        $this->testResultId = $testResultId;  // Set ID Test Result yang diterima dari parameter
        $this->users = User::all();  // Ambil semua user dari database
        $this->mStatus = MStatus::all();
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;
        $this->testCaseId = $testCaseId;
    }

    /**
     * Metode store untuk menyimpan komentar baru ke database.
     */
    public function store()
    {
        // Validasi input dari form
        $validated = $this->validate([
            'userIdPenugasan' => 'required|exists:users,id',
            'kStatus' => 'required|exists:m_status,k_status',
            'komentar' => 'required|string',
        ], [
            'userIdPenugasan.required' => 'Penugasan harus diisi!',
            'kStatus.required' => 'Status harus diisi!',
            'komentar.required' => 'Komentar harus diisi!',
        ]);

        // Ambil data test result yang terkait berdasarkan ID
        $testResult = TestResult::findOrFail($this->testResultId);

        // Ambil komentar terakhir dari test result yang sama
        $lastKomentar = Komentar::where('test_result_id', $this->testResultId)->latest()->first();

        // Ambil penugasan dan status lama dari komentar terakhir atau dari test result jika belum ada komentar
        $oldAssignee = $lastKomentar ? User::find($lastKomentar->user_id_penugasan)->name : User::find($testResult->user_id_penugasan)->name;
        $oldStatus = $lastKomentar ? MStatus::find($lastKomentar->k_status)->label : MStatus::find($testResult->k_status)->label;

        // Ambil penugasan dan status baru dari form input
        $newAssignee = User::find($this->userIdPenugasan)->name ?? 'Tidak diketahui';
        $newStatus = MStatus::find($this->kStatus)->label ?? 'Tidak diketahui';

        // Simpan komentar baru ke database
        Komentar::create([
            'test_result_id' => $this->testResultId,
            'user_id_penugasan' => $this->userIdPenugasan,
            'k_status' => $this->kStatus,
            'komentar' => $this->komentar,
            'tgl_komentar' => Carbon::now(),
            'old_assignee' => $oldAssignee,
            'new_assignee' => $newAssignee,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        // Perbarui status pada test result terkait
        $testResult->update([
            'k_status' => $this->kStatus,  // Set status test result dengan yang baru
        ]);

        // Reset input setelah berhasil menyimpan komentar
        $this->reset(['userIdPenugasan', 'kStatus', 'komentar']);

        session()->flash('success', 'Komentar berhasil dibuat!');

        // Redirect ke halaman komentar setelah berhasil menyimpan
        return redirect()->route('komentar.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuiteId,
            'testCaseId' => $this->testCaseId,
            'testResultId' => $this->testResultId,
        ]);
    }

    /**
     * Metode render untuk menampilkan halaman form create.
     */
    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.komentars.create');  // Menampilkan view untuk create komentar
    }
}
