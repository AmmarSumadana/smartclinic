@extends('layouts.app')

@section('title', 'Tes Laboratorium')
@section('page-title', 'Tes Laboratorium')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
         <h3 class="text-2xl font-semibold text-center">Tes Laboratorium Mandiri</h3>
        <p class="text-center text-gray-600 mb-6">Berikut adalah beberapa tes laboratorium yang dapat dilakukan di rumah:</p>

        <!-- Alert untuk notifikasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div id="tesLabCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Gula Darah</h4>
                        <p class="text-gray-700">Tes ini digunakan untuk memantau kadar glukosa dalam darah, terutama bagi penderita diabetes. Memastikan kadar gula darah tetap dalam batas normal sangat penting untuk kesehatan.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Puasa selama 8 jam sebelum tes.</li>
                            <li>Hindari makanan manis sebelum tes.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/u8nsKsglt-0" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Kolesterol</h4>
                        <p class="text-gray-700">Tes kolesterol mengukur kadar kolesterol total, LDL, dan HDL dalam darah. Menjaga kadar kolesterol dalam batas normal dapat mencegah penyakit jantung.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Puasa selama 9-12 jam sebelum tes.</li>
                            <li>Hindari makanan berlemak sehari sebelum tes.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/wlXvR-X42uk" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Hemoglobin</h4>
                        <p class="text-gray-700">Tes hemoglobin mengukur kadar hemoglobin dalam darah untuk memantau anemia. Kadar hemoglobin yang sehat penting untuk kesehatan secara keseluruhan.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Hindari makanan yang kaya zat besi sebelum tes.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/fb_VpRnYDHU" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Urin</h4>
                        <p class="text-gray-700">Tes urin digunakan untuk menilai kesehatan ginjal dan mendeteksi diabetes. Hasil tes urin dapat memberikan informasi penting tentang kesehatan Anda.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Minum cukup air sebelum tes untuk mendapatkan sampel urin yang baik.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/GpTfFalsOE0" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Kehamilan</h4>
                        <p class="text-gray-700">Tes kehamilan mendeteksi hormon hCG dalam urine untuk mengetahui apakah seseorang hamil. Tes ini sangat penting untuk perencanaan keluarga.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Gunakan tes di pagi hari untuk hasil yang lebih akurat.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/QEPPxenSO78" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes COVID-19 (Rapid Test)</h4>
                        <p class="text-gray-700">Tes COVID-19 dilakukan di rumah dengan mengambil sampel dari hidung atau tenggorokan. Tes ini penting untuk mendeteksi infeksi COVID-19.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Ikuti instruksi pada kit tes dengan seksama.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/B15r9YSy5w4" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Alergi</h4>
                        <p class="text-gray-700">Tes alergi menguji reaksi terhadap alergen tertentu dengan menggunakan sampel darah atau tes kulit. Ini membantu dalam diagnosis alergi.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Beritahu dokter tentang riwayat alergi Anda.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/bRw5jxhyXyo" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Kadar Vitamin D</h4>
                        <p class="text-gray-700">Tes kadar vitamin D mengukur kadar vitamin D dalam darah untuk memastikan kesehatan tulang dan sistem kekebalan tubuh.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Hindari suplemen vitamin D sebelum tes.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/xGUqMiASlR8" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="bg-gray-100 p-4 rounded-lg shadow" style="min-height: 500px;">
                        <h4 class="font-semibold text-lg text-blue-600">Tes Kesehatan Umum</h4>
                        <p class="text-gray-700">Kit tes kesehatan umum yang mencakup berbagai parameter kesehatan untuk memberikan gambaran menyeluruh tentang kesehatan Anda.</p>
                        <h5 class="font-semibold mt-2">Panduan Persiapan:</h5>
                        <ul class="list-disc list-inside">
                            <li>Ikuti instruksi pada kit tes dengan seksama.</li>
                        </ul>
                        <div class="mt-2">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/Xbm1_DazmcE" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#tesLabCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#tesLabCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Selanjutnya</span>
            </button>
        </div>

        <!-- Tombol untuk mengisi hasil tes -->
        <h3 class="text-2xl font-semibold mt-6">Isi Hasil Tes</h3>
        <button class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#resultModal">Isi Hasil Tes</button>

        <!-- Modal untuk mengisi hasil tes -->
        <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">Isi Hasil Tes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="resultForm" action="{{ route('lab-tests.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="testType" class="form-label">Jenis Tes</label>
                                <select class="form-select" id="testType" name="test_type" required>
                                    <option value="" disabled selected>Pilih Jenis Tes</option>
                                    <option value="Gula Darah">Gula Darah</option>
                                    <option value="Kolesterol">Kolesterol</option>
                                    <option value="Hemoglobin">Hemoglobin</option>
                                    <option value="Kehamilan">Kehamilan</option>
                                    <option value="Ovulasi">Ovulasi</option>
                                    <option value="Urin">Urin</option>
                                    <option value="COVID-19">COVID-19</option>
                                    <option value="Alergi">Alergi</option>
                                    <option value="Vitamin D">Vitamin D</option>
                                    <option value="Kesehatan Umum">Kesehatan Umum</option>
                                </select>
                                @error('test_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="testDate" class="form-label">Tanggal Tes</label>
                                <input type="date" class="form-control" id="testDate" name="test_date" required>
                                @error('test_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="result" class="form-label">Hasil</label>
                                <input type="text" class="form-control" id="result" name="result" required>
                                @error('result')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger">Simpan Hasil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk edit hasil tes -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Hasil Tes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="editId" name="id">
                            <div class="mb-3">
                                <label for="editTestType" class="form-label">Jenis Tes</label>
                                <select class="form-select" id="editTestType" name="test_type" required>
                                    <option value="" disabled>Pilih Jenis Tes</option>
                                    <option value="Gula Darah">Gula Darah</option>
                                    <option value="Kolesterol">Kolesterol</option
                                                                            <option value="Hemoglobin">Hemoglobin</option>
                                    <option value="Kehamilan">Kehamilan</option>
                                    <option value="Ovulasi">Ovulasi</option>
                                    <option value="Urin">Urin</option>
                                    <option value="COVID-19">COVID-19</option>
                                    <option value="Alergi">Alergi</option>
                                    <option value="Vitamin D">Vitamin D</option>
                                    <option value="Kesehatan Umum">Kesehatan Umum</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editTestDate" class="form-label">Tanggal Tes</label>
                                <input type="date" class="form-control" id="editTestDate" name="test_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="editResult" class="form-label">Hasil</label>
                                <input type="text" class="form-control" id="editResult" name="result" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Hasil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-2xl font-semibold mt-6">Hasil Tes</h3>
        <table class="table table-bordered w-100 mt-4">
            <thead>
                <tr>
                    <th class="border border-gray-300 p-2">Jenis Tes</th>
                    <th class="border border-gray-300 p-2">Tanggal Tes</th>
                    <th class="border border-gray-300 p-2">Hasil</th>
                    <th class="border border-gray-300 p-2">Status</th>
                    <th class="border border-gray-300 p-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="resultBody">
                @forelse($labTests as $test)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $test->test_type }}</td>
                        <td class="border border-gray-300 p-2">{{ $test->test_date }}</td>
                        <td class="border border-gray-300 p-2">{{ $test->result }}</td>
                        <td class="border border-gray-300 p-2">
                            @php
                                $status = '';
                                if ($test->test_type === 'Gula Darah') {
                                    $status = ($test->result >= 70 && $test->result <= 99) ? 'Normal' : 'Tidak Normal';
                                } elseif ($test->test_type === 'Kolesterol') {
                                    $status = ($test->result < 200) ? 'Normal' : 'Tidak Normal';
                                } elseif ($test->test_type === 'Hemoglobin') {
                                    $status = ($test->result >= 12.0 && $test->result <= 17.0) ? 'Normal' : 'Tidak Normal';
                                } elseif ($test->test_type === 'Kehamilan') {
                                    $status = ($test->result === 'Positif') ? 'Positif' : 'Negatif';
                                } elseif ($test->test_type === 'COVID-19') {
                                    $status = ($test->result === 'Positif') ? 'Positif' : 'Negatif';
                                } elseif ($test->test_type === 'Alergi') {
                                    $status = ($test->result === 'Reaktif') ? 'Reaktif' : 'Tidak Reaktif';
                                } elseif ($test->test_type === 'Vitamin D') {
                                    $status = ($test->result >= 30 && $test->result <= 100) ? 'Normal' : 'Tidak Normal';
                                } elseif ($test->test_type === 'Urin') {
                                    $status = ($test->result === 'Normal') ? 'Normal' : 'Tidak Normal';
                                } elseif ($test->test_type === 'Ovulasi') {
                                    $status = ($test->result === 'Positif') ? 'Positif' : 'Negatif';
                                } elseif ($test->test_type === 'Kesehatan Umum') {
                                    $status = ($test->result === 'Normal') ? 'Normal' : 'Tidak Normal';
                                } else {
                                    $status = 'Status tidak ditentukan';
                                }
                            @endphp
                            <span class="badge {{ $status === 'Normal' || $status === 'Positif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="border border-gray-300 p-2">
                            <button class="btn btn-sm btn-warning" onclick="editTest({{ $test->id }}, '{{ $test->test_type }}', '{{ $test->test_date }}', '{{ $test->result }}')">
                                Edit
                            </button>
                            <form action="{{ route('lab-tests.destroy', $test->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">Belum ada data tes laboratorium</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($labTests->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $labTests->links() }}
            </div>
        @endif
    </div>

    <script>
        // Function untuk edit test
        function editTest(id, testType, testDate, result) {
            document.getElementById('editId').value = id;
            document.getElementById('editTestType').value = testType;
            document.getElementById('editTestDate').value = testDate;
            document.getElementById('editResult').value = result;
            document.getElementById('editForm').action = `/lab-tests/${id}`;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        // Set default date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('testDate').value = today;
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endsection
