@extends('layouts.main')

@section('content')

    <div class="container">

        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 0;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <br>

        <!-- Search Button (Trigger Modal) -->
        <div class="card text-center shadow-sm border-0 rounded-lg">
            <div class="card-body py-4">
                <h5 class="card-title text-uppercase fw-bold text-primary"
                    style="font-size: 26px; letter-spacing: 1.5px; word-spacing: 2px;">
                    ALL REPORT RISK & OPPORTUNITY REGISTER
                </h5>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center w-100">
            <div role="group" class="d-flex align-items-center">
                <!-- Filter Button -->
                <button type="button" class="btn btn-outline-primary shadow-sm px-2 py-2 rounded-lg" data-bs-toggle="modal"
                    data-bs-target="#filterModal" style="border-radius: 0 !important;">
                    <i class="fa fa-filter me-1"></i> Filter Options
                </button>

                <!-- Export PDF Button (ISO 9001) -->
                <a href="{{ route('riskregister.export-pdf', ['id' => $divisiList->first()->id ?? '', 'layout' => 'layout_a']) }}?tingkatan={{ request('tingkatan') }}&status={{ request('status') }}&nama_divisi={{ request('nama_divisi') }}&year={{ request('year') }}&keyword={{ request('keyword') }}&kriteria={{ request('kriteria') }}&top10={{ request('top10') }}&sorting_tingkatan={{ request('sorting_tingkatan') }}&sorting_tanggal={{ request('sorting_tanggal') }}"
                    class="btn btn-danger shadow-sm px-3 py-2 ms-2 rounded-lg" title="Export PDF ISO 9001"
                    style="border-radius: 0 !important;">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF ISO 9001
                </a>
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('riskregister.export-excel', ['id' => $divisiList->first()->id ?? '', 'layout' => 'layout_a']) }}&tingkatan={{ request('tingkatan') }}&status={{ request('status') }}&nama_divisi={{ request('nama_divisi') }}&year={{ request('year') }}&keyword={{ request('keyword') }}&kriteria={{ request('kriteria') }}&top10={{ request('top10') }}&sorting_tingkatan={{ request('sorting_tingkatan') }}&sorting_tanggal={{ request('sorting_tanggal') }}"
                        class="btn btn-success shadow-sm px-3 py-2 ms-2 rounded-lg" title="Export Excel"
                        style="border-radius: 0 !important;">
                        <i class="bi bi-file-earmark-excel me-1"></i> EXPORT EXCEL
                    </a>
                @endif




                <!-- Switch Button -->
                <div class="form-check form-switch ms-2 me-0">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                </div>

                <!-- Export PDF Button (ISO 37001) -->
                <a href="{{ route(
                    'riskregister.export-pdf',
                    array_merge(['id' => $divisiList->first()->id ?? '', 'layout' => 'layout_b'], request()->query()),
                ) }}"
                    id="pdfISO37001" class="btn btn-outline-danger shadow-sm px-3 py-2 ms-1 rounded-lg d-none"
                    title="Export PDF ISO 37001" style="border-radius: 0 !important;">
                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF ISO 37001
                </a>
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('riskregister.export-excel', ['id' => $divisiList->first()->id ?? '', 'layout' => 'layout_b']) }}&tingkatan={{ request('tingkatan') }}&status={{ request('status') }}&nama_divisi={{ request('nama_divisi') }}&year={{ request('year') }}&keyword={{ request('keyword') }}&kriteria={{ request('kriteria') }}&top10={{ request('top10') }}&sorting_tingkatan={{ request('sorting_tingkatan') }}&sorting_tanggal={{ request('sorting_tanggal') }}"
                        id="excelExport" class="btn btn-outline-success shadow-sm px-3 py-2 ms-2 rounded-lg d-none"
                        title="Export Excel" style="border-radius: 0 !important;">
                        <i class="bi bi-file-earmark-excel me-1"></i> EXCEL ISO 37001
                    </a>
                @endif

            </div>

            <!-- Settings Button -->
            <a href="{{ route('admin.kriteria') }}"
                class="btn btn-primary shadow-sm d-flex align-items-center justify-content-center" title="Setting Kriteria"
                style="width: 45px; height: 45px; border-radius: 50%;">
                <i class="ri-settings-5-line fs-4"></i>
            </a>
        </div>



        <br>

        <style>
            .badge.bg-purple {
                background-color: #ADD8E6;

                color: rgb(0, 0, 0);
            }

            .table-wrapper {
                position: relative;
                max-height: 400px;
                /* Adjust height as needed */
                overflow-y: auto;
            }

            .table th {
                position: sticky;
                top: 0;
                background-color: #fff;
                /* Optional: to make sure the header has a white background */
                z-index: 1;
                /* Ensure the header is above the table rows */
            }
        </style>

        <!-- Modal for Filters -->
        <!-- Modal Filter -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Tambahkan modal-lg agar lebih luas -->
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="filterModalLabel"><i class="bi bi-funnel"></i> Filter Options</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Form Filter -->
                    <form method="GET" action="{{ route('riskregister.biglist') }}">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-3"> <!-- Menggunakan g-3 untuk jarak antar elemen -->

                                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'manajemen')
                                        <div class="col-md-6">
                                            <label for="nama_divisi" class="form-label">
                                                <i class="bi bi-building"></i> <strong>Departemen:</strong>
                                            </label>
                                            <select id="nama_divisi" name="nama_divisi" class="form-select">
                                                <option value="">-- Semua Departemen --</option>
                                                @foreach ($divisiList as $divisi)
                                                    <option value="{{ $divisi->nama_divisi }}"
                                                        {{ request('nama_divisi') == $divisi->nama_divisi ? 'selected' : '' }}>
                                                        {{ $divisi->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <div class="col-md-6">
                                        <label for="year" class="form-label">
                                            <i class="bi bi-calendar"></i> <strong>Tahun Penyelesaian:</strong>
                                        </label>
                                        <select id="year" name="year" class="form-select">
                                            <option value="">-- Semua Tahun --</option>
                                            @for ($year = date('Y'); $year >= 2000; $year--)
                                                <option value="{{ $year }}"
                                                    {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="kriteria" class="form-label">
                                            <i class="bi bi-list-task"></i> <strong>Kriteria:</strong>
                                        </label>
                                        <select id="kriteria" name="kriteria" class="form-select">
                                            <option value="">-- Semua Kriteria --</option>
                                            <option value="Unsur keuangan / Kerugian"
                                                {{ request('kriteria') == 'Unsur keuangan / Kerugian' ? 'selected' : '' }}>
                                                Unsur keuangan / Kerugian</option>
                                            <option value="Safety & Health"
                                                {{ request('kriteria') == 'Safety & Health' ? 'selected' : '' }}>Safety &
                                                Health</option>
                                            <option value="Enviromental (lingkungan)"
                                                {{ request('kriteria') == 'Enviromental (lingkungan)' ? 'selected' : '' }}>
                                                Enviromental (lingkungan)</option>
                                            <option value="Reputasi"
                                                {{ request('kriteria') == 'Reputasi' ? 'selected' : '' }}>Reputasi</option>
                                            <option value="Financial"
                                                {{ request('kriteria') == 'Financial' ? 'selected' : '' }}>Financial
                                            </option>
                                            <option value="Operational"
                                                {{ request('kriteria') == 'Operational' ? 'selected' : '' }}>Operational
                                            </option>
                                            <option value="Kinerja"
                                                {{ request('kriteria') == 'Kinerja' ? 'selected' : '' }}>Kinerja</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tingkatan" class="form-label">
                                            <i class="bi bi-bar-chart"></i> <strong>Tingkatan:</strong>
                                        </label>
                                        <select id="tingkatan" name="tingkatan" class="form-select">
                                            <option value="">-- Semua Tingkatan --</option>
                                            <option value="LOW" {{ request('tingkatan') == 'LOW' ? 'selected' : '' }}>
                                                LOW</option>
                                            <option value="MEDIUM"
                                                {{ request('tingkatan') == 'MEDIUM' ? 'selected' : '' }}>MEDIUM</option>
                                            <option value="HIGH" {{ request('tingkatan') == 'HIGH' ? 'selected' : '' }}>
                                                HIGH</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="status" class="form-label">
                                            <i class="bi bi-check-circle"></i> <strong>Status:</strong>
                                        </label>
                                        <select id="status" name="status" class="form-select">
                                            <option value="">-- Semua Status --</option>
                                            <option value="OPEN" {{ request('status') == 'OPEN' ? 'selected' : '' }}>
                                                OPEN</option>
                                            <option value="ON PROGRES"
                                                {{ request('status') == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRESS
                                            </option>
                                            <option value="CLOSE" {{ request('status') == 'CLOSE' ? 'selected' : '' }}>
                                                CLOSE</option>
                                            <option value="open_on_progres"
                                                {{ request('status') == 'open_on_progres' ? 'selected' : '' }}>OPEN & ON
                                                PROGRES</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="keyword" class="form-label">
                                            <i class="bi bi-search"></i> <strong>Search:</strong>
                                        </label>
                                        <input type="text" id="keyword" name="keyword" class="form-control"
                                            placeholder="Search..." value="{{ request('keyword') }}">
                                    </div>

                                    <div class="col-12 text-center mt-3">
                                        <h6 class="text-muted"><strong>-- Sorting Menu --</strong></h6>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sorting_tingkatan" class="form-label">
                                            <i class="bi bi-arrow-down-up"></i> <strong>Tingkatan:</strong>
                                        </label>
                                        <select id="sorting_tingkatan" name="sorting_tingkatan" class="form-select">
                                            <option value="">-- Default --</option>
                                            <option value="high_to_low"
                                                {{ request('sorting_tingkatan') == 'high_to_low' ? 'selected' : '' }}>HIGH
                                                - LOW</option>
                                            <option value="low_to_high"
                                                {{ request('sorting_tingkatan') == 'low_to_high' ? 'selected' : '' }}>LOW -
                                                HIGH</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sorting_tanggal" class="form-label">
                                            <i class="bi bi-calendar-range"></i> <strong>Tanggal:</strong>
                                        </label>
                                        <select id="sorting_tanggal" name="sorting_tanggal" class="form-select">
                                            <option value="">-- Default --</option>
                                            <option value="terbaru"
                                                {{ request('sorting_tanggal') == 'terbaru' ? 'selected' : '' }}>Terbaru
                                            </option>
                                            <option value="terlama"
                                                {{ request('sorting_tanggal') == 'terlama' ? 'selected' : '' }}>Terlama
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
                            <a href="{{ route('riskregister.biglist') }}" class="btn btn-secondary"><i
                                    class="bi bi-arrow-clockwise"></i> Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <br>

        <!-- Small tables -->
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <div class="table-wrapper">
                        <table class="table table-striped" style="width: 180%; font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Issue</th>
                                    <th>I/E</th>
                                    <th>Pihak Berkepentingan</th>
                                    <th>Risiko</th>
                                    <th>Peluang</th>
                                    <th>Tingkatan</th>
                                    <th>Skor Before</th>
                                    <th>Tindakan Lanjut</th>
                                    <th>Actual Risk</th>
                                    <th>Skor After</th>
                                    <th>Before</th>
                                    <th>After</th>
                                    <th>Status</th>
                                    <th>Create At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($formattedData as $data)
                                    <tr>
                                        <td>
                                            <a>
                                                {{ $loop->iteration }}
                                            </a>
                                        </td>
                                        <td>{{ $data['issue'] }}</td>
                                        <td>{{ $data['inex'] }}</td>
                                        <td>{{ $data['pihak'] }}</td>

                                        <td>
                                            @foreach ($data['risiko'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>

                                        <td>{{ $data['peluang'] }}</td>

                                        <td>
                                            @foreach ($data['tingkatan'] as $tingkatan)
                                                {{ $tingkatan }}<br>
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($data['scores'] as $score)
                                                @php
                                                    $colorClass = '';
                                                    if ($score >= 1 && $score <= 2) {
                                                        $colorClass = 'bg-success text-white'; // Hijau
                                                    } elseif ($score >= 3 && $score <= 4) {
                                                        $colorClass = 'bg-warning text-white'; // Kuning
                                                    } elseif ($score >= 5 && $score <= 25) {
                                                        $colorClass = 'bg-danger text-white'; // Merah
                                                    }
                                                @endphp
                                                <span class="badge {{ $colorClass }}">{{ $score }}</span><br>
                                            @endforeach
                                        </td>

                                        <td>
                                            <ul>
                                                @foreach ($data['tindak'] as $index => $pihak)
                                                    {{-- <li> --}}
                                                    <strong>{{ $pihak }}</strong>
                                                    <ul>
                                                        <li>{{ $data['tindak_lanjut'][$index] }}</li>
                                                    </ul>
                                                    {{-- </li> --}}
                                                    <hr>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <!-- Skor -->

                                        <td>
                                            @foreach ($data['risk'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>

                                        <td>
                                            @foreach ($data['scoreactual'] as $score)
                                                @php
                                                    $colorClass = '';
                                                    if ($score >= 1 && $score <= 2) {
                                                        $colorClass = 'bg-success text-white'; // Hijau
                                                    } elseif ($score >= 3 && $score <= 4) {
                                                        $colorClass = 'bg-warning text-white'; // Kuning
                                                    } elseif ($score >= 5 && $score <= 25) {
                                                        $colorClass = 'bg-danger text-white'; // Merah
                                                    }
                                                @endphp
                                                <span class="badge {{ $colorClass }}">{{ $score }}</span><br>
                                            @endforeach

                                        </td>

                                        <td>
                                            @foreach ($data['before'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($data['after'] as $risiko)
                                                {{ $risiko }}<br>
                                            @endforeach
                                        </td>

                                        <!-- Status -->
                                        <td>
                                            @foreach ($data['status'] as $status)
                                                <span
                                                    class="badge
                                            @if ($status == 'OPEN') bg-danger
                                            @elseif($status == 'ON PROGRES')
                                                bg-warning
                                            @elseif($status == 'CLOSE')
                                                bg-success @endif">
                                                    {{ $status }}<br>
                                                    {{ $data['nilai_actual'] }}%
                                                </span><br>
                                            @endforeach
                                        </td>

                                        {{-- Create at --}}
                                        <td style="width: 100px">
                                            @if (isset($data['updated_at']))
                                                {{ \Carbon\Carbon::parse($data['updated_at'])->format('d-m-Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <!-- Action Buttons -->
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- Edit Button -->
                                                <a href="{{ route('riskregister.edit', $data['id']) }}"
                                                    title="Detail Risiko" class="btn btn-success btn-sm me-1">
                                                    <i class="bx bx-edit"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('riskregister.destroy', $data['id']) }}"
                                                    method="POST" style="display:inline;"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="ri ri-delete-bin-fill"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById("flexSwitchCheckDefault").addEventListener("change", function() {
                // Menampilkan tombol PDF
                let pdfButton = document.getElementById("pdfISO37001");
                // Menampilkan tombol Excel jika ada
                let excelButton = document.getElementById("excelExport");
                if (this.checked) {
                    pdfButton.classList.remove("d-none"); // Munculkan tombol PDF
                    if (excelButton) {
                        excelButton.classList.remove("d-none"); // Munculkan tombol Excel
                    }
                } else {
                    pdfButton.classList.add("d-none"); // Sembunyikan tombol PDF
                    if (excelButton) {
                        excelButton.classList.add("d-none"); // Sembunyikan tombol Excel
                    }
                }
            });
        </script>
    @endsection
