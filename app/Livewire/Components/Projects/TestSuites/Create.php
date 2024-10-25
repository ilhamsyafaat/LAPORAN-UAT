<?php

namespace App\Livewire\Components\Projects\TestSuites;

use App\Models\TestSuite;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

// Menentukan layout untuk komponen ini menggunakan Livewire
#[Layout('components.layouts.app')]
class Create extends Component
{
    public $users;
    public $projectId;
    public $judul;
    public $userIdPic;
    public $tglMulai;
    public $tglSelesai;
    public $userIdScenario;
    public $userIdTester;
    public $refTiket;
    public $url;
    public $perangkat;
    public $batasan;

    public function mount()
    {
        // Mengambil daftar pengguna yang tidak memiliki peran 'Admin'
        $this->users = User::whereHas('userRoles.role', function ($query) {
            $query->where('nama', '!=', 'Admin');
        })->get();
    }

    public function store()
    {
        // Validasi data input
        $this->validate([
            'judul' => 'required|string|max:255',
            'userIdPic' => 'required|exists:users,id',
            'tglMulai' => 'required|date|before_or_equal:tglSelesai',
            'tglSelesai' => 'required|date|after_or_equal:tglMulai',
            'userIdScenario' => 'required|exists:users,id',
            'userIdTester' => 'required|exists:users,id',
            'refTiket' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'perangkat' => 'nullable|string|max:255',
            'batasan' => 'nullable|string',
        ], [
            'judul.required' => 'Judul test suite harus diisi.',
            'userIdPic.required' => 'PIC harus dipilih.',
            'userIdPic.exists' => 'PIC yang dipilih tidak valid.',
            'tglMulai.required' => 'Tanggal mulai harus diisi.',
            'tglMulai.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',
            'tglSelesai.required' => 'Tanggal selesai harus diisi.',
            'tglSelesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'userIdScenario.required' => 'Scenario Writer harus dipilih.',
            'userIdScenario.exists' => 'Scenario Writer yang dipilih tidak valid.',
            'userIdTester.required' => 'Tester harus dipilih.',
            'userIdTester.exists' => 'Tester yang dipilih tidak valid.',
            'url.url' => 'URL yang dimasukkan harus valid.',
        ]);

        // Menghitung kode terbaru untuk test suite berdasarkan proyek
        $maxKode = TestSuite::where('project_id', $this->projectId)
            ->selectRaw('MAX(CAST(SUBSTRING(kode, 3) AS UNSIGNED)) as max_kode')
            ->pluck('max_kode')
            ->first();

        // Membuat kode baru berdasarkan kode maksimum yang ada
        $newCode = $maxKode
            ? 'TS'.str_pad($maxKode + 1, 2, '0', STR_PAD_LEFT) // Menambahkan 1 ke kode maksimum dan mengisi dengan 0
            : 'TS01'; // Jika tidak ada, mulai dengan TS01

        // Simpan data test suite baru ke dalam database
        $testSuite = TestSuite::create([
            'kode' => $newCode,
            'project_id' => $this->projectId,
            'judul' => $this->judul,
            'user_id_pic' => $this->userIdPic,
            'user_id_scenario' => $this->userIdScenario,
            'user_id_tester' => $this->userIdTester,
            'tgl_mulai' => $this->tglMulai,
            'tgl_selesai' => $this->tglSelesai,
            'ref_tiket' => $this->refTiket,
            'url' => $this->url,
            'perangkat' => $this->perangkat,
            'batasan' => $this->batasan,
            'progress' => 0,
        ]);

        // Reset properti form setelah data disimpan
        $this->reset([
            'judul',
            'userIdPic',
            'tglMulai',
            'tglSelesai',
            'userIdScenario',
            'userIdTester',
            'refTiket',
            'url',
            'perangkat',
            'batasan',
        ]);

        // Menyimpan pesan sukses ke dalam session
        session()->flash('success', 'Test Suite berhasil ditambahkan!');

        // Redirect ke route dengan parameter projectId dan ID dari test suite yang baru dibuat
        return redirect()->route('testcase.index', [
            'projectId' => $this->projectId,  // Pastikan projectId sudah di-set
            'testSuiteId' => $testSuite->id,  // Menggunakan ID dari test suite yang baru dibuat
        ]);
    }

    // Metode untuk merender tampilan komponen
    public function render()
    {
        return view('livewire.components.projects.test-suites.create');
    }
}
