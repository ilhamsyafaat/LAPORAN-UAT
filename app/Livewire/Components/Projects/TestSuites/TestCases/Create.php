<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases;

use App\Models\TestCase;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Create extends Component
{
    public $judul;
    public $praKondisi = [];
    public $tahapTesting = [];
    public $dataInput;
    public $testSuiteId;
    public $projectId;

    public function mount($projectId, $testSuiteId)
    {
        $this->projectId = $projectId;
        $this->testSuiteId = $testSuiteId;
        $this->praKondisi[] = ''; // Menambahkan field prakondisi awal
        $this->tahapTesting[] = ''; // Menambahkan field tahap testing awal
    }

    public function addPrakondisi()
    {
        $this->praKondisi[] = ''; // Menambah input prakondisi baru
    }

    public function addTahapTesting()
    {
        $this->tahapTesting[] = ''; // Menambah input tahap testing baru
    }

    public function removePrakondisi($index)
    {
        unset($this->praKondisi[$index]);
        $this->praKondisi = array_values($this->praKondisi); // Reset indeks array
    }

    public function removeTahapTesting($index)
    {
        unset($this->tahapTesting[$index]);
        $this->tahapTesting = array_values($this->tahapTesting); // Reset indeks array
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'praKondisi' => 'required|array|min:1',
            'praKondisi.*' => 'required|string|max:255',
            'tahapTesting' => 'required|array|min:1',
            'tahapTesting.*' => 'required|string|max:255',
            'dataInput' => 'required|string',
            'testSuiteId' => 'required|integer|exists:test_suite,id', // Sesuaikan dengan nama tabel
        ]);

        // Ambil nilai maksimum dari kolom kode yang ada, menggunakan perintah query langsung
        $maxKode = TestCase::where('test_suite_id', $this->testSuiteId)
            ->selectRaw('MAX(CAST(SUBSTRING(kode, 3) AS UNSIGNED)) as max_kode')
            ->pluck('max_kode')
            ->first();

        // Generate kode baru
        $newCode = $maxKode
            ? 'TC'.str_pad($maxKode + 1, 2, '0', STR_PAD_LEFT)
            : 'TC01';

        // Simpan data
        $testCase = TestCase::create([
            'kode' => $newCode,
            'test_suite_id' => $this->testSuiteId,
            'judul' => $this->judul,
            'prakondisi' => json_encode($this->praKondisi),
            'tahap_testing' => json_encode($this->tahapTesting),
            'data_input' => $this->dataInput,
            'progress' => 0,
        ]);

        // Redirect ke halaman test results
        return redirect()->route('testresult.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuiteId,
            'testCaseId' => $testCase->id, // Ambil ID test case yang baru dibuat
        ])->with('success', 'Test case berhasil ditambahkan!');
    }

    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.create');
    }
}
