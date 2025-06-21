{{-- resources/views/pages/konsul-dokter/index.blade.php --}}

@extends('layouts.app') {{-- Pastikan ini sesuai dengan layout utama Anda --}}

@php
    use Illuminate\Support\Str; // Pastikan Str diimport jika digunakan untuk Str::limit
@endphp

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Riwayat Konsultasi Anda</h5>
        </div>
        <div class="card-body">
            {{-- Bagian untuk menampilkan pesan sukses/error --}}
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

            <div class="mb-3">
                {{-- Tombol ini sekarang akan mengarah ke rute 'consultations.create' --}}
                <a href="{{ route('consultations.create') }}" class="btn btn-success">Jadwalkan Konsultasi Baru</a>
            </div>

            @if ($consultations->isEmpty())
                <div class="alert alert-info" role="alert">
                    Anda belum memiliki riwayat konsultasi.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover"> {{-- Menggunakan kelas Bootstrap untuk tabel --}}
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Dokter</th>
                                <th>Tanggal Konsultasi</th>
                                <th>Catatan Pasien</th>
                                <th>Status</th>
                                <th>Respons Dokter/Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consultations as $index => $consultation)
                                <tr>
                                    {{-- Untuk nomor urut yang benar saat paginasi --}}
                                    <td>{{ $consultations->firstItem() + $index }}</td>
                                    <td>{{ $consultation->doctor->name ?? 'N/A' }}</td>
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
