<?php

namespace App\Livewire\Pages\Projects\TestSuites\TestCases;

use App\Models\TestSuite;
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
    public $search;

    protected $paginationTheme = 'bootstrap';

    // Mendefinisikan listener untuk event tertentu
    protected $listeners = [
        'testSuiteUpdate' => 'render', // Refresh tampilan saat test suite diperbarui
        'testSuiteDelete' => 'render', // Refresh tampilan saat test suite dihapus
        'testCaseCreate' => 'render', // Refresh tampilan saat test case baru dibuat
    ];

    public function mount($projectId, $testSuiteId)
    {
        // Menginisialisasi ID proyek dan ID test suite dari parameter
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;
    }

    // Method ini dipanggil setiap kali nilai pencarian diperbarui
    public function updatingSearch()
    {
        // Mengatur ulang halaman saat pencarian diperbarui
        $this->resetPage();
    }

    // Method untuk mengarahkan ke halaman hasil test results
    public function goToTestResults($projectId, $testSuiteId, $testCaseId)
    {
        // Mengalihkan pengguna ke halaman hasil test dengan parameter yang diberikan
        return redirect()->route('testresult.index', [
            $projectId, $testSuiteId, $testCaseId,
        ]);
    }

    public function render()
    {
        // Mengambil test suite berdasarkan project_id dan test_suite_id
        $testSuite = TestSuite::where('project_id', $this->projectId)
            ->findOrFail($this->testSuiteId);

        // Mendapatkan query untuk test cases yang terkait dengan test suite ini
        $query = $testSuite->testCases();

        // Jika ada pencarian, tambahkan filter ke query
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode', 'like', "%{$this->search}%")
                    ->orWhere('judul', 'like', "%{$this->search}%");
            });
        }

        // Menghitung total test cases dan mengambil paginasi
        $testCaseCount = $query->count();
        $testCase = $query->paginate(5);

        // Menghitung total dan rata-rata progress dari test cases
        $totalProgress = $query->sum('progress');
        $averageProgress = $testCaseCount > 0 ? (int) ($totalProgress / $testCaseCount) : 0;
        $users = User::all();

        return view('livewire.pages.projects.test-suites.test-cases.index', [
            'testSuite' => $testSuite,
            'testCase' => $testCase,
            'testCaseCount' => $testCaseCount,
            'users' => $users,
            'averageProgress' => $averageProgress,
        ]);
    }
}
