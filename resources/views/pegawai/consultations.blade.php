@extends('layouts.template-pegawai')

@section('title', 'Kelola Konsultasi')
@section('page-title', 'Daftar Konsultasi Pasien')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Konsultasi</h2>
        <p class="text-gray-600 text-base md:text-lg">Tinjau dan tangani permintaan konsultasi dari pasien.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Permintaan Konsultasi</h3>

        {{-- Use table-responsive to make the table responsive --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">ID Konsultasi</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col">Subjek</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-nowrap">Tanggal Pengajuan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">CONS001</td>
                        <td class="text-nowrap">Budi Santoso</td>
                        <td>Sakit Kepala Hebat dan Demam</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td class="text-nowrap">2024-05-15</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" title="Tanggapi">
                                    <i class="fa-solid fa-reply"></i> <span class="d-none d-md-inline">Tanggapi</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">CONS002</td>
                        <td class="text-nowrap">Siti Aminah</td>
                        <td>Keluhan Pernapasan</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td class="text-nowrap">2024-05-10</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" title="Tanggapi" disabled>
                                    <i class="fa-solid fa-reply"></i> <span class="d-none d-md-inline">Tanggapi</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">CONS003</td>
                        <td class="text-nowrap">Joko Susilo</td>
                        <td>Cek Rutin Kesehatan Jantung</td>
                        <td><span class="badge bg-info text-dark">Dalam Proses</span></td>
                        <td class="text-nowrap">2024-05-18</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" title="Tanggapi">
                                    <i class="fa-solid fa-reply"></i> <span class="d-none d-md-inline">Tanggapi</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- More rows can be added here -->
                </tbody>
            </table>
        </div>

        {{-- Placeholder for Pagination --}}
        <nav aria-label="Page navigation example" class="mt-4">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endsection
