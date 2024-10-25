<div>
    <div wire:ignore.self class="modal fade" id="editKomentarModal{{ $komentar->id }}" tabindex="-1"
        aria-labelledby="editKomentarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKomentarLabel">Edit Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for Editing Komentar -->
                    <form wire:submit.prevent="updateKomentar">
                        <!-- Penugasan -->
                        <div class="mb-3">
                            <label for="penugasan" class="form-label">Penugasan</label>
                            <select class="form-select" wire:model="userIdPenugasan" id="penugasan" disabled>
                                <option value="">Pilih Penugasan</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $userIdPenugasan ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" wire:model="kStatus" id="status" disabled>
                                <option value="">Pilih Status</option>
                                @foreach ($mStatus as $status)
                                    <option value="{{ $status->k_status }}"
                                        {{ $status->k_status == $kStatus ? 'selected' : '' }}>
                                        {{ $status->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea class="form-control @error('komentarText') is-invalid @enderror" id="komentar"
                                wire:model.defer="komentarText"></textarea>
                            @error('komentarText')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
