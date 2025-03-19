<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDENTIFIKASI, PENILAIAN, DAN PENGENDALIAN RISIKO PENYUAPAN</title>
    <style>
        h2 {
            text-align: center;
            background-color: #56dbc5;
            padding: 10px;
            page-break-after: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7px;
            page-break-inside: auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 3px;
            text-align: left;
            word-wrap: break-word;
            /* Allow text to wrap if it's too long */
        }

        th {
            background-color: #a6f119;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        /* Align specific columns to the top */
        .align-top {
            vertical-align: top;
        }

        .align-bottom {
            vertical-align: bottom;
        }

        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        .separator {
            border: none;
            border-top: 1px solid black;
            margin: 0;
            padding: 0;
        }

        /* Adjust column widths */
        .col-int-ext {
            width: 30px;
            text-align: center;
        }

        .col-tindakan {
            width: 150px;
            text-align: left;
        }

        .col-risiko {
            width: 80px;
        }

        .col-pihak {
            width: 150px;
            text-align: center;
        }

        .col-target-pic {
            width: 60px;
        }

        .col-pihakk {
            width: 50px;
            text-align: center;
        }

        /* Allow for flexible column width */
        .col-flexible {
            width: auto;
            /* This will allow the column to adjust width based on content */
            min-width: 100px;
            /* Optional: Set a minimum width for flexibility */
        }
    </style>
</head>

<body>

    <h2>IDENTIFIKASI, PENILAIAN, DAN PENGENDALIAN RISIKO PENYUAPAN</h2>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2" style="width: 300px;">Nama Proses</th>
                <th rowspan="2" style="width: 250px;">Potensi Risk Penyuapan</th>
                <th rowspan="2" style="width: 300px;">Skema Penyuapan / Modus Operandi</th>
                <th rowspan="2">*S</th>
                <th rowspan="2">*P</th>
                <th rowspan="2">Level</th>
                <th colspan="1">Tindakan Terhadap Risiko</th>
                <th colspan="3">Sisa Risiko</th>
                <th rowspan="2">Rencana Tindakan / Mitigasi</th>
            </tr>
            <tr>
                <th style="width: 300px;">Tindakan Lanjut </th>
                <th>*S</th>
                <th>*P</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($formattedData as $index => $data)
                <tr>
                    <td class="align-top">{{ $index + 1 }}</td>
                    <td class="align-top">{{ $data['issue'] }}</td>
                    <td class="col-risiko align-top">{{ $data['risiko'] }}</td>
                    <td class="align-top">{{ $data['before'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['severity'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['probability'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['score'] }}</td>
                    <td class="col-tindakan align-top">
                        @foreach ($data['tindak_lanjut'] as $index => $tindak_lanjut)
                            {{ $index + 1 }}. {{ $tindak_lanjut }}<br>
                            @if (!$loop->last)
                                <hr class="separator">
                            @endif
                        @endforeach
                    </td>
                    <td class="col-int-ext align-top">{{ $data['severityrisk'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['probabilityrisk'] }}</td>
                    <td class="col-int-ext align-top">{{ $data['scorerisk'] }}</td>
                    <td class="align-top">{{ $data['after'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
