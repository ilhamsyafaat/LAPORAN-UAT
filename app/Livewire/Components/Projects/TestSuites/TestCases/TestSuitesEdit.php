<?php

namespace App\Livewire\Components\Projects\TestSuites\TestCases;

use App\Models\TestSuite;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class TestSuitesEdit extends Component
{
    public $testSuiteId;
    public $testSuite;
    public $users;
    public $judul;
    public $userIdPic;
    public $tglMulai;
    public $userIdScenario;
    public $tglSelesai;
    public $userIdTester;
    public $refTiket;
    public $url;
    public $perangkat;
    public $batasan;
    public $projectId;

    // Aturan validasi untuk properti yang diisi
    protected $rules = [
        'judul' => 'required|string|max:255',
        'userIdPic' => 'required|integer',
        'tglMulai' => 'required|date',
        'userIdScenario' => 'required|integer',
        'tglSelesai' => 'required|date',
        'userIdTester' => 'required|integer',
        'refTiket' => 'nullable|string|max:255',
        'url' => 'nullable|string|max:255',
        'perangkat' => 'nullable|string|max:255',
        'batasan' => 'nullable|string',
    ];

    public function mount($testSuiteId, $projectId)
    {
        // Inisialisasi data dari test suite yang ada
        $this->testSuiteId = $testSuiteId; // Menyimpan ID test suite
        $this->projectId = $projectId; // Menyimpan ID proyek
        $this->testSuite = TestSuite::findOrFail($testSuiteId); // Mengambil data test suite berdasarkan ID
        $this->users = User::all(); // Mengambil semua pengguna
        $this->judul = $this->testSuite->judul; // Menginisialisasi judul dengan nilai dari test suite
        $this->userIdPic = $this->testSuite->user_id_pic;
        $this->tglMulai = $this->testSuite->tgl_mulai ? Carbon::parse($this->testSuite->tgl_mulai)->format('Y-m-d') : '';
        $this->userIdScenario = $this->testSuite->user_id_scenario;
        $this->tglSelesai = $this->testSuite->tgl_selesai ? Carbon::parse($this->testSuite->tgl_selesai)->format('Y-m-d') : '';
        $this->userIdTester = $this->testSuite->user_id_tester;
        $this->refTiket = $this->testSuite->ref_tiket;
        $this->url = $this->testSuite->url;
        $this->perangkat = $this->testSuite->perangkat;
        $this->batasan = $this->testSuite->batasan;
    }

    public function update()
    {
        // Melakukan validasi data
        $this->validate();

        // Update data test suite
        $this->testSuite->update([
            'judul' => $this->judul,
            'user_id_pic' => $this->userIdPic,
            'tgl_mulai' => $this->tglMulai,
            'user_id_scenario' => $this->userIdScenario,
            'tgl_selesai' => $this->tglSelesai,
            'user_id_tester' => $this->userIdTester,
            'ref_tiket' => $this->refTiket,
            'url' => $this->url,
            'perangkat' => $this->perangkat,
            'batasan' => $this->batasan,
        ]);

        // Menyimpan pesan sukses ke dalam session
        session()->flash('success', 'Test Suite Berhasil Di Update');

        // Redirect ke route dengan parameter projectId dan ID dari test suite yang sudah diperbarui
        return redirect()->route('testcase.index', [
            'projectId' => $this->projectId,
            'testSuiteId' => $this->testSuite->id,
        ]);
    }

    public function render()
    {
        return view('livewire.components.projects.test-suites.test-cases.test-suites-edit');
    }
}
