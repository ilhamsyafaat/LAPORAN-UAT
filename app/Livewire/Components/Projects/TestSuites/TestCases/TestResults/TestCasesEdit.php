<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases\TestResults;

use App\Models\TestCase;
use Livewire\Attributes\Layout;
use Livewire\Component;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class TestCasesEdit extends Component
{
    public $testCaseId;
    public $judul;
    public $praKondisi = [];
    public $tahapTesting = [];
    public $dataInput;
    public $testCase;
    public $testSuiteId;
    public $projectId;

    public function mount($testCaseId)
    {
        $testCase = TestCase::findOrFail($testCaseId); // Mencari test case berdasarkan ID

        // Mengisi properti dengan data dari test case
        $this->testCase = $testCase;
        $this->testCaseId = $testCase->id;
        $this->judul = $testCase->judul;
        $this->praKondisi = json_decode($testCase->prakondisi, true) ?? []; // Mengkonversi JSON pra-kondisi menjadi array
        $this->tahapTesting = json_decode($testCase->tahap_testing, true) ?? []; // Mengkonversi JSON tahap testing menjadi array
        $this->dataInput = $testCase->data_input; // Mengambil data input
        $this->testSuiteId = $testCase->test_suite_id;
        $this->projectId = $testCase->testSuite->project_id;
    }

    // Menambahkan elemen baru ke daftar pra-kondisi
    public function addPrakondisi()
    {
        $this->praKondisi[] = ''; // Menambahkan string kosong sebagai pra-kondisi baru
    }

    // Menambahkan elemen baru ke daftar tahap testing
    public function addTahapTesting()
    {
        $this->tahapTesting[] = ''; // Menambahkan string kosong sebagai tahap testing baru
    }

    // Menghapus pra-kondisi berdasarkan indeks yang diberikan
    public function removePrakondisi($index)
    {
        unset($this->praKondisi[$index]); // Menghapus elemen dari array berdasarkan indeks
        $this->praKondisi = array_values($this->praKondisi); // Mengatur ulang indeks array
    }

    // Menghapus tahap testing berdasarkan indeks yang diberikan
    public function removeTahapTesting($index)
    {
        unset($this->tahapTesting[$index]); // Menghapus elemen dari array berdasarkan indeks
        $this->tahapTesting = array_values($this->tahapTesting); // Mengatur ulang indeks array
    }

    public function update()
    {
        // Validasi input sebelum melakukan pembaruan
        $this->validate([
            'judul' => 'required|string|max:255',
            'praKondisi' => 'required|array|min:1',
            'praKondisi.*' => 'required|string|max:255',
            'tahapTesting' => 'required|array|min:1',
            'tahapTesting.*' => 'required|string|max:255',
            'dataInput' => 'required|string',
        ]);

        // Mencari test case berdasarkan ID

        $testCase = TestCase::findOrFail($this->testCaseId);

        // Melakukan pembaruan data test case
        $testCase->update([
            'judul' => $this->judul,
            'prakondisi' => json_encode($this->praKondisi), // Mengonversi array pra-kondisi menjadi JSON
            'tahap_testing' => json_encode($this->tahapTesting), // Mengonversi array tahap testing menjadi JSON
            'data_input' => $this->dataInput, // Memperbarui data input
        ]);

        session()->flash('success', 'Test Case Berhasil di Update'); // Menampilkan pesan sukses

        return redirect()->route('testresult.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuiteId,
            'testCaseId' => $testCase->id,
        ]);
    }

    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-results.test-cases-edit');
    }
}
