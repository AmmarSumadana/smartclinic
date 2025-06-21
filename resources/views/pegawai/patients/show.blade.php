@extends('layouts.template-pegawai') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.pegawai') }}">Dashboard Pegawai</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pegawai.patients.index') }}">Daftar Pasien</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pasien: {{ $user->name }}</li>
        </ol>
    </nav>

    <h2>Detail Pasien: {{ $user->name }}</h2>

    <div class="card mb-4">
        <div class="card-header">
            Informasi Profil
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Terdaftar Sejak:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
            {{-- Tambahkan informasi profil lain jika ada (misal: alamat, tgl lahir) --}}
        </div>
    </div>

    <ul class="nav nav-tabs mb-3" id="patientTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="rawat-inap-tab" data-bs-toggle="tab" data-bs-target="#rawat-inap" type="button" role="tab" aria-controls="rawat-inap" aria-selected="true">Rawat Inap</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="lab-test-tab" data-bs-toggle="tab" data-bs-target="#lab-test" type="button" role="tab" aria-controls="lab-test" aria-selected="false">Tes Lab</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="consultation-tab" data-bs-toggle="tab" data-bs-target="#consultation" type="button" role="tab" aria-controls="consultation" aria-selected="false">Konsultasi</button>
        </li>
        {{-- Tambahkan tab lain sesuai kebutuhan (misal: Medical History, Cek Medis) --}}
    </ul>

    <div class="tab-content" id="patientTabsContent">
        {{-- TAB RAWAT INAP --}}
        <div class="tab-pane fade show active" id="rawat-inap" role="tabpanel" aria-labelledby="rawat-inap-tab">
            <div class="card">
                <div class="card-header">Riwayat Rawat Inap</div>
                <div class="card-body">
                    @if ($user->rawatInaps->isEmpty())
                        <p>Tidak ada riwayat rawat inap untuk pasien ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pasien</th>
                                        <th>RS Tujuan</th>
                                        <th>Alasan</th>
                                        <th>Tgl Pengajuan</th>
                                        <th>Status</th>
                                        <th>Kamar</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->rawatInaps as $ri)
                                        <tr>
                                            <td>{{ $ri->patient_name }}</td>
                                            <td>{{ $ri->hospital_name }}</td>
                                            <td>{{ $ri->reason }}</td>
                                            <td>{{ $ri->created_at->format('d M Y') }}</td>
                                            <td>
                                                @php
                                                    $statusText = '';
                                                    switch ($ri->status) {
                                                        case 'pending': $statusText = 'Menunggu Konfirmasi'; break;
                                                        case 'approved': $statusText = 'Disetujui'; break;
                                                        case 'admitted': $statusText = 'Sedang Dirawat'; break;
                                                        case 'rejected': $statusText = 'Ditolak'; break;
                                                        case 'cancelled': $statusText = 'Dibatalkan'; break;
                                                        case 'discharged': $statusText = 'Selesai Dirawat'; break;
                                                        default: $statusText = 'Tidak Diketahui'; break;
                                                    }
                                                @endphp
                                                {{ $statusText }}
                                            </td>
                                            <td>{{ $ri->room_number ?? '-' }}</td>
                                            <td>{{ $ri->notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB TES LAB --}}
        <div class="tab-pane fade" id="lab-test" role="tabpanel" aria-labelledby="lab-test-tab">
            <div class="card">
                <div class="card-header">Riwayat Tes Lab</div>
                <div class="card-body">
                    @if ($user->labTests->isEmpty())
                        <p>Tidak ada riwayat tes lab untuk pasien ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Jenis Tes</th>
                                        <th>Tgl Permintaan</th>
                                        <th>Status</th>
                                        <th>Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->labTests as $lt)
                                        <tr>
                                            <td>{{ $lt->test_type }}</td>
                                            <td>{{ $lt->created_at->format('d M Y') }}</td>
                                            <td>{{ $lt->status }}</td>
                                            <td>
                                                @if ($lt->result_file_path)
                                                    <a href="{{ Storage::url($lt->result_file_path) }}" target="_blank" class="btn btn-sm btn-primary">Lihat Hasil</a>
                                                @else
                                                    Belum ada
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TAB KONSULTASI --}}
        <div class="tab-pane fade" id="consultation" role="tabpanel" aria-labelledby="consultation-tab">
            <div class="card">
                <div class="card-header">Riwayat Konsultasi</div>
                <div class="card-body">
                    @if ($user->consultations->isEmpty())
                        <p>Tidak ada riwayat konsultasi untuk pasien ini.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Dokter</th>
                                        <th>Subjek</th>
                                        <th>Tgl Konsultasi</th>
                                        <th>Status</th>
                                        <th>Respon Dokter</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->consultations as $con)
                                        <tr>
                                            <td>{{ $con->doctor->name ?? '-' }}</td> {{-- Asumsi ada relasi ke model Dokter --}}
                                            <td>{{ $con->subject }}</td>
                                            <td>{{ $con->created_at->format('d M Y') }}</td>
                                            <td>{{ $con->status }}</td>
                                            <td>{{ $con->response_notes ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Script untuk mengaktifkan tab Bootstrap --}}
    <script>
        var patientTabs = new bootstrap.Tab(document.getElementById('rawat-inap-tab'));
        patientTabs.show(); // Default to Rawat Inap tab on load
    </script>
@endpush
