<table>
    <thead>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th>PT YEKAPE</th>
        </tr>
        <tr>
            <th rowspan="2" colspan="11" style="text-align: center; vertical-align: middle; font-weight: bold;">SURAT PESANAN RUMAH</th>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td rowspan="2" colspan="11" style="text-align: center; vertical-align: middle;">Periode : {{ $labelPeriode }}</td>
        </tr>
        <tr>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">No</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">No SP</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">Nama</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;" colspan="3">Persil</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">Cara Pembayaran</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">Harga Jual</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">Nilai AJB</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">Tanggal AJB</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold; vertical-align: middle;" rowspan="2">Tenaga Pemasaran</th>
        </tr>
        <tr>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">NAMA</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">BLOK</th>
            <th style="border: 1px solid #000000; text-align: center; font-weight: bold;">NOMOR</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        @foreach($datas as $data)
            <tr>
                <td style="border: 1px solid #000000; width: 200%; text-align: center;">{{ $i }}</td>
                <td style="border: 1px solid #000000; width: 300%;">{{ $data->no_sp }}</td>
                <td style="border: 1px solid #000000; width: 200%;">{{ $data->customer->nama }}</td>
                <td style="border: 1px solid #000000; width: 200%;">{{ $data->kavling->nama }}</td>
                <td style="border: 1px solid #000000; width: 200%;">{{ $data->kavling->blok }}</td>
                <td style="border: 1px solid #000000; width: 350%;">{{ $data->kavling->nomor }}</td>
                <td style="border: 1px solid #000000; width: 350%;">{{ $data->tipe_pembelian }}</td>
                <td style="border: 1px solid #000000; width: 650%;">{{ 'Rp. ' . number_format($data->harga_jual, 0, ".", ",") }}</td>
                <td style="border: 1px solid #000000; width: 200%;">{{ !empty($data->rencana_ajb)?date('d-m-Y', strtotime($data->rencana_ajb)):"" }}</td>
                <td style="border: 1px solid #000000; width: 200%;">{{ 'tenaga pemasaran' }}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
    </tbody>
</table>