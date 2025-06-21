{{-- resources/views/pegawai/consultations/index.blade.php --}}

@extends('layouts.template-pegawai') {{-- Atau layout khusus pegawai Anda, misalnya layouts.pegawai --}}

@php
    use Illuminate\Support\Str; // Pastikan Str diimport jika digunakan untuk Str::limit
@endphp

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Daftar Permintaan Konsultasi Pasien</h5>
        </div>
        <div class="card-body">
            {{-- Pesan sukses/error --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($consultations->isEmpty())
                <div class="alert alert-info" role="alert">
                    Tidak ada permintaan konsultasi yang tersedia.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover"> {{-- Menggunakan kelas Bootstrap untuk tabel --}}
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pasien</th>
                                <th>Dokter Tujuan</th>
                                <th>Tanggal Konsultasi</th>
                                <th>Catatan Pasien</th>
                                <th>Status</th>
                                <th>Respon Pegawai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consultations as $consultation)
                                <tr>
                                    <td>{{ $consultation->id }}</td>
                                    <td>{{ $consultation->patient->name ?? 'N/A' }}</td> {{-- Mengakses nama pasien --}}
                                    <td>{{ $consultation->doctor->name ?? 'N/A' }}</td> {{-- Mengakses nama dokter tujuan --}}
                                    <td>{{ $consultation->formatted_consultation_date }}</td>
                                    <td>{{ Str::limit($consultation->notes, 50, '...') }}</td>
                                    <td>
                                        <span class="badge {{
                                            $consultation->status == 'pending' ? 'bg-warning' :
                                            ($consultation->status == 'approved' ? 'bg-info' :
                                            ($consultation->status == 'completed' ? 'bg-success' : 'bg-danger'))
                                        }}">
                                            {{ ucfirst($consultation->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $consultation->response_notes ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('pegawai.consultations.show', $consultation->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <form action="{{ route('pegawai.consultations.destroy', $consultation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus konsultasi ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Link Pagination Bootstrap --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $consultations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
