<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults\Komentars;

use App\Models\Komentar;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Delete extends Component
{
    public $komentar;

    /**
     * Metode mount untuk mengambil data komentar berdasarkan ID.
     */
    public function mount($komentarId)
    {
        $this->komentar = Komentar::find($komentarId);

        if (!$this->komentar) {
            session()->flash('error', 'Komentar tidak ditemukan.');
        }
    }

    /**
     * Metode deleteKomentar untuk menghapus komentar dari database.
     */
    public function deleteKomentar()
    {
        if ($this->komentar) {
            $projectId = $this->komentar->testResult->testcase->testsuite->project->id;
            $testSuiteId = $this->komentar->testResult->testcase->testsuite->id;
            $testCaseId = $this->komentar->testResult->testcase->id;
            $testResultId = $this->komentar->test_result_id;

            // Hapus komentar
            $this->komentar->delete();

            // Redirect ke halaman komentar dengan pesan sukses
            return redirect()->route('komentar.index', [
                'projectId' => $projectId,
                'testSuiteId' => $testSuiteId,
                'testCaseId' => $testCaseId,
                'testResultId' => $testResultId,
            ])->with('success', 'Komentar berhasil dihapus.');
        }
    }

    /**
     * Metode render untuk menampilkan halaman konfirmasi delete.
     */
    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.komentars.delete');
    }
}
