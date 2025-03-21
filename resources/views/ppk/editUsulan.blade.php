@extends('layouts.main')
@section('content')
    <div class="card shadow-lg border-0">
        <div class="border border-2 border-dark">
            <h5 class="card-title text-center text-uppercase fw-bold text-dark">
                Proses Peningkatan Kinerja
            </h5>
            <div class="mb-2 border border-1 border-dark"></div>
            <!-- Informasi Utama -->
            <div class="px-5 py-3 pb-5">
                <div class="row mb-4">
                    <div class="row mb-4">
                        <div class="col"><strong>KEPADA</strong></div>
                        <h6 class="col fw-md text-secondary">
                            PPK NO. {{ $datalengkap['nomor_surat'] }}
                        </h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col"><strong>Penerima</strong></div>
                                <div class="col">: {{ $ppklengkap->penerimaUser->nama_user }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><strong>Departemen Penerima</strong></div>
                                <div class="col">: {{ $datalengkap['divisipenerima'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col"><strong>Pembuat /
                                        Inisiator</strong>
                                </div>
                                <div class="col">: {{ $ppklengkap->pembuatUser->nama_user }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"> <strong>Departemen Pembuat</strong></div>
                                <div class="col">: {{ $datalengkap['divisipembuat'] }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><strong>Tanggal Terbit</strong>
                                </div>
                                <div class="col">: {{ $ppklengkap->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ketidaksesuaian -->
                <h6 class="fw-bold">1. Jelaskan ketidaksesuaian yang terjadi atau
                    peningkatan yang akan dibuat
                </h6>
                <p>Jenis:</p>
                <div class="d-flex flex-wrap justify-content-evenly align-items-center">
                    <span class="fw-bold">
                        ( {{ str_contains($datalengkap['jenisketidaksesuaian'], 'SISTEM') ? '✔' : ' ' }} ) SISTEM
                    </span>
                    <span class="fw-bold">
                        ( {{ str_contains($datalengkap['jenisketidaksesuaian'], 'PROSES') ? '✔' : ' ' }} ) PROSES
                    </span>
                    <span class="fw-bold">
                        ( {{ str_contains($datalengkap['jenisketidaksesuaian'], 'PRODUK') ? '✔' : ' ' }} ) PRODUK
                    </span>
                    <span class="fw-bold">
                        ( {{ str_contains($datalengkap['jenisketidaksesuaian'], 'AUDIT') ? '✔' : ' ' }} ) AUDIT
                    </span>
                </div>
                <p class="my-3 me-3" style="text-align: justify;">{{ $datalengkap['judul'] }}</p>
                <div class="row">
                    <div class="col-md-7">
                        <h6 class="fw-bold">Evidence:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if (!empty($datalengkap['evidence']))
                                @foreach ($datalengkap['evidence'] as $file)
                                    <?php
                                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                    $filePath = asset('storage/' . $file);
                                    ?>
                                    <div class="border p-2 rounded bg-light">
                                        @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                            <img src="{{ asset('storage/' . $file) }}" alt="Evidence"
                                                class="img-fluid rounded" style="max-width: 150px; max-height: 150px;">
                                        @else
                                            <style>
                                                .hover {
                                                    color: #151515
                                                }

                                                .hover:hover {
                                                    text-decoration: underline;
                                                    color: #0d6efd !important;
                                                    /* Warna biru Bootstrap */
                                                }
                                            </style>
                                            <a href="{{ $filePath }}" target="_blank" class=" hover"
                                                title="Download Evidence"
                                                style="display: inline-block; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">{{ basename($file) }}</a>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted"><i class="bi bi-x-circle"></i> Tidak ada evidence</p>
                            @endif
                        </div>
                    </div>
                    <div class="col mt-4">
                        <!-- Signature -->
                        <div class="row">
                            <div class="col-md-7 mt-7 ">
                                <p class="mb-1"> Tanda Tangan<br />Inisiator/Auditor
                                </p>
                                <strong> {{ $ppklengkap->pembuatUser->nama_user }} </strong>
                            </div>
                            <div class="col">
                                <img src="{{ $datalengkap['signature'] }}" style="max-width: 130px; max-height:70px; ">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-7 mt-7 ">
                                <p class="mb-1"> Tanda Tangan<br />Proses Owner/Auditee
                                </p>
                                <strong> {{ $ppklengkap->penerimaUser->nama_user }} </strong>
                            </div>
                            <div class="col">
                                <img src="{{ $datalengkap['signaturePathPenerima'] }}"
                                    style="max-width: 130px; max-height:70px; ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border border-2 border-top-0 border-dark">
            <div class="mb-3 p-3 px-5">
                <label for="identifikasi" class="form-label fw-bold">
                    2. Identifikasi, evaluasi & pastikan akar penyebab masalah/Root Cause
                </label>
                <br><br>
                @if ($ppk->identifikasi)
                    <p style="text-align: justify;" class="me-3">
                        {{ old('identifikasi', $ppk->identifikasi) }}
                    </p>
                @else
                    <p>Data tidak tersedia</p>
                @endif
                <span style="font-size: 0.750em;">
                    *Gunakan metode 5WHYS untuk menentukan Root Cause; Fish Bone; Diagram alir; Penilaian situasi; Kendali
                    proses dan peningkatan.
                </span>
            </div>
        </div>
    </div>
    <div class="card shadow-lg border-0">
        <div class="border border-2 border-dark">
            <h5 class="card-title text-center text-uppercase fw-bold text-dark">Proses Peningkatan Kinerja</h5>
            <div class="border border-1 border-dark"></div>
            <div class="p-3 px-5">
                <!-- Edit Form -->
                <form method="POST" action="{{ route('ppk.update2', $ppk->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Method spoofing for update -->
                    <span style="font-size: 2rm;"><strong>3. Usulan tindakan: Jelaskan apa, siapa dan kapan akan
                            dilaksanakan
                            dan siapa yang akan melakukan tindakan Penanggulangan/Pencegahan tersebut dan kapan akan
                            diselesaikan.</strong></span>
                    <table class="mt-3" style="width: 100%; border: 2px solid black;">
                        <thead>
                            <tr>
                                <th style="border: 2px solid black;" class="text-center"></th>
                                <th style="border: 2px solid black; width: 50%;" class="text-center">Tindakan</th>
                                <th style="border: 2px solid black; " class="text-center">Target Tgl</th>
                                <th style="border: 2px solid black; width: 30%;" class="text-center">PIC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border: 2px solid black; vertical-align: top; vertical-align: top;"
                                    class="p-3">
                                    Penanggulangan
                                </td>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                    <textarea id="penanggulangan" name="penanggulangan" class="form-control">
                        {{ old('penanggulangan', $ppk->penanggulangan) }}
                        </textarea>
                                </td>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                    <input type="date" name="tgl_penanggulangan" class="form-control"
                                        value="{{ old('tgl_penanggulangan', $ppk->tgl_penanggulangan) }}">
                                </td>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                    <div class="mb-3" id="pic1-dropdown">
                                        <!-- Checkbox untuk memilih antara PIC 1 atau PIC Other -->
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="use-pic1"
                                                name="use_pic1" value="1"
                                                {{ old('use_pic1', $ppk->use_pic1) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="use-pic1">Opsi</label>
                                        </div>
                                        <!-- Dropdown PIC 1 -->
                                        <div id="pic1-container" class="pic1-dropdown">
                                            @php
                                                $oldPic1 = old('pic1', explode(',', $ppk->pic1));
                                            @endphp
                                            @foreach ($oldPic1 as $selectedPic1)
                                                <div class="input-group mb-2">
                                                    <select name="pic1[]" class="form-select">
                                                        <option value="">Pilih PIC</option>
                                                        @foreach ($data as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ $selectedPic1 == $user->id ? 'selected' : '' }}>
                                                                {{ $user->nama_user }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-pic">-</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Textarea PIC Other -->
                                        <div id="pic1-other" class="pic1-other" style="display: none;">
                                            <textarea name="pic1_other" id="pic1_other" class="form-control">
                              {{ old('pic1_other', $ppk->pic1_other) }}
                              </textarea>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <button type="button" class="btn btn-outline-primary add-pic"
                                            data-target="pic1-container">
                                            <i class="fa fa-plus"></i> Tambah PIC
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">Pencegahan</td>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                    <textarea id="pencegahan" name="pencegahan" class="form-control" placeholder="" cols="30">
                        {{ old('pencegahan') ?? $ppk->pencegahan }}
                        </textarea>
                                </td>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                    <input type="date" name="tgl_pencegahan" class="form-control"
                                        value="{{ old('tgl_pencegahan', $ppk->tgl_pencegahan) }}">
                                </td>
                                <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                    <div class="mb-3" id="pic2-dropdown">
                                        <!-- Checkbox untuk memilih antara PIC 2 atau PIC Other -->
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="use-pic2"
                                                name="use_pic2" value="1"
                                                {{ old('use_pic2', $ppk->use_pic2) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="use-pic2">Pilih PIC 2</label>
                                        </div>
                                        <!-- Dropdown PIC 2 -->
                                        <div id="pic2-container" class="pic2-dropdown">
                                            @php
                                                $oldPic2 = old('pic2', explode(',', $ppk->pic2));
                                            @endphp
                                            @foreach ($oldPic2 as $selectedPic2)
                                                <div class="input-group mb-2">
                                                    <select name="pic2[]" class="form-select">
                                                        <option value="">Pilih PIC</option>
                                                        @foreach ($data as $user)
                                                            <option value="{{ $user->id }}"
                                                                {{ $selectedPic2 == $user->id ? 'selected' : '' }}>
                                                                {{ $user->nama_user }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-pic">-</button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Textarea PIC Other -->
                                        <div id="pic2-other" class="pic2-other" style="display: none;">
                                            <textarea name="pic2_other" id="pic2_other" class="form-control">
                                                {{ old('pic2_other', $ppk->pic2_other) }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        <button type="button" class="btn btn-outline-primary add-pic"
                                            data-target="pic2-container">
                                            <i class="fa fa-plus"></i> Tambah PIC
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mb-3 d-none">
                        <label for="identifikasi" class="form-label fw-bold">
                            2. Identifikasi, evaluasi & pastikan akar penyebab masalah/Root Cause
                        </label>
                        <br>
                        <br>
                        <textarea placeholder="Masukan identifikasi" name="identifikasi" class="form-control" id="identifikasi"
                            rows="7">
                            {{ old('identifikasi', $ppk->identifikasi) }}
                        </textarea>
                        <span style="font-size: 0.750em;">*Gunakan metode 5WHYS untuk menentukan Root Cause; Fish Bone;
                            Diagram alir; Penilaian situasi; Kendali proses dan peningkatan.</span>
                    </div>
                    {{-- auto resizing text area --}}
                    <script>
                        // Mendapatkan kedua elemen textarea
                        const textarea1 = document.getElementById('pencegahan');
                        const textarea2 = document.getElementById('penanggulangan');

                        // Fungsi untuk mengubah tinggi textarea sesuai dengan isi
                        function autoResizeTextarea(textarea) {
                            textarea.style.height = 'auto'; // Reset tinggi terlebih dahulu
                            textarea.style.height = (textarea.scrollHeight) + 'px'; // Set tinggi sesuai dengan scrollHeight
                        }

                        // Menambahkan event listener untuk input pada kedua textarea
                        textarea1.addEventListener('input', function() {
                            autoResizeTextarea(textarea1);
                        });

                        textarea2.addEventListener('input', function() {
                            autoResizeTextarea(textarea2);
                        });

                        // Panggil fungsi untuk mengatur tinggi saat halaman pertama kali dimuat
                        autoResizeTextarea(textarea1);
                        autoResizeTextarea(textarea2);
                    </script>
                    <script>
                        // Menambahkan event listener untuk checkbox
                        document.getElementById('use-pic1').addEventListener('change', function() {
                            var pic1Container = document.getElementById('pic1-container');
                            var pic1Other = document.getElementById('pic1-other');

                            if (this.checked) {
                                pic1Container.style.display = 'block';
                                pic1Other.style.display = 'none';
                            } else {
                                pic1Container.style.display = 'none';
                                pic1Other.style.display = 'block';
                            }
                        });
                    </script>
                    <script>
                        // Menambahkan event listener untuk checkbox PIC 2
                        document.getElementById('use-pic2').addEventListener('change', function() {
                            var pic2Container = document.getElementById('pic2-container');
                            var pic2Other = document.getElementById('pic2-other');

                            if (this.checked) {
                                pic2Container.style.display = 'block';
                                pic2Other.style.display = 'none';
                            } else {
                                pic2Container.style.display = 'none';
                                pic2Other.style.display = 'block';
                            }
                        });
                    </script>
                    <script>
                        // Tambah dropdown PIC 1
                        document.querySelector('.add-pic[data-target="pic1-container"]').addEventListener('click', function() {
                            const container = document.getElementById('pic1-container');
                            const newPic = document.createElement('div');
                            newPic.classList.add('input-group', 'mb-2');
                            newPic.innerHTML = `
               <select name="pic1[]" class="form-select">
               <option value="">Pilih PIC</option>
               @foreach ($data as $user)
               <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
               @endforeach
               </select>
               <button type="button" class="btn btn-outline-danger remove-pic">-</button>
               `;
                            container.appendChild(newPic);
                        });

                        // Hapus dropdown PIC 1
                        document.getElementById('pic1-container').addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('remove-pic')) {
                                e.target.closest('.input-group').remove();
                            }
                        });
                        // Tambah dropdown PIC 2
                        document.querySelector('.add-pic[data-target="pic2-container"]').addEventListener('click', function() {
                            const container = document.getElementById('pic2-container');
                            const newPic = document.createElement('div');
                            newPic.classList.add('input-group', 'mb-2');
                            newPic.innerHTML = `
               <select name="pic2[]" class="form-select">
               <option value="">Pilih PIC</option>
               @foreach ($data as $user)
               <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
               @endforeach
               </select>
               <button type="button" class="btn btn-outline-danger remove-pic">-</button>
               `;
                            container.appendChild(newPic);
                        });

                        // Hapus dropdown PIC 2
                        document.getElementById('pic2-container').addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('remove-pic')) {
                                e.target.closest('.input-group').remove();
                            }
                        });
                    </script>
                    <div class="row mt-3">
                        <div class="col-md-7 text-center">
                            <p>Tanggal : <span class="ps-5" style="border-bottom: 1px solid #000">
                                    {{ \Carbon\Carbon::parse($ppk->updated_at)->translatedFormat('d F Y') }}
                                </span>
                            </p>
                        </div>
                        <div class="col text-start d-flex">
                            <p>Tanda Tangan :<br /><strong>{{ $ppklengkap->penerimaUser->nama_user }}</strong></p>
                            <img src="{{ $datalengkap['signaturePathPenerima'] }}" alt="Signature" height="70">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('ppk.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update <i class="ri-save-3-fill"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
