<div>
    @include('livewire.components.pesan')
    <div class="container mt-5 position-relative">
        <div class="dropdown position-absolute top-0 end-0 mt-2 me-2">
            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#modalEditTestCase-{{ $testCase->id }}">Edit</a></li>
                <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                        data-bs-target="#deleteModalTestCase{{ $testCase->id }}">Hapus</a></li>
            </ul>
        </div>

        <livewire:components.projects.test-suites.test-cases.test-results.test-cases-edit :projectId="$projectId" :testSuiteId="$testSuiteId" :testCaseId="$testCaseId" />
        <livewire:components.projects.test-suites.test-cases.test-results.test-cases-delete :projectId="$projectId" :testSuiteId="$testSuiteId" :testCaseId="$testCaseId" />
    
        <div class="container mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('project.index') }}" style="text-decoration: none;">Project</a></li>
                        @if($testSuite->project)
                            <li class="breadcrumb-item">
                                <a href="{{ route('testsuite.index', $testSuite->project->id) }}" style="text-decoration: none;">
                                    {{ $testSuite->project->nama }}
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item">Project Not Found</li>
                        @endif
    
                        @if($testSuite)
                            <li class="breadcrumb-item">
                                <a href="{{ route('testcase.index', [$testSuite->project->id, $testSuite->id]) }}" style="text-decoration: none;">
                                    {{ $testSuite->kode }}
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item">Test Suite Not Found</li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">{{ $testCase->kode }}</li>
                    </ol>
                </nav>
            </div>
    
            <div>
                <span class="breadcrumb-item active">#{{ $testCase->kode }}</span>
                <h2>{{ $testCase->judul }}</h2>
            </div>
    
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6>Prakondisi</h6>
                    @if($testCase->prakondisi && json_decode($testCase->prakondisi))
                        <ul>
                            @foreach(json_decode($testCase->prakondisi) as $prakondisi)
                                <li>{{ $prakondisi }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>-</p>
                    @endif
                </div>
    
                <div class="col-md-6">
                    <h6>Data Input</h6>
                    @if($testCase->data_input)
                        <p>{!! nl2br(e($testCase->data_input)) !!}</p>
                    @else
                        <p>-</p>
                    @endif
                </div>
            </div>
    
            <div class="row mt-4">
                <div class="col-6">
                    <h6>Tahap Testing</h6>
                    @if($testCase->tahap_testing && json_decode($testCase->tahap_testing))
                        <ul>
                            @foreach(json_decode($testCase->tahap_testing) as $tahap)
                                <li>{{ $tahap }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>-</p>
                    @endif
                </div>
            </div>
    
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Hasil Test ({{ $testResultsCount }})</h5>
                    <div class="d-flex align-items-center ms-auto" style="margin-right: 10px;">
                        <input wire:model.live="search" type="text" class="form-control" placeholder="Cari Hasil Test" style="max-width: 250px;">
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestResultModal">Tambah Hasil Test</button>
                </div>

                <livewire:components.projects.test-suites.test-cases.test-results.create :projectId="$projectId" :testSuiteId="$testSuiteId" :testCaseId="$testCaseId" />
                
                <div class="bg-white p-4 rounded shadow-sm">   
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Harapan</th>
                                    <th>Realisasi</th>
                                    <th>Penugasan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($testResults as $testResult)
                                    <tr wire:click="redirectToKomentars({{ $testResult->id }})" style="cursor: pointer;">
                                        <td>{{ $testResult->kode }}</td>
                                        <td>{{ $testResult->harapan }}</td>
                                        <td>{{ $testResult->realisasi }}</td>
                                        <td>{{ $testResult->userPenugasan->name }}</td>
                                        <td>{{ $testResult->status->label }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $testResults->links() }}
                </div>
            </div>
        </div>
    </div>    
</div>
