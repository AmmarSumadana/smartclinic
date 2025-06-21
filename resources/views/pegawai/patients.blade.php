@extends('layouts.template-pegawai')

@section('title', 'Kelola Data Pasien')
@section('page-title', 'Daftar Pasien Terdaftar')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Data Pasien</h2>
        <p class="text-gray-600 text-base md:text-lg">Lihat, edit, atau hapus informasi serta riwayat medis pasien.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Pasien</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">Nama Pasien</th>
                        <th scope="col" class="text-nowrap">Tanggal Lahir</th>
                        <th scope="col" class="text-nowrap">No. Telepon</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">Citra Kirana</td>
                        <td class="text-nowrap">1990-03-20</td>
                        <td class="text-nowrap">0811-2233-4455</td>
                        <td>Jl. Mawar No. 10, Jakarta</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary" title="Lihat Riwayat Medis">
                                    <i class="fa-solid fa-notes-medical"></i> <span class="d-none d-md-inline">Riwayat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus Pasien">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Rizky Febrian</td>
                        <td class="text-nowrap">1985-11-01</td>
                        <td class="text-nowrap">0817-6655-4433</td>
                        <td>Jl. Melati No. 5, Bandung</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary" title="Lihat Riwayat Medis">
                                    <i class="fa-solid fa-notes-medical"></i> <span class="d-none d-md-inline">Riwayat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus Pasien">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Dewi Chandra</td>
                        <td class="text-nowrap">1995-07-25</td>
                        <td class="text-nowrap">0819-8765-4321</td>
                        <td>Perumahan Indah Blok C No. 2, Surabaya</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary" title="Lihat Riwayat Medis">
                                    <i class="fa-solid fa-notes-medical"></i> <span class="d-none d-md-inline">Riwayat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus Pasien">
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
