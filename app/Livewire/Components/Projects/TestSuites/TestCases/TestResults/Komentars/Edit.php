<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults\Komentars;

use App\Models\Komentar;
use App\Models\MStatus;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Edit extends Component
{
    public $komentar; // Untuk objek Komentar
    public $komentarText; // Untuk teks komentar
    public $userIdPenugasan;
    public $kStatus;
    public $users;
    public $mStatus;

    /**
     * Metode mount untuk inisialisasi data komentar berdasarkan ID.
     *
     * @param mixed $komentarId
     */
    public function mount($komentarId)
    {
        // Ambil komentar berdasarkan ID
        $this->komentar = Komentar::find($komentarId);

        if ($this->komentar) {
            // Set nilai awal berdasarkan data komentar
            $this->komentarText = $this->komentar->komentar;
            $this->userIdPenugasan = $this->komentar->user_id_penugasan;
            $this->kStatus = $this->komentar->k_status;

            // Muat data user dan status untuk dropdown
            $this->users = User::all();
            $this->mStatus = MStatus::all();
        } else {
            session()->flash('error', 'Komentar tidak ditemukan.');
        }
    }

    /**
     * Metode updateKomentar untuk memperbarui komentar ke database.
     */
    public function updateKomentar()
    {
        $this->validate([
            'komentarText' => 'required|min:3',
        ], [
            'komentarText.required' => 'Komentar tidak boleh kosong.',
        ]);

        if ($this->komentar) {
            $this->komentar->update([
                'komentar' => $this->komentarText,
                'user_id_penugasan' => $this->userIdPenugasan,
                'k_status' => $this->kStatus,
                'tgl_komentar' => Carbon::now(),
                'is_edited' => true,
            ]);

            session()->flash('success', 'Komentar berhasil diperbarui.');

            return redirect()->route('komentar.index', [
                'projectId' => $this->komentar->testResult->testcase->testsuite->project->id,
                'testSuiteId' => $this->komentar->testResult->testcase->testsuite->id,
                'testCaseId' => $this->komentar->testResult->testcase->id,
                'testResultId' => $this->komentar->test_result_id,
            ]);
        }
    }

    /**
     * Metode render untuk menampilkan halaman form edit komentar.
     */
    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.komentars.edit');
    }
}
