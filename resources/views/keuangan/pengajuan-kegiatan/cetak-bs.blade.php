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
        <div class="tengah" style="margin-bottom:15px">
            PENGAJUAN PENGADAAN BARANG / JASA<br>
            SIFAT : BON SEMENTARA
        </div>

        <?php
        $total = 0;
        if (count($data->detail) > 0) {
            foreach($data->detail as $row) {
                $total += $row->total;
            }
        }
        ?>

        <table width="100%" cellspacing="0">
            <tr>
                <td colspan="3" style="text-align:right;">
                    NO : {{ $data->kode }}
                </td>
            </tr>
            <tr>
                <td width="30%" style="font-weight:bold;">
                    1. Dasar
                </td>
                <td width="2%">:</td>
                <td width="68%">
                    Diperintahkan oleh :
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">
                    2. Diperintahkan kepada
                </td>
                <td>:</td>
                <td>
                    Supervisor Hukum
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">
                    3. Untuk keperluan
                </td>
                <td>:</td>
                <td>
                    {{ $data->nama }}
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">
                    4. No Perkiraan
                </td>
                <td>:</td>
                <td>
                    -
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">
                    5. Jumlah yang diperlukan
                </td>
                <td>:</td>
                <td>
                    Rp {{ number_format($total, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">
                    6. Dengan huruf
                </td>
                <td>:</td>
                <td>
                    {{ terbilang($total) }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align:right;padding-top:20px;">
                    Surabaya, {{ date('d F Y', strtotime($data->created_at)) }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align:top;">
                    Ketentuan :
                </td>
                <td>
                    <table>
                        <tr>
                            <td style="vertical-align:top;">1.</td>
                            <td>
                                Pertanggung jawaban Bon Sementara in supaya diselesaikan paling lambat 14 (empat belas) Hari Kerja (21 Hari Kalender) terhitung sejak tanggal penerimaan Dana dari Kas PT. YEKAPE SURABAYA
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">2.</td>
                            <td>
                                Keterlambatan dalam penyelesaian pertanggung jawaban menjadi beban dan tanggung jawab Atasan langsung yang mengajukan.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top;">3.</td>
                            <td>
                                Apabila yang mengambil bukan yang bertanda tangan, harus dilengkapi dengan surat kuasa.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%" cellspacing="0" style="margin-top:30px;margin-bottom:10px;">
            <tr>
                <td width="30%" style="text-align:left;">
                    <div style="text-align:center;margin-bottom:70px;">
                        Menyetujui<br>
                        Sekretaris Perusahaan
                    </div>

                    <div style="text-align:center;">
                        (........................................)
                    </div>
                </td>
                <td width="30%"></td>
                <td width="40%" style="text-align:right;">
                    <div style="text-align:center;margin-bottom:70px;">
                        Yang mengajukan<br>
                        Supervisor Hukum, Humas, Kerjasama dan Rumah tangga
                    </div>

                    <div style="text-align:center;">
                        (........................................)
                    </div>
                </td>
            </tr>
        </table>

        <hr style="border-top:1px solid #0000;">

        <table width="100%" cellspacing="0" style="margin-top:20px;margin-bottom:15px;">
            <tr>
                <td style="text-align:center;">
                    <div style="text-align:center;margin-bottom:70px;">
                        Mengetahui<br>
                        Manajer Keuangan
                    </div>

                    <div style="text-align:center;">
                        (........................................)
                    </div>
                </td>\
            </tr>
        </table>

        <hr style="border-top:1px solid #0000;">

        <table width="100%" cellspacing="0" style="margin-top:20px;margin-bottom:10px;">
            <tr>
                <td width="34%">
                    <div style="text-align:center;margin-bottom:70px;">
                        Dicatat Oleh :
                    </div>

                    <div style="text-align:center;">
                        (........................................)<br>
                        Supervisor Anggaran <br>
                        Tgl.
                    </div>
                </td>

                <td width="33%">
                    <div style="text-align:center;margin-bottom:70px;">
                        Dibukukan dan Dibayarkan Oleh :
                    </div>

                    <div style="text-align:center;">
                        (........................................)<br>
                        Supervisor Kas <br>
                        Tgl.
                    </div>
                </td>

                {{-- <td width="25%">
                    <div style="text-align:center;margin-bottom:70px;">
                        Yang membayar :
                    </div>

                    <div style="text-align:center;">
                        (........................................)<br>
                        Supervisor Kas <br>
                        Tgl.
                    </div>
                </td> --}}

                <td width="33%">
                    <div style="text-align:center;margin-bottom:70px;">
                        Yang menerima :
                    </div>

                    <div style="text-align:center;">
                        (........................................)<br> <br>
                        Tgl.
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>
