<?php

namespace App\Livewire\Pages\Projects\TestSuites\TestCases\TestResults\Komentars;

use App\Models\Komentar;
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

    public $projectId;
    public $testSuiteId;
    public $testCaseId;
    public $testResultId;
    public $testCase;
    public $testSuite;
    public $testResult;
    public $users;
    public $mStatus;
    public $komentarCount;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['komentarUpdated' => 'render'];

    /**
     * Metode mount untuk menginisialisasi data saat komponen dipasang.
     *
     * @param int $projectId
     * @param int $testSuiteId
     * @param int $testCaseId
     * @param int $testResultId
     */
    public function mount($projectId, $testSuiteId, $testCaseId, $testResultId)
    {
        // Menginisialisasi properti dengan nilai dari parameter
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;
        $this->testCaseId = $testCaseId;
        $this->testResultId = $testResultId;

        // Mengambil data test result, test case, dan test suite
        $this->testResult = TestResult::with(['userPenugasan', 'status'])->findOrFail($testResultId);
        $this->testCase = TestCase::findOrFail($testCaseId);
        $this->testSuite = $this->testCase->testSuite;

        // Mengambil data pengguna yang bukan admin
        $this->users = User::whereHas('userRoles.role', function ($query) {
            $query->where('nama', '!=', 'Admin');
        })->get();
        // Mengambil semua status
        $this->mStatus = MStatus::all();
    }

    /**
     * Metode render untuk menampilkan halaman komentar dan menghitung total komentar.
     */
    public function render()
    {
        // Menghitung jumlah komentar berdasarkan test_result_id
        $this->komentarCount = Komentar::where('test_result_id', $this->testResultId)->count();

        // Mengambil data komentar dengan pagination
        $komentars = Komentar::with('user', 'status')
            ->where('test_result_id', $this->testResultId)
            ->paginate(8);

        // Mengembalikan view dengan data yang diperlukan
        return view('livewire.pages.projects.test-suites.test-cases.test-results.komentars.index', [
            'komentars' => $komentars,
            'testCase' => $this->testCase,
            'testSuite' => $this->testSuite,
            'testResult' => $this->testResult,
            'users' => $this->users,
            'mStatus' => $this->mStatus,
            'komentarCount' => $this->komentarCount,
        ]);
    }
}
