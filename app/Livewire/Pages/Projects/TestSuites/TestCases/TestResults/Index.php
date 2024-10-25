<?php

namespace App\Livewire\Pages\Projects\TestSuites\TestCases\TestResults;

use App\Models\MStatus;
use App\Models\TestCase;
use App\Models\TestResult;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Index extends Component
{
    use WithPagination;

    // Inisialisasi variabel yang akan digunakan dalam komponen
    public $projectId;
    public $testSuiteId;
    public $testCaseId;
    public $testCase;
    public $testSuite;
    public $search;
    public $testResultsCount;
    public $mStatus;
    public $users;

    // Mengatur tema pagination menggunakan Bootstrap
    protected $paginationTheme = 'bootstrap';

    // Fungsi mount untuk menginisialisasi data yang dibutuhkan berdasarkan parameter URL
    public function mount($projectId, $testSuiteId, $testCaseId)
    {
        // Menyimpan parameter yang diterima ke dalam variabel komponen
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;
        $this->testCaseId = $testCaseId;

        // Mendapatkan data Test Case dan Test Suite terkait
        $this->testCase = TestCase::findOrFail($testCaseId);
        $this->testSuite = $this->testCase->testSuite;

        // Mengambil semua status (mStatus) yang tersedia
        $this->mStatus = MStatus::all();

        // Mendapatkan semua pengguna yang tersedia
        $this->users = User::all();
    }

    // Fungsi yang dijalankan saat pencarian diperbarui untuk mereset halaman pagination
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Fungsi render untuk menampilkan data di halaman
    public function render()
    {
        // Mengambil hasil test terkait dengan user dan status, serta memfilter berdasarkan pencarian
        $testResults = TestResult::with(['userPenugasan', 'status'])
            ->where('test_case_id', $this->testCaseId)
            ->search($this->search)
            ->paginate(5);

        // Menyimpan jumlah total test result yang diambil
        $this->testResultsCount = $testResults->total();

        // Mengembalikan view dengan data yang sudah disiapkan
        return view('livewire.pages.projects.test-suites.test-cases.test-results.index', [
            'testResults' => $testResults,
            'testCase' => $this->testCase,
            'testSuite' => $this->testSuite,
            'mStatus' => $this->mStatus,
            'users' => $this->users,
        ]);
    }

    // Fungsi untuk mengarahkan pengguna ke halaman komentar untuk hasil test yang dipilih
    public function redirectToKomentars($testResultId)
    {
        return redirect()->route('komentar.index', [
            $this->projectId,
            $this->testSuiteId,
            $this->testCaseId,
            $testResultId,
        ]);
    }
}
