@extends('layouts.template-pegawai')

@section('title', 'Kelola Rawat Inap')
@section('page-title', 'Daftar Permintaan Rawat Inap')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Rawat Inap</h2>
        <p class="text-gray-600 text-base md:text-lg">Tinjau dan proses pendaftaran rawat inap pasien.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Permintaan Rawat Inap</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">ID Permintaan</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col" class="text-nowrap">Tanggal Pengajuan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ruangan</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">RI001</td>
                        <td class="text-nowrap">Dewi Lestari</td>
                        <td class="text-nowrap">2024-05-20</td>
                        <td><span class="badge bg-primary">Menunggu Persetujuan</span></td>
                        <td>Belum Ditentukan</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" title="Proses">
                                    <i class="fa-solid fa-check"></i> <span class="d-none d-md-inline">Proses</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Batalkan">
                                    <i class="fa-solid fa-times"></i> <span class="d-none d-md-inline">Batalkan</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">RI002</td>
                        <td class="text-nowrap">Agus Salim</td>
                        <td class="text-nowrap">2024-05-18</td>
                        <td><span class="badge bg-success">Disetujui (Kamar 101)</span></td>
                        <td>Kamar 101</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" title="Selesai/Discharge">
                                    <i class="fa-solid fa-hospital-user"></i> <span class="d-none d-md-inline">Discharge</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">RI003</td>
                        <td class="text-nowrap">Rina Kusuma</td>
                        <td class="text-nowrap">2024-05-22</td>
                        <td><span class="badge bg-warning">Tertunda (Penuh)</span></td>
                        <td>Menunggu</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" title="Proses">
                                    <i class="fa-solid fa-check"></i> <span class="d-none d-md-inline">Proses</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Batalkan">
                                    <i class="fa-solid fa-times"></i> <span class="d-none d-md-inline">Batalkan</span>
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
