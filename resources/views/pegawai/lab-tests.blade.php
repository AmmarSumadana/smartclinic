@extends('layouts.template-pegawai')

@section('title', 'Kelola Hasil Lab')
@section('page-title', 'Daftar Hasil Tes Lab')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Hasil Tes Lab</h2>
        <p class="text-gray-600 text-base md:text-lg">Lihat, unggah, dan kelola hasil tes lab pasien.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Hasil Tes Lab</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">ID Tes</th>
                        <th scope="col">Nama Pasien</th>
                        <th scope="col" class="text-nowrap">Jenis Tes</th>
                        <th scope="col" class="text-nowrap">Tanggal Tes</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">LAB001</td>
                        <td class="text-nowrap">Budi Santoso</td>
                        <td>Darah Lengkap</td>
                        <td class="text-nowrap">2024-05-25</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Hasil">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" title="Unduh Hasil">
                                    <i class="fa-solid fa-download"></i> <span class="d-none d-md-inline">Unduh</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">LAB002</td>
                        <td class="text-nowrap">Siti Aminah</td>
                        <td>Urinalisis</td>
                        <td class="text-nowrap">2024-05-24</td>
                        <td><span class="badge bg-warning">Menunggu Unggah</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-success" title="Unggah Hasil">
                                    <i class="fa-solid fa-upload"></i> <span class="d-none d-md-inline">Unggah</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Batalkan Tes">
                                    <i class="fa-solid fa-times"></i> <span class="d-none d-md-inline">Batalkan</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">LAB003</td>
                        <td class="text-nowrap">Joko Susilo</td>
                        <td>X-Ray Dada</td>
                        <td class="text-nowrap">2024-05-23</td>
                        <td><span class="badge bg-info text-dark">Dalam Proses</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-secondary" title="Perbarui Status">
                                    <i class="fa-solid fa-sync-alt"></i> <span class="d-none d-md-inline">Update</span>
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
