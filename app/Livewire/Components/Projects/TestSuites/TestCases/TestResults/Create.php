<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults;

use App\Models\MStatus;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    // Inisialisasi properti yang akan digunakan
    public $testCaseId;
    public $projectId;
    public $testSuiteId;
    public $testResultId;
    public $users;
    public $mStatus;
    public $harapan;
    public $realisasi;
    public $userIdPenugasan;
    public $kStatus;

    // Fungsi mount untuk inisialisasi data ketika komponen pertama kali dijalankan
    public function mount($testCaseId, $projectId, $testSuiteId)
    {
        // Menyimpan parameter yang diterima ke dalam variabel komponen
        $this->testCaseId = $testCaseId;
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;

        // Mendapatkan semua pengguna yang tersedia
        $this->users = User::all();

        // Mengambil semua status yang tersedia
        $this->mStatus = MStatus::all();
    }

    // Fungsi untuk menyimpan hasil test baru
    public function store()
    {
        // Validasi input
        $validated = $this->validate([
            'userIdPenugasan' => ['required', Rule::exists('users', 'id')],
            'harapan' => 'required|string',
            'realisasi' => 'nullable|string',
            'kStatus' => 'required',
        ], [
            'userIdPenugasan.required' => 'Penugasan harus diisi!',
            'harapan.required' => 'Harapan harus diisi!',
            'kStatus.required' => 'Status harus diisi!',
        ]);

        // Mendapatkan kode hasil test terakhir dan membuat kode baru
        $maxKode = TestResult::where('test_case_id', $this->testCaseId)
            ->selectRaw('MAX(CAST(SUBSTRING(kode, 3) AS UNSIGNED)) as max_kode')
            ->pluck('max_kode')
            ->first();

        // Menentukan kode hasil test baru berdasarkan kode terakhir yang ditemukan
        $newCode = $maxKode
            ? 'HT'.str_pad($maxKode + 1, 2, '0', STR_PAD_LEFT)
            : 'HT01';

        // Membuat hasil test baru
        $testResult = TestResult::create([
            'kode' => $newCode,
            'test_case_id' => $this->testCaseId,
            'user_id_penugasan' => $validated['userIdPenugasan'],
            'harapan' => $validated['harapan'],
            'realisasi' => $validated['realisasi'],
            'k_status' => $validated['kStatus'],
        ]);

        // Menyimpan ID hasil test yang baru ditambahkan
        $this->testResultId = $testResult->id;

        // Menampilkan pesan sukses dan mengarahkan ke halaman komentar untuk hasil test ini
        session()->flash('success', 'Hasil Test berhasil ditambahkan!');

        return redirect()->route('komentar.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuiteId,
            'testCaseId' => $this->testCaseId,
            'testResultId' => $this->testResultId,
        ]);

        // Mereset input setelah berhasil menyimpan
        $this->reset(['userIdPenugasan', 'harapan', 'realisasi', 'kStatus']);
    }

    // Fungsi render untuk menampilkan data di halaman
    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.create', [
            'users' => $this->users,
            'mStatus' => $this->mStatus,
        ]);
    }
}
