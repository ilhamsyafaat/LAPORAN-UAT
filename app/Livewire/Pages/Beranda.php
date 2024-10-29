<?php

namespace App\Livewire\Pages;

use App\Models\MStatus;
use App\Models\TestCase;
use App\Models\TestResult;
use App\Models\TestSuite;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Beranda extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    // menghitung jumlah TestResult berdasarkan setiap status
    public function getChartData()
    {
        // Mengambil semua status dengan jumlah hasil test terkait
        $statuses = MStatus::withCount('testResults')->get();

        // Menyiapkan data dalam bentuk array label dan total
        $chartData = $statuses->map(function ($status) {
            return [
                'label' => $status->label,
                'total' => $status->test_results_count, // Mengambil jumlah test result per status
            ];
        });

        return $chartData;
    }


    public function render()
    {
        // Mengambil hasil test dengan relasi userPenugasan dan status, kemudian mempaginate hasilnya
        $testResults = TestResult::with(['userPenugasan', 'status'])
            ->paginate(5, ['*'], 'testResultsPage'); // Paginate dengan namespace 'testResultsPage'

        // Mengambil test case dengan relasi testSuite dan testResults, kemudian mempaginate hasilnya
        $testCases = TestCase::with('testSuite', 'testResults')
            ->paginate(5, ['*'], 'testCasesPage'); // Paginate dengan namespace 'testCasesPage'

        // Mengambil test suite dengan relasi project, kemudian mempaginate hasilnya
        $testSuites = TestSuite::with('project')
            ->paginate(5, ['*'], 'testSuitesPage'); // Paginate dengan namespace 'testSuitesPage'

        $chartData = $this->getChartData();

        // Mengembalikan view dengan data hasil query
        return view('livewire.pages.beranda', [
            'testResults' => $testResults,
            'testCases' => $testCases,
            'testSuites' => $testSuites,
            'chartData' => $chartData, // Tambahkan ini
        ]);
    }
}
