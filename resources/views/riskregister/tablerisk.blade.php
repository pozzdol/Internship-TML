@extends('layouts.main')

@section('content')

    <!-- Check for success message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Check for error message -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">TABLE RISK & OPPORTUNITY REGISTER {{ $forms->first()->divisi->nama_divisi ?? '' }}</h5>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-start gap-3 mt-3">
                <!-- Filter Button (Trigger Modal) -->
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal"
                    style="font-weight: 500; font-size: 12px; padding: 6px 12px;border-radius: 0;">
                    <i class="fa fa-filter" style="font-size: 14px;"></i> Filter Options
                </button>
                <!-- New Issue Button -->
                <a href="{{ route('riskregister.create', ['id' => $id]) }}" class="btn btn-success"
                    style="font-weight: 500;border-radius: 0; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-plus" style="font-size: 14px;"></i> New Issue
                </a>
                <a href="{{ url()->current() }}" class="btn btn-secondary"
                    style="font-weight: 500; font-size: 12px; border-radius: 0;padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                    <i class="fa fa-refresh" style="font-size: 14px;"></i> Reset
                </a>

            </div>
        </div>
    </div>
    <!-- Modal for Filters -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="filterModalLabel">
                        <i class="bi bi-funnel-fill"></i> Filter Options
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="GET" action="{{ route('riskregister.tablerisk', $id) }}">
                        <div class="row mb-4">
                            <!-- Kriteria -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-card-list"></i> Kriteria</label>
                                    <select name="kriteria" class="form-select">
                                        <option value="">-- Semua Kriteria --</option>
                                        <option value="Unsur keuangan / Kerugian"
                                            {{ request('kriteria') == 'Unsur keuangan / Kerugian' ? 'selected' : '' }}>Unsur
                                            keuangan / Kerugian</option>
                                        <option value="Safety & Health"
                                            {{ request('kriteria') == 'Safety & Health' ? 'selected' : '' }}>Safety & Health
                                        </option>
                                        <option value="Enviromental (lingkungan)"
                                            {{ request('kriteria') == 'Enviromental (lingkungan)' ? 'selected' : '' }}>
                                            Enviromental (lingkungan)</option>
                                        <option value="Reputasi" {{ request('kriteria') == 'Reputasi' ? 'selected' : '' }}>
                                            Reputasi</option>
                                        <option value="Financial"
                                            {{ request('kriteria') == 'Financial' ? 'selected' : '' }}>Financial</option>
                                        <option value="Operational"
                                            {{ request('kriteria') == 'Operational' ? 'selected' : '' }}>Operational
                                        </option>
                                        <option value="Kinerja" {{ request('kriteria') == 'Kinerja' ? 'selected' : '' }}>
                                            Kinerja</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Tingkatan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-bar-chart-line"></i> Tingkatan</label>
                                    <select name="tingkatan" class="form-select">
                                        <option value="">-- Semua Tingkatan --</option>
                                        <option value="LOW" {{ request('tingkatan') == 'LOW' ? 'selected' : '' }}>LOW
                                        </option>
                                        <option value="MEDIUM" {{ request('tingkatan') == 'MEDIUM' ? 'selected' : '' }}>
                                            MEDIUM</option>
                                        <option value="HIGH" {{ request('tingkatan') == 'HIGH' ? 'selected' : '' }}>HIGH
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-check-circle"></i> Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">-- Semua Status --</option>
                                        <option value="OPEN" {{ request('status') == 'OPEN' ? 'selected' : '' }}>OPEN
                                        </option>
                                        <option value="ON PROGRES"
                                            {{ request('status') == 'ON PROGRES' ? 'selected' : '' }}>ON PROGRESS</option>
                                        <option value="CLOSE" {{ request('status') == 'CLOSE' ? 'selected' : '' }}>CLOSE
                                        </option>
                                        <option value="open_on_progres"
                                            {{ request('status') == 'open_on_progres' ? 'selected' : '' }}>OPEN & ON
                                            PROGRES</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Search for Target PIC -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-person"></i> Cari PIC</label>
                                    <select name="targetpic" class="form-select">
                                        <option value="">Pilih Target PIC</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->nama_user }}"
                                                {{ request('targetpic') == $user->nama_user ? 'selected' : '' }}>
                                                {{ $user->nama_user }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Search for Issue -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-search"></i> Cari Issue</label>
                                    <textarea name="keyword" class="form-control" placeholder="Masukkan Issue" rows="3">{{ request('keyword') }}</textarea>
                                </div>
                            </div>

                            <!-- Top 10 Highest Risk -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="top10" value="1" class="form-check-input"
                                            {{ request('top10') ? 'checked' : '' }}>
                                        <label class="form-check-label"><i class="bi bi-sort-numeric-up"></i> Tampilkan
                                            hanya 10 tertinggi</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary px-4" style="border-radius: 0;">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <button type="reset" class="btn btn-warning px-4" style="border-radius: 0;">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                            <a href="{{ route('riskregister.export-pdf', ['id' => $divisiList]) }}?tingkatan={{ request('tingkatan') }}&status={{ request('status') }}&nama_divisi={{ request('nama_divisi') }}&year={{ request('year') }}&search={{ request('search') }}&kriteria={{ request('kriteria') }}&top10={{ request('top10') }}"
                                style="border-radius: 0;" title="Export PDF" class="btn btn-danger ms-2">
                                <i class="bi bi-file-earmark-pdf"></i> Export PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>
    <!-- Small tables -->
    <div class="card">
        <div class="card-body">
            <div style="overflow-x: auto;">
                <div class="table-wrapper">
                    <table class="table table-striped" style="width: 180%; font-size: 13px;">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Issue (Int:Ex)</th>
                                <th scope="col">I/E</th>
                                <th scope="col" style="width: 200px;">Pihak Berkepentingan</th>
                                <th scope="col">Resiko</th>
                                <th scope="col">Peluang</th>
                                <th scope="col">Tingkatan</th>
                                <th scope="col" style="width: 300px;">Tindakan Lanjut</th>
                                <th scope="col">Target Penyelesaian</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actual Risk</th>
                                <th scope="col">Before</th>
                                <th scope="col">After</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1; // Inisialisasi variabel untuk nomor urut

                            @endphp

                            @foreach ($forms as $form)
                                @php
                                    // Ambil resiko yang terkait dengan form ini
                                    $resikos = \App\Models\Resiko::where('id_riskregister', $form->id)->get();

                                    // Cek apakah ada resiko dengan status CLOSE dan after tidak null
                                    $isClosed = $resikos->contains(function ($resiko) {
                                        return !is_null($resiko->after) && $resiko->status === 'CLOSE';
                                    });
                                @endphp

                                @if (!$isClosed)
                                    <tr>
                                        <td>{{ $no++ }}
                                        </td>
                                        <td>{{ $form->issue }}</td>
                                        <td>{{ $form->inex }}</td>
                                        <td>{{ $form->pihak }}</td>

                                        <!-- Kolom Resiko -->
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    {{ $resiko->nama_resiko }}
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>

                                        <td>{{ $form->peluang ?? '-' }}</td>
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    @php
                                                        $btnClass = '';
                                                        if ($resiko->tingkatan === 'HIGH') {
                                                            $btnClass = 'btn-danger';
                                                        } elseif ($resiko->tingkatan === 'MEDIUM') {
                                                            $btnClass = 'btn-warning';
                                                        } elseif ($resiko->tingkatan === 'LOW') {
                                                            $btnClass = 'btn-success';
                                                        }
                                                    @endphp

                                                    <a href="{{ route('resiko.matriks', ['id' => $form->id, 'tingkatan' => $resiko->tingkatan]) }}"
                                                        title="Matriks Before" class="btn {{ $btnClass }}"
                                                        style="font-size: 9px; padding: 2px; color: white;">
                                                        <strong>{{ $resiko->tingkatan }}</strong><i class="ri-grid-line"
                                                            style="font-size: 14px;"></i>
                                                    </a>

                                                    <br>
                                                    <a class="btn btn-success mt-2"
                                                        href="{{ route('resiko.edit', ['id' => $form]) }}"
                                                        title="Edit Matriks"
                                                        style="font-size: 10px; padding: 3px; color: white;">
                                                        <strong>Edit</strong><i class="bx bx-edit"
                                                            style="font-size: 13px;"></i>
                                                    </a>
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>

                                        <!-- Kolom pihak berkepentingan dan tindakan lanjut -->
                                        <td>
                                            @if (isset($data[$form->id]))
                                                <ul>
                                                    @foreach ($data[$form->id] as $tindakan)
                                                        <li>
                                                            <strong class="d-none">Pihak: {{ $tindakan->pihak }}
                                                            </strong><!-- Menampilkan pihak sebagai string biasa -->
                                                            <ul>
                                                                {{-- <li> --}}
                                                                <a href="{{ route('realisasi.index', $tindakan->id) }}">
                                                                    {{ $tindakan->nama_tindakan }}
                                                                </a>
                                                                <div>
                                                                    <span
                                                                        class="badge bg-purple">{{ $tindakan->tgl_penyelesaian ?? '-' }}</span>
                                                                    <span
                                                                        class="badge bg-purple">{{ $tindakan->user->nama_user ?? '-' }}</span>

                                                                </div>

                                                                @if ($tindakan->isClosed)
                                                                    <span class="badge bg-purple">CLOSE</span>
                                                                @endif
                                                                {{-- </li> --}}
                                                            </ul>
                                                        </li>
                                                        <hr>
                                                    @endforeach
                                                </ul>
                                            @else
                                                Tidak ada tindakan lanjut
                                            @endif
                                        </td>

                                        <td>{{ $form->target_penyelesaian }}</td>

                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    <span
                                                        class="badge
                                                                    @if ($resiko->status == 'OPEN') bg-danger
                                                                    @elseif($resiko->status == 'ON PROGRES')
                                                                        bg-warning
                                                                    @elseif($resiko->status == 'CLOSE')
                                                                        bg-success @endif">
                                                        {{ $resiko->status }}<br>
                                                        {{ $form->nilai_actual }}%
                                                    </span>
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    <a href="{{ route('resiko.matriks2', ['id' => $form->id]) }}"
                                                        title="Matriks After"
                                                        class="btn
                                                                       @if ($resiko->risk == 'HIGH') btn-danger
                                                                       @elseif($resiko->risk == 'MEDIUM') btn-warning
                                                                       @elseif($resiko->risk == 'LOW') btn-success
                                                                       @else btn-info @endif"
                                                        style="font-size: 9px; padding: 2px; color: white; margin-bottom: 5px;">
                                                        <strong>{{ $resiko->risk }}</strong>
                                                        <i class="ri-grid-line" style="font-size: 14px;"></i>
                                                    </a>
                                                @endforeach
                                            @else
                                                None
                                            @endif

                                            <a class="btn btn-success mt-2"
                                                href="{{ route('resiko.edit', ['id' => $form]) }}" title="Edit Matriks"
                                                style="font-size: 10px; padding: 3px; color: white;">
                                                <strong>Edit</strong>
                                                <i class="bx bx-edit" style="font-size: 10px;"></i>
                                            </a>
                                        </td>

                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    {{ $resiko->before }}
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td>
                                            @if ($resikos->isNotEmpty())
                                                @foreach ($resikos as $resiko)
                                                    {{ $resiko->after }}
                                                @endforeach
                                            @else
                                                None
                                            @endif
                                        </td>
                                        <td>
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                                <a href="{{ route('riskregister.edit', $form->id) }}" title="Edit Issue"
                                                    class="btn btn-success"
                                                    style="font-weight: 500; font-size: 12px; padding: 6px 12px; display: flex; align-items: center; gap: 5px;">
                                                    <i class="bx bx-edit" style="font-size: 14px;"></i>
                                                </a>
                                                <form action="{{ route('riskregister.destroy', $form['id']) }}"
                                                    method="POST" style="margin: 0;"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        style="display: flex; align-items: center; gap: 5px;">
                                                        <i class="ri ri-delete-bin-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        function loadDetail(id) {
            $.ajax({
                url: `/realisasi/${id}/detail`,
                method: 'GET',
                success: function(response) {
                    if (response.length > 0) {
                        let modalContent = '';
                        response.forEach((detail, index) => {
                            modalContent += `
                            <div class="mb-3">
                                <label for="nama_realisasi_${index}" class="form-label"><strong>Nama Activity:</strong></label>
                                <textarea class="form-control" id="nama_realisasi_${index}" name="nama_realisasi[]" readonly>${detail.nama_realisasi}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tgl_penyelesaian_${index}" class="form-label"><strong>Tanggal Penyelesaian:</strong></label>
                                <input type="date" class="form-control" id="tgl_penyelesaian_${index}" name="tgl_penyelesaian[]" value="${detail.tgl_penyelesaian}" readonly>
                            </div>
                            <input type="hidden" name="id[]" value="${detail.id}">
                            <hr>
                        `;
                        });

                        $('#modalContent').html(modalContent);
                    } else {
                        $('#modalContent').html('<p>Detail tidak tersedia.</p>');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    $('#modalContent').html(`<p>Terjadi kesalahan: ${xhr.responseText}</p>`);
                }
            });
        }

        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '/realisasi/update',
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Data berhasil diperbarui!');
                    $('#detailModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + xhr.responseText);
                }
            });
        });
    </script>

@endsection
