@extends('layouts.template-pegawai')

@section('title', 'Kelola Data Dokter')
@section('page-title', 'Daftar Dokter')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Data Dokter</h2>
        <p class="text-gray-600 text-base md:text-lg">Lihat, edit, atau hapus data dokter yang tersedia di rumah sakit.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Dokter Aktif</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="text-nowrap">Nama Dokter</th>
                        <th scope="col">Spesialisasi</th>
                        <th scope="col" class="text-nowrap">No. Telepon</th>
                        <th scope="col">Email</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">Dr. Cahya Wijaya</td>
                        <td>Umum</td>
                        <td class="text-nowrap">0812-3456-7890</td>
                        <td>cahya.wijaya@example.com</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Dr. Angga Pratama</td>
                        <td>Spesialis Anak</td>
                        <td class="text-nowrap">0813-9876-5432</td>
                        <td>angga.pratama@example.com</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa-solid fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Dr. Fitriani Dewi</td>
                        <td>Spesialis Gigi</td>
                        <td class="text-nowrap">0815-1122-3344</td>
                        <td>fitriani.dewi@example.com</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
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
