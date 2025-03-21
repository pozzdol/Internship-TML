<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Report PPK {{ $nomor_surat }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('admin/img/TML Logo.jpg') }}" rel="icon">
    <link href="{{ asset('admin/img/TML Logo.jpg') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vendor CSS Files -->

    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <style>
        /* Agar div ini dimulai pada halaman baru */
        .new-page {
            page-break-before: always;
        }

        /* Agar div ini diakhiri pada halaman baru */
        .new-page-after {
            page-break-after: always;
        }
    </style>

</head>

<div class="card border-0">
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
                        PPK NO. {{ $nomor_surat }}
                    </h6>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row mb-3">
                            <div class="col"><strong>Penerima</strong></div>
                            <div class="col">: {{ $ppk->penerimaUser->nama_user }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col"><strong>Departemen Penerima</strong></div>
                            <div class="col">: {{ $divisipenerima }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row mb-3">
                            <div class="col"><strong>Pembuat /
                                    Inisiator</strong>
                            </div>
                            <div class="col">: {{ $ppk->pembuatUser->nama_user }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col"> <strong>Departemen Pembuat</strong></div>
                            <div class="col">: {{ $divisipembuat }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col"><strong>Tanggal Terbit</strong>
                            </div>
                            <div class="col">: {{ $ppk->created_at->format('d/m/Y') }}</div>
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
                    ( {{ str_contains($jenisketidaksesuaian, 'SISTEM') ? '✔' : ' ' }} ) SISTEM
                </span>
                <span class="fw-bold">
                    ( {{ str_contains($jenisketidaksesuaian, 'PROSES') ? '✔' : ' ' }} ) PROSES
                </span>
                <span class="fw-bold">
                    ( {{ str_contains($jenisketidaksesuaian, 'PRODUK') ? '✔' : ' ' }} ) PRODUK
                </span>
                <span class="fw-bold">
                    ( {{ str_contains($jenisketidaksesuaian, 'AUDIT') ? '✔' : ' ' }} ) AUDIT
                </span>
            </div>
            <p class="my-3 me-3" style="text-align: justify;">{{ $judul }}</p>
            <div class="row">
                <div class="col-7">
                    <h6 class="fw-bold">Evidence:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if (!empty($evidence) && is_array($evidence))
                            @foreach ($evidence as $file)
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
                        <div class="col-7 mt-7 ">
                            <p class="mb-1"> Tanda Tangan<br />Inisiator/Auditor
                            </p>
                            <strong> {{ $ppk->pembuatUser->nama_user }}</strong>
                        </div>
                        <div class="col">
                            <img src="{{ $signature }}" style="max-width: 130px; max-height:70px; ">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-7 mt-7 ">
                            <p class="mb-1"> Tanda Tangan<br />Proses Owner/Auditee
                            </p>
                            <strong> {{ $ppk->penerimaUser->nama_user }} </strong>
                        </div>
                        <div class="col">
                            <img src="{{ $signaturepenerima }}" style="max-width: 130px; max-height:70px; ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border border-2 border-top-0 border-dark ">
        <div class="mb-3 p-3 px-5">
            <label for="identifikasi" class="form-label fw-bold">
                2. Identifikasi, evaluasi & pastikan akar penyebab masalah/Root Cause
            </label>
            <br><br>
            @if ($identifikasi)
                <p style="text-align: justify;" class="me-3">
                    {{ $identifikasi }}
                </p>
            @else
                <p>Data tidak tersedia</p>
            @endif
            <span style="font-size: 0.750em;">
                *Gunakan metode 5WHYS untuk menentukan Root Cause; Fish Bone; Diagram alir; Penilaian situasi;
                Kendali
                proses dan peningkatan.
            </span>
        </div>
    </div>
</div>
<p>PT. TATA METAL LESTARI</p>
<div class="card border-0 new-page">
    <div class="border border-2 border-dark">
        <h5 class="card-title text-center text-uppercase fw-bold text-dark"
            style="padding: 0px !important;margin:5px 0px !important; ">
            Proses Peningkatan Kinerja
        </h5>
        <div class="mb-2 border border-1 border-dark"></div>
        <div class="px-5 py-3">
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
                            {{ $penanggulangan ?? 'Tidak ada data penanggulangan' }}
                        </td>
                        <td style="border: 2px solid black; vertical-align: top;" class="p-3 text-center">
                            {{ $tgl_penanggulangan ? \Carbon\Carbon::parse($tgl_penanggulangan)->format('d M Y') : 'Tidak ada Tanggal Penanggulangan' }}
                        </td>
                        <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                            @if (!empty($pic1))
                                @php
                                    $pic1Array = explode(',', $pic1); // Pisahkan berdasarkan koma
                                @endphp

                                @foreach ($pic1Array as $index => $pic)
                                    <p>{{ $index + 1 }}. {{ trim($pic) }}</p>
                                    <!-- Menampilkan nomor urut dan nama PIC -->
                                @endforeach
                            @else
                                <!-- Jika pic1 kosong, gunakan pic1_other -->
                                @if (!empty($pic1_other))
                                    <p>{{ $pic1_other }}</p> <!-- Menampilkan pic1_other -->
                                @else
                                    <p>-</p> <!-- Jika pic1 dan pic1_other kosong -->
                                @endif
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <td style="border: 2px solid black; vertical-align: top;" class="p-3">Pencegahan</td>
                        <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                            {{ $pencegahan ?? 'Tidak ada data pencegahan' }}
                        </td>
                        <td style="border: 2px solid black; vertical-align: top;" class="p-3 text-center">
                            {{ $tgl_pencegahan ? \Carbon\Carbon::parse($tgl_pencegahan)->format('d M Y') : 'Tidak ada Tanggal Pencegahan' }}
                        </td>
                        <td style="border: 2px solid black; vertical-align: top;" class="p-3">
                            @if (!empty($pic2))
                                @php
                                    $pic2Array = explode(',', $pic2); // Pisahkan berdasarkan koma
                                @endphp

                                @foreach ($pic2Array as $index => $pic)
                                    <p>{{ $index + 1 }}. {{ trim($pic) }}</p>
                                    <!-- Menampilkan nomor urut dan nama PIC -->
                                @endforeach
                            @else
                                <!-- Jika pic1 kosong, gunakan pic1_other -->
                                @if (!empty($pic2_other))
                                    <p>{{ $pic2_other }}</p> <!-- Menampilkan pic1_other -->
                                @else
                                    <p>-</p> <!-- Jika pic1 dan pic1_other kosong -->
                                @endif
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-7 text-center">
                    <p>Tanggal : <span class="ps-5" style="border-bottom: 1px solid #000">
                            {{ $created_at->format('d/m/Y') }}
                        </span>
                    </p>
                </div>
                <div class="col text-start d-flex">
                    <p>Tanda Tangan :<br /><strong>{{ $ppk->penerimaUser->nama_user }}</strong></p>
                    <img src="{{ $signaturepenerima }}" class="ms-3" alt="Signature" height="50">
                </div>
            </div>
        </div>

        <div class="mb-2 border border-1 border-dark"></div>

        <div class="px-5 py-3">
            <!-- Verifikasi -->
            <p class="my-4" style="font-size: 2rm;"><strong>4. Verifikasi Tindakan , sesuai kolom"Target
                    Tanggal"</strong></p>

            <div class="row mb-3">
                <label for="verifikasi" class="col-2 col-form-label"><strong>Catatan</strong></label>
                <div class="col-6">

                    @if (!empty($verifikasi) && !empty($verifikasi_img))
                        <p><strong>Catatan Verifikasi:</strong></p>
                        <p>{{ $verifikasi }}</p>
                        @foreach (json_decode($verifikasi_img) as $file)
                            <img src="{{ asset('storage/' . $file) }}" alt="Verifikasi"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                        @endforeach
                    @elseif(!empty($verifikasi))
                        <p><strong>Catatan Verifikasi:</strong></p>
                        <p>{{ $verifikasi }}</p>
                    @elseif(!empty($verifikasi_img))
                        <p><strong>Gambar Verifikasi:</strong></p>
                        @foreach (json_decode($verifikasi_img) as $file)
                            <img src="{{ asset('storage/' . $file) }}" alt="Verifikasi"
                                style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                        @endforeach
                    @else
                        <p>Catatan: Tidak ada Catatan atau Gambar Verifikasi.</p>
                    @endif
                </div>
                <div class="col">
                    <div class="row d-flex justify-content-end">
                        <img src="{{ $signature }}" style="max-width: 130px; max-height:70px; ">
                    </div>
                    <div class="row text-end">
                        <p>Tanggal Verifikasi : <span class="ps-5" style="border-bottom: 1px solid #000">
                                {{ $created_at_ppkketiga ? \Carbon\Carbon::parse($created_at_ppkketiga)->format('d M Y') : 'Tidak ada Tanggal Verifikasi' }}
                            </span>
                        </p>
                        <p>Auditor, <strong>{{ $ppk->pembuatUser->nama_user }}.</strong></p>
                    </div>
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
                <label for="tinjauan" class="col-2 col-form-label"><strong>Catatan</strong></label>
                <div class="col-10">
                    {{ $tinjauan ?? 'Tidak ada Catatan' }}
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 5% 1fr; gap: 10px;">
                <div style="text-align: center;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; text-align: center;">
                        <tr>
                            <td
                                style="border: 1px solid #000; padding: 10px; vertical-align: middle;
                                    background-color: {{ $status == 'TRUE' ? 'green' : 'transparent' }};
                                    color: #000;">
                                {{ $status == 'TRUE' ? '✔' : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
                <p style="margin: 0; padding-top: 20px;">
                    Efektif, dalam 1 bulan masalah yang sama tidak muncul lagi & tindakan penanggulangan sudah
                    selesai
                </p>

                <div style="text-align: center;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #000; text-align: center;">
                        <tr>
                            <td
                                style="border: 1px solid #000; padding: 10px; vertical-align: middle;
                                    background-color: {{ $status == 'FALSE' ? 'red' : 'transparent' }};
                                    color: #000;">
                                {{ $status == 'FALSE' ? '✔' : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
                <p style="margin: 0; padding-top: 20px;">
                    Tidak efektif, dilanjutkan dengan PPK No. {{ $newppk ?? '...' }}
                </p>
            </div>
        </div>

        <div class="mb-2 border border-1 border-dark"></div>

        <div class="px-5 py-3">
            <p class="my-4" style="font-size: 2rm;"><strong>4. Close Out (apabila efektif)</strong></p>
            <div class="row align-items-end">
                <div class="col-7 text-center">
                    <p>Tanda Tangan : <img src="{{ $signature }}" alt="Signature" width="100"
                            style="border-bottom: 1px solid #000"></p>
                    <p>Pembuat/Inisiator: <strong>{{ $ppk->pembuatUser->nama_user }}</strong></p>
                </div>
                <div class="col">
                    <p>Date : <span class="ps-5" style="border-bottom: 1px solid #000">
                            {{ $created_at_ppkketiga ? \Carbon\Carbon::parse($created_at_ppkketiga)->format('d M Y') : 'Tidak ada Tanggal' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<p>PT. TATA METAL LESTARI</p>
<script>
    window.onload = function() {
        window.print();
    };
</script>

</html>
