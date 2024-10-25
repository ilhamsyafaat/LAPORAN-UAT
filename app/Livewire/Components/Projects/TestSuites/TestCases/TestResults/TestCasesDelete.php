<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults;

use App\Models\TestCase;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class TestCasesDelete extends Component
{
    public $testCaseId;
    public $testCaseName;

    public function mount($testCaseId)
    {
        $testCase = TestCase::findOrFail($testCaseId);
        $this->testCaseId = $testCase->id;
        $this->testCaseName = $testCase->judul;
    }

    public function deleteTestCase()
    {
        $testCase = TestCase::findOrFail($this->testCaseId);

        // Cek apakah Test Case memiliki Test Results
        if ($testCase->testResults()->count() > 0) {
            session()->flash('error', 'Test Case tidak bisa dihapus karena ada Test Result!');

            return redirect()->route('testresult.index', [
                'projectId' => $testCase->testSuite->project_id,
                'testSuiteId' => $testCase->test_suite_id,
                'testCaseId' => $testCase->id,
            ]);
        }

        // Menyimpan projectId dan testSuiteId sebelum menghapus Test Case
        $projectId = $testCase->testSuite->project_id;
        $testSuiteId = $testCase->test_suite_id;

        // Hapus Test Case
        $testCase->delete();

        session()->flash('success', 'Test Case berhasil dihapus!');

        return redirect()->route('testcase.index', [
            'projectId' => $projectId,
            'testSuiteId' => $testSuiteId,
        ]);
    }

    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.test-cases-delete');
    }
}
