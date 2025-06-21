@extends('layouts.template-pegawai')

@section('title', 'Kelola Layanan Ambulans')
@section('page-title', 'Daftar Permintaan Ambulans')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Layanan Ambulans</h2>
        <p class="text-gray-600 text-base md:text-lg">Tinjau dan kelola permintaan layanan ambulans dari pasien.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Permintaan Ambulans</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">ID Permintaan</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col" class="text-nowrap">Lokasi Penjemputan</th>
                        <th scope="col" class="text-nowrap">Tujuan RS</th>
                        <th scope="col" class="text-nowrap">Tanggal/Waktu</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">AMB001</td>
                        <td class="text-nowrap">Rina Kusuma</td>
                        <td>Jl. Sudirman No. 12</td>
                        <td class="text-nowrap">RSUD dr. Soetomo</td>
                        <td class="text-nowrap">2024-05-27 10:30</td>
                        <td><span class="badge bg-warning">Menunggu Konfirmasi</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" title="Konfirmasi & Kirim">
                                    <i class="fa-solid fa-check"></i> <span class="d-none d-md-inline">Konfirmasi</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Tolak">
                                    <i class="fa-solid fa-times"></i> <span class="d-none d-md-inline">Tolak</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">AMB002</td>
                        <td class="text-nowrap">Doni Iskandar</td>
                        <td>Perumahan Griya Indah Blok A No. 5</td>
                        <td class="text-nowrap">RS Mitra Keluarga</td>
                        <td class="text-nowrap">2024-05-26 14:00</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">AMB003</td>
                        <td class="text-nowrap">Lisa Anggraini</td>
                        <td>Jl. Pahlawan No. 7, Kantor Polisi</td>
                        <td class="text-nowrap">RS Pondok Indah</td>
                        <td class="text-nowrap">2024-05-25 08:45</td>
                        <td><span class="badge bg-danger">Dibatalkan Pasien</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
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
