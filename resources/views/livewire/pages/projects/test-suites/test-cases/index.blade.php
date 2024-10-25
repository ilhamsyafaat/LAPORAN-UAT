<div>
    @include('livewire.components.pesan')
    <div class="container mt-5 position-relative">
        <!-- Dropdown Menu untuk Edit dan Hapus -->
        <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#modalEdit-{{ $testSuite->id }}">Edit</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#deleteUserModal{{ $testSuite->id }}">Hapus</a></li>
            </ul>
        </div>
        <livewire:components.projects.test-suites.test-cases.test-suites-edit :testSuiteId="$testSuiteId" :project_id="$projectId" />
        <livewire:components.projects.test-suites.test-cases.test-suites-delete :testSuiteId="$testSuiteId" :project_id="$projectId" />

        <div class="container mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('project.index') }}"
                                style="text-decoration: none;">Project</a></li>
                        @if ($testSuite->project)
                            <li class="breadcrumb-item">
                                <a href="{{ route('testsuite.index', $testSuite->project->id) }}"
                                    style="text-decoration: none;">
                                    {{ $testSuite->project->nama }}
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item">Project Not Found</li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $testSuite->kode }}</li>
                    </ol>
                </nav>
            </div>
            <!-- Detail Test Suite -->
            <div>
                <span class="breadcrumb-item active">#{{ $testSuite->kode }}</span>
                <h2>UAT {{ $testSuite->judul }}</h2>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <p><span class="label">PIC</span>: <span
                            class="value">{{ $testSuite->pic ? $testSuite->pic->name : '-' }}</span></p>
                    <p><span class="label">Scenario Writer</span>: <span
                            class="value">{{ $testSuite->scenario ? $testSuite->scenario->name : '-' }}</span></p>
                    <p><span class="label">Tester</span>: <span
                            class="value">{{ $testSuite->tester ? $testSuite->tester->name : '-' }}</span></p>
                </div>
                <div class="col-md-6">
                    <p><span class="label">Tanggal Mulai</span>: <span
                            class="value">{{ $testSuite->tgl_mulai ? \Carbon\Carbon::parse($testSuite->tgl_mulai)->format('d F Y') : '-' }}</span>
                    </p>
                    <p><span class="label">Tanggal Selesai</span>: <span
                            class="value">{{ $testSuite->tgl_selesai ? \Carbon\Carbon::parse($testSuite->tgl_selesai)->format('d F Y') : '-' }}</span>
                    </p>
                    <p><span class="label">Progress</span>: <span class="value">{{ $averageProgress }}%</span></p>
                </div>
                <div>
                    <p><span class="label">URL Tiket</span>: <span class="value"><a href="{{ $testSuite->url }}"
                                target="_blank" rel="noopener noreferrer">{{ $testSuite->url }}</a></span></p>
                    <p><span class="label">Ref Tiket</span>: <span
                            class="value">{{ $testSuite->ref_tiket ? $testSuite->ref_tiket : '-' }}</span></p>
                    <p><span class="label">Perangkat</span>: <span
                            class="value">{{ $testSuite->perangkat ? $testSuite->perangkat : '-' }}</span></p>
                     <div class="d-flex">
                        <span class="label">Batasan</span>:<span 
                            class="value">{!! nl2br(e($testSuite->batasan)) !!}</span>
                    </div>
                </div>
            </div>

            <!-- Daftar Test Case -->
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Test Case ({{ $testCaseCount }})</h5>
                    <div class="d-flex align-items-center ms-auto" style="margin-right: 10px;">
                        <input type="text" class="form-control" wire:model.live="search"
                            placeholder="Cari Test Case..." style="max-width: 250px;">
                    </div>
                    <button class="btn btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#modalCreateTestCase">Tambah Test Case</button>
                </div>

                <livewire:components.projects.test-suites.test-cases.create :projectId="$projectId" :testSuiteId="$testSuiteId" />

                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Judul Test Case</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($testCase as $testCases)
                                    <tr wire:click="goToTestResults({{ $projectId }}, {{ $testSuiteId }}, {{ $testCases->id }})"
                                        style="cursor: pointer;">
                                        <td>{{ $testCases->kode }}</td>
                                        <td>{{ $testCases->judul }}</td>
                                        <td>
                                            @if ($testCases->progress == 100)
                                                <i class="fa-solid fa-circle me-2 text-secondary"></i>
                                                {{ $testCases->progress }}%
                                            @elseif($testCases->progress >= 50)
                                                <i class="fa-solid fa-circle-half-stroke me-2 text-secondary"></i>
                                                {{ $testCases->progress }}%
                                            @else
                                                <i class="fa-regular fa-circle me-2 text-secondary"></i>
                                                {{ $testCases->progress }}%
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $testCase->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
