<html>
    <head>
        <style>
            body {
                font-size: 11px;
                font-family: arial;
            }

            .tengah {
                text-align: center;
                font-weight: bold;
            }

            table.content {
                table-layout: auto;
                width:100%;
                border-collapse: collapse;
            }

            .content table, .content th, .content td {
                border: 1px solid;
                padding-left: 5px:
            }
            @page { margin:20px 25px 60px 25px; }
            header { margin-bottom: 10px; }
            /* footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; } */
            hr.new1 {
              border-top: 1px dotted black;
            }
        </style>
    </head>

    <body>
        @php
            $kode_perkiraan = $data->detail->map(function($d){
                return $d->kegiatan_detail->kode_perkiraan ?? '-';
            })->join(', ');
            $nm_perkiraan = $data->detail->map(function($d){
                return $d->kegiatan_detail->perkiraan->keterangan ?? '-';
            })->join(',');
        @endphp
        <div class="tengah" style="margin-bottom:30px">
            <u>LAMPIRAN BON SEMENTARA</u>
        </div>

        <table width="100%" style="margin-bottom:30px;">
            <tr>
                <td width="25%" style="font-weight:bold;">
                    NAMA BARANG
                </td>
                <td width="5%" style="font-weight:bold;">:</td>
                <td width="70%">{{ $data->nama }}</td>
            </tr>
            <tr>
                <td width="25%" style="font-weight:bold;" style="font-weight:bold;">
                    BAGIAN/URUSAN
                </td>
                <td width="5%" style="font-weight:bold;">:</td>
                <td width="70%">{{ $data->bagian->nama }}</td>
            </tr>
            <tr>
                <td style="text-align:left;font-weight:bold;padding-right:20%;">
                    No.Perkiraan
                </td>
                <td width="5%" style="font-weight:bold;">:</td>
                <td width="70%">{{ $kode_perkiraan }} - {{ $nm_perkiraan }}</td>
            </tr>
            <tr>
                <td width="25%" style="font-weight:bold;">
                    No./TANGGAL BON SEMENTARA
                </td>
                <td width="5%" style="font-weight:bold;">:</td>
                <td width="70%">{{ $data->kode . ' / ' . date('d M Y', strtotime($data->created_at)) }}</td>
            </tr>
            {{-- <tr>
                <td width="25%" style="font-weight:bold;">
                    DASAR
                </td>
                <td width="5%" style="font-weight:bold;">:</td>
                <td width="70%"></td>
            </tr> --}}
        </table>

        <table width="100%" border="1" cellspacing="0" style="margin-bottom:1px;">
            <tr>
                <td width="2%" rowspan="2" class="tengah">No</td>
                <td width="40%" rowspan="2" class="tengah">Uraian</td>
                <td width="10%" rowspan="2" class="tengah">Volume</td>
                <td colspan="2" width="38%" class="tengah">Harga (Rp)</td>
            </tr>
            <tr>
                <td width="19%" class="tengah">Satuan</td>
                <td width="19%" class="tengah">Jumlah</td>
            </tr>
            @if (count($data->detail) > 0)
                <?php
                $i = 1;
                $jumlah = 0;
                $ppn = 0;
                $ppnPercent = 0;
                $total = 0;
                ?>
                @foreach($data->detail as $row)
                    <?php
                    $harsat = (int)$row->harga_satuan;
                    $subtotal = (int)$row->volume * $harsat;
                    $jumlah += $subtotal;
                    $ppnPercent = $row->ppn;
                    ?>
                    <tr>
                        <td style="text-align:center;">{{ $i }}</td>
                        <td>{{ $row->kegiatan_detail->komponen->nama }}</td>
                        <td style="text-align:right;">{{ $row->volume }}</td>
                        <td style="text-align:right;">{{ !empty($harsat)?number_format($harsat, 0, ',', '.'):0 }}</td>
                        <td style="text-align:right;">{{ !empty($subtotal)?number_format($subtotal, 0, ',', '.'):0 }}</td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
                <?php
                if ($ppnPercent > 0) {
                    $ppn = round($jumlah * $ppnPercent / 100, 2);
                }
                $total = $jumlah + $ppn;
                ?>
            @else
                <tr>
                    <td colspan="6">Data Kosong</td>
                </tr>
            @endif
            <tr>
                <td colspan="4" style="padding-left:80%">Jumlah</td>
                <td style="text-align:right;">{{ number_format($jumlah, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left:80%">PPN 11%</td>
                <td style="text-align:right;">{{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left:80%">TOTAL</td>
                <td style="text-align:right;">{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" style="padding-left:2%;padding-top:10px;padding-bottom:10px;font-weight:bold;">
                    Terbilang : {{ucwords(terbilang($total))}} Rupiah

                </td>
            </tr>
        </table>


    </body>
</html>
