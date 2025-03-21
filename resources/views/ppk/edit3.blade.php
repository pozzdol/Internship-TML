@extends('layouts.main')

@section('content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

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
                            PPK NO. {{ $data['nomor_surat'] }}
                        </h6>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col"><strong>Penerima</strong></div>
                                <div class="col">: {{ $ppksatu->penerimaUser->nama_user }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><strong>Departemen Penerima</strong></div>
                                <div class="col">: {{ $data['divisipenerima'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col"><strong>Pembuat /
                                        Inisiator</strong>
                                </div>
                                <div class="col">: {{ $ppksatu->pembuatUser->nama_user }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"> <strong>Departemen Pembuat</strong></div>
                                <div class="col">: {{ $data['divisipembuat'] }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><strong>Tanggal Terbit</strong>
                                </div>
                                <div class="col">: {{ $ppksatu->created_at->format('d/m/Y') }}</div>
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
                        ( {{ str_contains($data['jenisketidaksesuaian'], 'SISTEM') ? '✔' : ' ' }} ) SISTEM
                    </span>
                    <span class="fw-bold">
                        ( {{ str_contains($data['jenisketidaksesuaian'], 'PROSES') ? '✔' : ' ' }} ) PROSES
                    </span>
                    <span class="fw-bold">
                        ( {{ str_contains($data['jenisketidaksesuaian'], 'PRODUK') ? '✔' : ' ' }} ) PRODUK
                    </span>
                    <span class="fw-bold">
                        ( {{ str_contains($data['jenisketidaksesuaian'], 'AUDIT') ? '✔' : ' ' }} ) AUDIT
                    </span>
                </div>
                <p class="my-3 me-3" style="text-align: justify;">{{ $data['judul'] }}</p>
                <div class="row">
                    <div class="col-md-7">
                        <h6 class="fw-bold">Evidence:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @if (!empty($data['evidence']) && is_array($data['evidence']))
                                @foreach ($data['evidence'] as $file)
                                    @php
                                        // Mengganti backslash dengan slash untuk path yang benar
                                        $file = str_replace('\\', '/', $file);
                                        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                        $filePath = asset('storage/' . $file);
                                    @endphp
                                    <div class="border p-2 rounded bg-light">
                                        @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                            <img src="{{ $filePath }}" alt="Evidence" class="img-fluid rounded"
                                                style="max-width: 150px; max-height: 150px;">
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
                                <strong> {{ $ppksatu->pembuatUser->nama_user }} </strong>
                            </div>
                            <div class="col">
                                <img src="{{ $data['signature'] }}" style="max-width: 130px; max-height:70px; ">
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-7 mt-7 ">
                                <p class="mb-1"> Tanda Tangan<br />Proses Owner/Auditee
                                </p>
                                <strong> {{ $ppksatu->penerimaUser->nama_user }} </strong>
                            </div>
                            <div class="col">
                                <img src="{{ $data['signaturepenerima'] }}" style="max-width: 130px; max-height:70px; ">
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
                @if ($ppkdua->identifikasi)
                    <p style="text-align: justify;" class="me-3">
                        {{ old('identifikasi', $ppkdua->identifikasi) }}
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
            <h5 class="card-title text-center text-uppercase fw-bold text-dark">
                Proses Peningkatan Kinerja
            </h5>
            <div class="mb-2 border border-1 border-dark"></div>
            <div class="px-5 py-3 pb-5">

                <span style="font-size: 2rm;"><strong>3. Usulan tindakan: Jelaskan apa, siapa dan kapan akan
                        dilaksanakan
                        dan siapa yang akan melakukan tindakan Penanggulangan/Pencegahan tersebut dan kapan akan
                        diselesaikan.</strong></span>
                <table class="mt-3" style="width: 100%; border: 2px solid black;">
                    <thead>
                        <tr>
                            <th style="border: 2px solid black;" class="text-center"></th>
                            <th style="border: 2px solid black;" class="text-center">Tindakan</th>
                            <th style="border: 2px solid black; width: 15%;" class="text-center">Target Tgl</th>
                            <th style="border: 2px solid black; width: 20%;" class="text-center">PIC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 2px solid black; vertical-align: top; vertical-align: top;" class="p-3">
                                Penanggulangan
                            </td>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                {{ old('penanggulangan', $ppkdua->penanggulangan) }}
                            </td>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3 text-center">
                                {{ old('tgl_penanggulangan', $ppkdua->tgl_penanggulangan) }}
                            </td>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                @if ($ppkdua->pic1)
                                    @php
                                        // Mengubah string ID yang dipisah koma menjadi array
                                        $pic1Ids = explode(',', $ppkdua->pic1);
                                    @endphp
                                    @foreach ($pic1Ids as $pic1Id)
                                        @php
                                            // Mengambil pengguna berdasarkan ID
                                            $user = \App\Models\User::find($pic1Id);
                                        @endphp
                                        @if ($user)
                                            - {{ $user->nama_user }}<br>
                                        @else
                                            <span>Pengguna dengan ID {{ $pic1Id }} tidak ditemukan</span><br>
                                        @endif
                                    @endforeach
                                @elseif ($ppkdua->pic1_other)
                                    ({{ $ppkdua->pic1_other }})
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3">Pencegahan</td>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                {{ old('penanggulangan', $ppkdua->pencegahan) }}
                            </td>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3 text-center">
                                {{ old('tgl_pencegahan', $ppkdua->tgl_pencegahan) }}
                            </td>
                            <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                                @if ($ppkdua->pic2)
                                    @php
                                        // Mengubah string ID yang dipisah koma menjadi array
                                        $pic2Ids = explode(',', $ppkdua->pic2);
                                    @endphp
                                    @foreach ($pic2Ids as $pic2Id)
                                        @php
                                            // Mengambil pengguna berdasarkan ID
                                            $user = \App\Models\User::find($pic2Id);
                                        @endphp
                                        @if ($user)
                                            - {{ $user->nama_user }}<br>
                                        @else
                                            <span>Pengguna dengan ID {{ $pic2Id }} tidak ditemukan</span><br>
                                        @endif
                                    @endforeach
                                @elseif ($ppkdua->pic2_other)
                                    {{ $ppkdua->pic2_other }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="row mt-3">
                    <div class="col-md-7 text-center">
                        <p>Tanggal : <span class="ps-5" style="border-bottom: 1px solid #000">
                                {{ \Carbon\Carbon::parse($ppkdua->updated_at)->translatedFormat('d F Y') }}
                            </span>
                        </p>
                    </div>
                    <div class="col text-start d-flex">
                        <p>Tanda Tangan :<br /><strong>{{ $ppksatu->penerimaUser->nama_user }}</strong></p>
                        <img src="{{ $data['signaturepenerima'] }}" alt="Signature" height="70">
                    </div>
                </div>
            </div>

            <div class="mb-2 border border-1 border-dark"></div>

            <div class="px-5 py-3 pb-5">
                <form method="POST" action="{{ route('ppk.update3', $ppk->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_formppk" value="{{ $ppk->id_formppk }}">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Verifikasi -->
                    <p class="my-4" style="font-size: 2rm;"><strong>4. Verifikasi Tindakan</strong></p>

                    <div class="row mb-3">
                        <label for="verifikasi" class="col-sm-2 col-form-label"><strong>Catatan</strong></label>
                        <div class="col-sm-10">
                            <textarea name="verifikasi" class="form-control" placeholder="Masukkan Catatan" rows="7">{{ old('verifikasi', $ppk->verifikasi ?? '') }}</textarea>
                        </div>
                    </div>
                    <small class="form-text text-muted font-italic">Efektifitas Tindakan Penanggulangan/Pencegahan dapat
                        diverifikasi 1
                        (satu) bulan dari tanggal
                        verifikasi oleh Auditor</small>
            </div>

            <div class="mb-2 border border-1 border-dark"></div>

            <div class="px-5 py-3 pb-5">

                <p style="font-size: 2rm;"><strong>5. a) Tinjauan Status penyelesaian Tindakan Penanggulangan</strong>
                </p>
                <p style="font-size: 2rm; padding-left: 20px;">
                    <strong>b) Tinjauan efektivitas atas hasil Tindakan Pencegahan</strong>
                </p>

                <div class="row mb-3">
                    <label for="tinjauan" class="col-sm-2 col-form-label"><strong>Catatan</strong></label>
                    <div class="col-sm-10">
                        <textarea name="tinjauan" class="form-control" placeholder="Masukkan Tinjauan" rows="7">{{ old('tinjauan', $ppk->tinjauan ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="verifikasi_img" class="col-sm-2 col-form-label"><strong>Gambar
                            Verifikasi</strong></label>
                    <div class="col-sm-10">
                        @php
                            // Decode the JSON field to an array of file paths
                            $verifikasi_imgs = json_decode($ppk->verifikasi_img ?? '[]', true);
                        @endphp

                        @if (is_array($verifikasi_imgs) && count($verifikasi_imgs) > 0)
                            <div id="verifikasiPreviewContainer" class="d-flex flex-wrap mt-3">
                                @foreach ($verifikasi_imgs as $index => $verifikasi_img)
                                    @php
                                        $filePath = asset('storage/' . $verifikasi_img); // Generate the correct file path
                                        $fileExtension = pathinfo($verifikasi_img, PATHINFO_EXTENSION); // Get the file extension
                                    @endphp
                                    <div class="evidence-item text-center me-3 mb-2">
                                        @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']))
                                            <img src="{{ $filePath }}" alt="Verifikasi Image" class="img-thumbnail"
                                                style="max-width: 150px; height: auto;">
                                        @else
                                            <a href="{{ $filePath }}"
                                                target="_blank">{{ basename($verifikasi_img) }}</a>
                                        @endif
                                        <br>
                                        <a href="{{ $filePath }}" download="{{ basename($verifikasi_img) }}"
                                            title="Download Image" class="btn btn-sm btn-primary mt-2">
                                            <i class="bi bi-cloud-download"></i> Download
                                        </a>
                                        <br>
                                        <input type="checkbox" name="delete_verifikasi[]" value="{{ $verifikasi_img }}"
                                            id="delete_{{ $index }}">
                                        <label for="delete_{{ $index }}" class="text-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No uploaded images.</p>
                        @endif

                        <div class="mt-3">
                            <label for="verifikasi_img"><strong>Tambah Gambar (jika ada)</strong></label>
                            <input type="file" name="verifikasi_img[]" id="verifikasi_img" class="form-control"
                                multiple onchange="previewImages()" accept="image/*">
                        </div>

                        <div id="imagePreview" class="d-flex flex-wrap mt-3">
                            <!-- Preview images will appear here -->
                        </div>
                    </div>
                </div>

                <script>
                    function previewImages() {
                        const fileInput = document.getElementById('verifikasi_img');
                        const previewContainer = document.getElementById('imagePreview');

                        // Clear previous previews
                        previewContainer.innerHTML = '';

                        // Loop through the selected files
                        const files = fileInput.files;
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            const reader = new FileReader();

                            // Preview the image
                            reader.onload = function(e) {
                                const imgElement = document.createElement('img');
                                imgElement.src = e.target.result;
                                imgElement.classList.add('img-thumbnail');
                                imgElement.style.maxWidth = '150px';
                                imgElement.style.height = 'auto';
                                previewContainer.appendChild(imgElement);
                            };

                            // Read the file as a data URL
                            reader.readAsDataURL(file);
                        }
                    }
                </script>

                <!-- Status -->
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label"><strong>Status</strong></label>
                    <div class="col-sm-10">
                        <!-- Radio Button TRUE -->
                        <div class="form-check">
                            <input type="radio" name="status" id="status_true" value="TRUE"
                                class="form-check-input" {{ old('status', $ppk->status) == 'TRUE' ? 'checked' : '' }}
                                onclick="toggleNewPpk()">
                            <label for="status_true" class="form-check-label">
                                Efektif, dalam 1 bulan masalah yang sama tidak muncul lagi & tindakan penanggulangan
                                sudah
                                selesai
                            </label>
                        </div>

                        <br>

                        <!-- Radio Button FALSE -->
                        <div class="form-check">
                            <input type="radio" name="status" id="status_false" value="FALSE"
                                class="form-check-input" {{ old('status', $ppk->status) == 'FALSE' ? 'checked' : '' }}
                                onclick="toggleNewPpk()">
                            <label for="status_false" class="form-check-label">
                                Tidak efektif, dilanjutkan dengan PPK No.
                            </label>

                            <!-- Input New PPK -->
                            <div class="mt-2">
                                <input type="text" name="newppk" id="newppk" class="form-control"
                                    placeholder="Masukkan No PPK apabila tidak efektif"
                                    value="{{ old('newppk', $ppk->newppk ?? '') }}"
                                    style="{{ old('status', $ppk->status) == 'FALSE' ? 'display: block;' : 'display: none;' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function toggleNewPpk() {
                        // Ambil elemen radio buttons dan input
                        const radioFalse = document.getElementById('status_false');
                        const radioTrue = document.getElementById('status_true');
                        const input = document.getElementById('newppk');

                        // Tampilkan input hanya jika radio FALSE dipilih
                        if (radioFalse.checked) {
                            input.style.display = 'block';
                        } else if (radioTrue.checked) {
                            input.style.display = 'none';
                            input.value = ''; // Reset nilai input jika disembunyikan
                        }
                    }

                    // Pastikan input ditampilkan atau disembunyikan sesuai status saat halaman dimuat
                    window.onload = function() {
                        toggleNewPpk();
                    };
                </script>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('ppk.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update <i class="ri-save-3-fill"></i></button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
