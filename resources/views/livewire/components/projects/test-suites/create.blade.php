<div>
    <div wire:ignore.self class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- Adjust modal width -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Test Suite</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form> <!-- Livewire form submission -->    
                        <div class="row">
                            <!-- Judul -->
                            <div class="col-md-12 mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" wire:model="judul" placeholder="Masukkan Judul Test Suite" required>
                                @error('judul') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- PIC and Tanggal Mulai -->
                            <div class="col-md-6 mb-3">
                                <label for="pic" class="form-label">PIC</label>
                                <select class="form-select" id="pic" wire:model="userIdPic" required> <!-- camelCase -->
                                    <option value="">Pilih PIC</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('userIdPic') <span class="text-danger">{{ $message }}</span> @enderror <!-- camelCase -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggalMulai" class="form-label">Tanggal Mulai</label> <!-- camelCase -->
                                <input type="date" class="form-control" id="tanggalMulai" wire:model="tglMulai" required> <!-- camelCase -->
                                @error('tglMulai') <span class="text-danger">{{ $message }}</span> @enderror <!-- camelCase -->
                            </div>
    
                            <!-- Scenario Writer and Tanggal Selesai -->
                            <div class="col-md-6 mb-3">
                                <label for="scenarioWriter" class="form-label">Scenario Writer</label> <!-- camelCase -->
                                <select class="form-select" id="scenarioWriter" wire:model="userIdScenario" required> <!-- camelCase -->
                                    <option value="">Pilih Scenario Writer</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('userIdScenario') <span class="text-danger">{{ $message }}</span> @enderror <!-- camelCase -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggalSelesai" class="form-label">Tanggal Selesai</label> <!-- camelCase -->
                                <input type="date" class="form-control" id="tanggalSelesai" wire:model="tglSelesai" required> <!-- camelCase -->
                                @error('tglSelesai') <span class="text-danger">{{ $message }}</span> @enderror <!-- camelCase -->
                            </div>
    
                            <!-- Tester dan ref_tiket -->
                            <div class="col-md-6 mb-3">
                                <label for="tester" class="form-label">Tester</label>
                                <select class="form-select" id="tester" wire:model="userIdTester" required> <!-- camelCase -->
                                    <option value="">Pilih Tester</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('userIdTester') <span class="text-danger">{{ $message }}</span> @enderror <!-- camelCase -->
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="refTiket" class="form-label">Ref Tiket</label> <!-- camelCase -->
                                <input type="text" class="form-control" id="refTiket" wire:model="refTiket" placeholder="Masukkan Ref Tiket">
                                @error('refTiket') <span class="text-danger">{{ $message }}</span> @enderror <!-- camelCase -->
                            </div>
    
                            <!-- URL dan Perangkat -->
                            <div class="col-md-6 mb-3">
                                <label for="url" class="form-label">URL</label>
                                <input type="url" class="form-control" id="url" wire:model="url" placeholder="Masukkan URL">
                                @error('url') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="perangkat" class="form-label">Perangkat</label>
                                <input type="text" class="form-control" id="perangkat" wire:model="perangkat" placeholder="Masukkan Perangkat">
                                @error('perangkat') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Batasan -->
                            <div class="col-md-12 mb-3">
                                <label for="batasan" class="form-label">Batasan</label>
                                <textarea class="form-control" id="batasan" wire:model="batasan" placeholder="Masukkan Batasan"></textarea>
                                @error('batasan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" wire:click="store">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>