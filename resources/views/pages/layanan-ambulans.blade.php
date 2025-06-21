@extends('layouts.app')

@section('title', 'Layanan Ambulans')
@section('page-title', 'Layanan Ambulans')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid">
    <div class="row">
        <!-- Form Pemesanan Ambulans -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-ambulance me-2"></i>Form Pemesanan Ambulans</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('layanan-ambulans.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama_pasien" class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror"
                                           id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien') }}" required>
                                    @error('nama_pasien')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('no_telepon') is-invalid @enderror"
                                           id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat_jemput" class="form-label">Alamat Penjemputan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('alamat_jemput') is-invalid @enderror"
                                              id="alamat_jemput" name="alamat_jemput" rows="3" required>{{ old('alamat_jemput') }}</textarea>
                                    @error('alamat_jemput')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alamat_tujuan" class="form-label">Alamat Tujuan</label>
                                    <textarea class="form-control @error('alamat_tujuan') is-invalid @enderror"
                                              id="alamat_tujuan" name="alamat_tujuan" rows="3">{{ old('alamat_tujuan') }}</textarea>
                                    @error('alamat_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipe_ambulans" class="form-label">Tipe Ambulans <span class="text-danger">*</span></label>
                                    <select class="form-select @error('tipe_ambulans') is-invalid @enderror"
                                            id="tipe_ambulans" name="tipe_ambulans" required>
                                        <option value="">Pilih Tipe Ambulans</option>
                                        <option value="standar" {{ old('tipe_ambulans') == 'standar' ? 'selected' : '' }}>Standar</option>
                                        <option value="icu" {{ old('tipe_ambulans') == 'icu' ? 'selected' : '' }}>ICU</option>
                                        <option value="nicu" {{ old('tipe_ambulans') == 'nicu' ? 'selected' : '' }}>NICU</option>
                                    </select>
                                    @error('tipe_ambulans')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_waktu" class="form-label">Tanggal & Waktu <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('tanggal_waktu') is-invalid @enderror"
                                           id="tanggal_waktu" name="tanggal_waktu" value="{{ old('tanggal_waktu') }}" required>
                                    @error('tanggal_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="kondisi_pasien" class="form-label">Kondisi Pasien</label>
                            <textarea class="form-control @error('kondisi_pasien') is-invalid @enderror"
                                      id="kondisi_pasien" name="kondisi_pasien" rows="3"
                                      placeholder="Jelaskan kondisi pasien secara singkat">{{ old('kondisi_pasien') }}</textarea>
                            @error('kondisi_pasien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_emergency" name="is_emergency" value="1"
                                       {{ old('is_emergency') ? 'checked' : '' }}>
                                <label class="form-check-label text-danger" for="is_emergency">
                                    <strong>Kondisi Darurat</strong>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-secondary me-md-2">Reset</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-paper-plane me-1"></i>Pesan Ambulans
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info & Peta -->
        <div class="col-lg-4">
            <!-- Info Layanan -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Layanan</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <i class="fas fa-clock text-primary fs-4 me-2"></i>
                                <span class="fw-bold">24/7</span>
                            </div>
                            <small class="text-muted">Layanan 24 Jam</small>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">Tipe Ambulans:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-ambulance text-success me-2"></i>
                            <strong>Standar:</strong> Untuk transportasi pasien umum
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-heartbeat text-warning me-2"></i>
                            <strong>ICU:</strong> Untuk pasien kritis dengan peralatan intensif
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-baby text-info me-2"></i>
                            <strong>NICU:</strong> Untuk bayi dan anak dengan perawatan khusus
                        </li>
                    </ul>

                    <div class="alert alert-warning mt-3">
                        <small><i class="fas fa-exclamation-triangle me-1"></i>
                        Untuk kondisi darurat, hubungi 119 atau datang langsung ke UGD terdekat.</small>
                    </div>
                </div>
            </div>

            <!-- Peta Lokasi -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Lokasi Rumah Sakit</h6>
                </div>
                <div class="card-body p-0">
                    @include('components.map')
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pemesanan -->
    @if(isset($layananAmbulans) && $layananAmbulans->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Pemesanan Ambulans</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pasien</th>
                                    <th>Tipe Ambulans</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Status</th>
                                    <th>Darurat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($layananAmbulans as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_pasien }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ strtoupper($item->tipe_ambulans) }}</span>
                                    </td>
                                    <td>{{ $item->tanggal_waktu->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($item->status == 'confirmed')
                                            <span class="badge bg-info">Dikonfirmasi</span>
                                        @elseif($item->status == 'on_way')
                                            <span class="badge bg-primary">Dalam Perjalanan</span>
                                        @elseif($item->status == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->is_emergency)
                                            <span class="badge bg-danger">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($item->status == 'pending')
                                            <form action="{{ route('layanan-ambulans.cancel', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Pemesanan Ambulans</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Nama Pasien:</strong><br>
                                                        {{ $item->nama_pasien }}<br><br>

                                                        <strong>No. Telepon:</strong><br>
                                                        {{ $item->no_telepon }}<br><br>

                                                        <strong>Tipe Ambulans:</strong><br>
                                                        <span class="badge bg-secondary">{{ strtoupper($item->tipe_ambulans) }}</span><br><br>

                                                        <strong>Tanggal & Waktu:</strong><br>
                                                        {{ $item->tanggal_waktu->format('d/m/Y H:i') }}<br><br>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Alamat Penjemputan:</strong><br>
                                                        {{ $item->alamat_jemput }}<br><br>

                                                        <strong>Alamat Tujuan:</strong><br>
                                                        {{ $item->alamat_tujuan ?: 'Tidak ditentukan' }}<br><br>

                                                        <strong>Status:</strong><br>
                                                        @if($item->status == 'pending')
                                                            <span class="badge bg-warning">Menunggu</span>
                                                        @elseif($item->status == 'confirmed')
                                                            <span class="badge bg-info">Dikonfirmasi</span>
                                                        @elseif($item->status == 'on_way')
                                                            <span class="badge bg-primary">Dalam Perjalanan</span>
                                                        @elseif($item->status == 'completed')
                                                            <span class="badge bg-success">Selesai</span>
                                                        @else
                                                            <span class="badge bg-danger">Dibatalkan</span>
                                                        @endif<br><br>

                                                        <strong>Kondisi Darurat:</strong><br>
                                                        @if($item->is_emergency)
                                                            <span class="badge bg-danger">Ya</span>
                                                        @else
                                                            <span class="badge bg-secondary">Tidak</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($item->kondisi_pasien)
                                                <hr>
                                                <strong>Kondisi Pasien:</strong><br>
                                                {{ $item->kondisi_pasien }}
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Set minimum datetime to current time
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const minDateTime = now.toISOString().slice(0, 16);
        document.getElementById('tanggal_waktu').min = minDateTime;
    });
</script>
@endpush
@endsection
