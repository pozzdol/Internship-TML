@extends('layouts.main')

@section('content')
    <!-- Pastikan Bootstrap Icons sudah terpasang. Jika belum, tambahkan link berikut di head layout utama:
                                                                                                                                                         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                                                                                                                                                    -->

    <body>
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h5 class="card-title text-center text-uppercase fw-bold text-primary">Proses Peningkatan Kinerja</h5>
                <hr class="mb-4 border-primary">

                <form method="POST" action="{{ route('ppk.store') }}" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Judul PPK -->
                    <div class="mb-3">
                        <label for="inputJudul" class="form-label fw-bold">
                            1. <i class="bi bi-exclamation-circle"></i> Jelaskan ketidaksesuaian yang terjadi atau
                            peningkatan yang akan dibuat *
                        </label>
                        <div class="position-relative">
                            <textarea name="judul" id="inputJudul" class="form-control rounded-3 " rows="5"
                                placeholder="Tulis penjelasan Anda di sini..." onfocus="this.classList.add('border-primary')"
                                onblur="this.classList.remove('border-primary')">{{ old('judul') }}</textarea>

                            <script>
                                // Mendapatkan elemen textarea
                                const textarea = document.getElementById('inputJudul');

                                // Fungsi untuk mengubah tinggi textarea sesuai dengan isi
                                function autoResizeTextarea() {
                                    textarea.style.height = 'auto'; // Reset tinggi terlebih dahulu
                                    textarea.style.height = (textarea.scrollHeight) + 'px'; // Set tinggi sesuai dengan scrollHeight
                                }

                                // Menambahkan event listener untuk input
                                textarea.addEventListener('input', autoResizeTextarea);

                                // Panggil fungsi untuk mengatur tinggi saat halaman pertama kali dimuat
                                autoResizeTextarea();
                            </script>
                            <i class="bi bi-pencil-fill position-absolute text-secondary"
                                style="right: 10px; bottom: 10px;"></i>
                        </div>
                    </div>


                    <!-- Evidence -->
                    <div class="mb-3">
                        <label for="evidence" class="form-label fw-bold">
                            <i class="bi bi-upload"></i> Evidence*
                        </label>
                        <div>
                            <input type="file" id="evidence" name="evidence[]" class="form-control " multiple
                                accept="image/*,.xlsx,.xls,.doc,.docx,.pdf" onchange="previewImages(event)">
                            <!-- Preview container for uploaded files -->
                            <div id="evidencePreviewContainer" class="mt-3 d-flex flex-wrap gap-3"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-exclamation-triangle"></i> Jenis
                            Ketidaksesuaian*</label>
                        <div class="row">
                            @foreach (['SISTEM' => 'bi-cpu', 'PROSES' => 'bi-gear', 'PRODUK' => 'bi-box-seam', 'AUDIT' => 'bi-search'] as $type => $icon)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="jenisketidaksesuaian[]"
                                            value="{{ $type }}">
                                        <label class="form-check-label">
                                            <i class="bi {{ $icon }}"></i> {{ ucfirst(strtolower($type)) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <!-- Pembuat dan Divisi Pembuat -->
                    <div class="row g-3 my-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-person-badge"></i> Nama Inisiator*</label>
                            <select id="pembuat" name="pembuat" class="form-select">
                                @if (auth()->user()->role !== 'admin')
                                    <option value="">Pilih Pembuat</option>

                                    <option value="{{ auth()->user()->nama_user }}" data-email="{{ auth()->user()->email }}"
                                        data-divisi="{{ auth()->user()->divisi }}">
                                        {{ auth()->user()->nama_user }}
                                    </option>
                                @else
                                    <option value="">Pilih Pembuat</option>
                                    @foreach ($data as $user)
                                        <option value="{{ $user->nama_user }}" data-email="{{ $user->email }}"
                                            data-divisi="{{ $user->divisi }}">
                                            {{ $user->nama_user }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bi bi-building"></i> Divisi Inisiator*</label>
                            <input type="text" id="divisipembuat" name="divisipembuat" class="form-control" readonly>
                        </div>
                    </div>


                    <div class="row g-3 mb-3">
                        <!-- Email Inisiator -->
                        <div class="col-md-6">
                            <label for="emailpembuat" class="form-label fw-bold"><i class="bi bi-envelope"></i> Email
                                Inisiator*</label>
                            <input type="email" id="emailpembuat" name="emailpembuat" class="form-control"
                                placeholder="Email" value="{{ old('emailpembuat') }}" readonly>
                        </div>
                    </div>

                    <hr>
                    <!-- Penerima -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="penerima" class="form-label fw-bold"><i class="bi bi-person-badge"></i> Nama
                                Penerima*</label>
                            <select id="penerima" name="penerima" class="form-select">
                                <option value="">Pilih Penerima</option>
                                @foreach ($data as $user)
                                    <option value="{{ $user->id }}" data-email="{{ $user->email }}"
                                        data-divisi="{{ $user->divisi }}">
                                        {{ $user->nama_user }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="divisipenerima" class="form-label fw-bold"><i class="bi bi-building"></i> Divisi
                                Penerima*</label>
                            <input type="text" name="divisipenerima" id="divisipenerima" class="form-control"
                                placeholder="Divisi" value="{{ old('divisipenerima') }}" readonly>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <!-- Email Penerima -->
                        <div class="col-md-6">
                            <label for="emailpenerima" class="form-label fw-bold"><i class="bi bi-envelope"></i> Email
                                Penerima*</label>
                            <input type="email" id="emailpenerima" name="emailpenerima" class="form-control"
                                placeholder="Email" value="{{ old('emailpenerima') }}" readonly>
                        </div>
                    </div>
                    <br>

                    <!-- Tanda Tangan -->
                    <div class="row mb-3">
                        <label for="signature" class="col-sm-2 col-form-label fw-bold ">
                            <i class="bi bi-pencil-square"></i> Tanda Tangan* (Pilih Opsi)
                        </label>
                        <div class="col-sm-10">
                            <!-- Pilihan Opsi -->
                            <div class="row mb-3 mt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="signature_option"
                                        id="option1" value="1" checked>
                                    <label class="form-check-label fw-bold" for="option1">
                                        <i class="bi bi-hand-index-thumb "></i> Tanda tangan langsung
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="signature_option"
                                        id="option2" value="2">
                                    <label class="form-check-label fw-bold" for="option2">
                                        <i class="bi bi-upload "></i> Unggah file tanda tangan
                                    </label>
                                </div>
                            </div>

                            <!-- Opsi untuk Menggambar Tanda Tangan -->
                            <div id="option1-container" class="mb-3 border p-3 rounded bg-light">
                                <p class="fw-bold text-secondary"><i class="bi bi-pencil"></i> Opsi 1: Tanda tangan
                                    langsung</p>
                                <canvas id="signature-pad" class="border rounded w-100 bg-white"
                                    style="height: 200px;"></canvas>
                                <button id="clear" title="Clear" type="button"
                                    class="btn btn-outline-danger mt-2">
                                    <i class="bi bi-eraser"></i> Hapus
                                </button>
                                <input type="hidden" name="signature" id="signature">
                            </div>

                            <!-- Divider -->
                            <div class="border-top my-4"></div>

                            <!-- Opsi untuk Mengunggah Tanda Tangan -->
                            <div id="option2-container" class="mb-3 border p-3 rounded bg-light d-none">
                                <p class="fw-bold text-secondary"><i class="bi bi-file-earmark-image"></i> Opsi 2: Unggah
                                    file tanda tangan</p>
                                <input type="file" name="signature_file" id="signature-file" class="form-control"
                                    accept="image/png">
                                <small class="text-muted d-block mt-2">Format file yang didukung: JPG, JPEG, PNG</small>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Mengontrol visibilitas opsi berdasarkan pilihan radio
                        const option1Radio = document.getElementById('option1');
                        const option2Radio = document.getElementById('option2');
                        const option1Container = document.getElementById('option1-container');
                        const option2Container = document.getElementById('option2-container');

                        option1Radio.addEventListener('change', () => {
                            if (option1Radio.checked) {
                                option1Container.classList.remove('d-none');
                                option2Container.classList.add('d-none');
                            }
                        });

                        option2Radio.addEventListener('change', () => {
                            if (option2Radio.checked) {
                                option2Container.classList.remove('d-none');
                                option1Container.classList.add('d-none');
                            }
                        });
                    </script>

                    <script>
                        // Preview file yang diunggah untuk Evidence
                        document.getElementById('evidence').addEventListener('change', function(event) {
                            const previewContainer = document.getElementById('evidencePreviewContainer');
                            previewContainer.innerHTML = ''; // Hapus preview sebelumnya

                            Array.from(event.target.files).forEach(file => {
                                const fileReader = new FileReader();

                                fileReader.onload = function(e) {
                                    const fileUrl = e.target.result;
                                    const fileExtension = file.name.split('.').pop().toLowerCase();

                                    const filePreview = document.createElement('div');
                                    filePreview.classList.add('text-center');
                                    filePreview.style.width = '200px';

                                    if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                                        const img = document.createElement('img');
                                        img.src = fileUrl;
                                        img.alt = file.name;
                                        img.classList.add('img-fluid', 'rounded', 'border');
                                        img.style.marginBottom = '5px';
                                        filePreview.appendChild(img);
                                    } else {
                                        const link = document.createElement('a');
                                        link.href = fileUrl;
                                        link.target = '_blank';
                                        link.textContent = file.name;
                                        link.classList.add('btn', 'btn-primary', 'btn-sm', 'w-100');
                                        filePreview.appendChild(link);
                                    }

                                    const fileName = document.createElement('small');
                                    fileName.textContent = file.name;
                                    filePreview.appendChild(fileName);

                                    previewContainer.appendChild(filePreview);
                                };

                                fileReader.readAsDataURL(file);
                            });
                        });
                    </script>

                    <div class="mb-3">
                        <label class="form-label fw-bold "><i class="bi bi-envelope-plus"></i> CC Email
                        </label>
                        <div id="cc-email-container" class="w-100" style="max-width: 400px;">
                            <div class="input-group mb-2">
                                <select name="cc_email[]" class="form-select cc-email-select" style="width: 70%;">
                                    <option value="">Pilih CC Email</option>
                                    @foreach ($data as $user)
                                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-primary add-cc-email" style="width: 10%;">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div id="cc-email-list" class="mt-2"></div>
                    </div>
                    {{-- 
                    <div class="mb-3">
                        <label for="statusppk" class="form-label fw-bold">Status PPK</label>
                        <select name="statusppk" class="form-select">
                            <option value="">--Pilih Status--</option>
                            @foreach ($status as $s)
                                <option value="{{ $s->nama_statusppk }}" {{ old('statusppk') == $s->nama_statusppk ? 'selected' : '' }}>
                                    {{ $s->nama_statusppk }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    --}}

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('ppk.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i>
                            Kembali</a>
                        <button type="submit" class="btn btn-primary">Save <i class="bi bi-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@3.0.0/dist/signature_pad.umd.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi Signature Pad
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas);
            const ctx = canvas.getContext('2d');
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            ctx.scale(ratio, ratio);

            // Clear signature pad
            document.getElementById('clear').addEventListener('click', function() {
                signaturePad.clear();
            });

            // Tambah input CC email
            $('.add-cc-email').click(function() {
                $('#cc-email-container').append(
                    `<div class="input-group mb-2">
                        <input type="email" name="cc_email[]" class="form-control" placeholder="Masukkan CC Email">
                        <button type="button" class="btn btn-outline-warning remove-cc-email">
                            <i class="bi bi-dash"></i>
                        </button>
                    </div>`
                );
            });

            // Hapus input CC email
            $(document).on('click', '.remove-cc-email', function() {
                $(this).closest('.input-group').remove();
            });

            // Simpan tanda tangan sebagai data URL saat form disubmit
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!signaturePad.isEmpty()) {
                    const signatureDataUrl = signaturePad.toDataURL();
                    document.getElementById('signature').value = signatureDataUrl;
                } else if (document.getElementById("signature-file").files.length === 0) {
                    alert("Silakan buat tanda tangan di canvas atau unggah file tanda tangan.");
                    e.preventDefault();
                }
            });

            window.addEventListener('resize', function() {
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                ctx.scale(ratio, ratio);
            });

            // Mengisi data pembuat
            document.getElementById("pembuat").addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById("emailpembuat").value = selectedOption.getAttribute("data-email");
                document.getElementById("divisipembuat").value = selectedOption.getAttribute("data-divisi");
            });

            // Mengisi data penerima
            document.getElementById("penerima").addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById("emailpenerima").value = selectedOption.getAttribute("data-email");
                document.getElementById("divisipenerima").value = selectedOption.getAttribute(
                    "data-divisi");
            });

            // Preview image sebelum diunggah
            document.getElementById("evidence").addEventListener("change", function() {
                const file = this.files[0];
                if (file && file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById("evidencePreview").src = e.target.result;
                        document.getElementById("evidencePreview").style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById("evidencePreview").style.display = 'none';
                }
            });
        });
    </script>
@endsection
