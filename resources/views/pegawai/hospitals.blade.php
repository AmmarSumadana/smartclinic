@extends('layouts.template-pegawai')

@section('title', 'Kelola Data Rumah Sakit')
@section('page-title', 'Daftar Rumah Sakit')

@section('content')
<div class="p-6 md:p-8 lg:p-10">
    <div class="text-center mb-6 animate__animated animate__fadeInDown">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Manajemen Data Rumah Sakit</h2>
        <p class="text-gray-600 text-base md:text-lg">Lihat dan kelola informasi detail rumah sakit.</p>
    </div>

    <div class="neumo-card-small p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Daftar Rumah Sakit</h3>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nama Rumah Sakit</th>
                        <th scope="col">Alamat</th>
                        <th scope="col" class="text-nowrap">No. Telepon</th>
                        <th scope="col">Email</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap">RSUD dr. Soetomo</td>
                        <td>Jl. Mayjen Prof. Dr. Moestopo No.6-8, Surabaya</td>
                        <td class="text-nowrap">(031) 5501078</td>
                        <td>info@rss.or.id</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">RS Mitra Keluarga</td>
                        <td>Jl. Satrio No.12, Jakarta</td>
                        <td class="text-nowrap">(021) 57891234</td>
                        <td>contact@mitrakeluarga.com</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">RS Pondok Indah</td>
                        <td>Jl. Metro Duta I Kav. UE, Pondok Indah, Jakarta</td>
                        <td class="text-nowrap">(021) 7692252</td>
                        <td>info@rspondokindah.co.id</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i> <span class="d-none d-md-inline">Lihat</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="fa-solid fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
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
