<table>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="12" style="font-weight: bold;font-size: 12px;">
            PT YEKAPE
        </td>
        <td style="font-size: 11px;font-style: italic;">
            {{date('d-m-Y H:i:s')}}
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10px;">
            Jl. Wijaya Kusuma No.36 Surabaya (60272)
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5" style="font-weight: bold;text-align: center;font-size: 15px;">
            REKAP PENERIMAAN ANGSURAN
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 10px;">
            Tlp. (031) 5344822, Fax.(031) 5318274
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5" style="text-align: center;font-size: 12px;">
            @if (!empty($periode))
                Periode : {{$labelStart}} s/d {{$labelEnd}}
            @endif
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="border-bottom: 1px solid #000000;font-size: 10px;">
            Anggota REI.No.03.000.364
        </td>
    </tr>

    
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000; text-align: center; font-weight: bold;">Tanggal</td>
        <td colspan="2" style="border: 1px solid #000000; text-align: center; font-weight: bold;">No Kwitansi</td>
        <td colspan="4" style="border: 1px solid #000000; text-align: center; font-weight: bold;">Nama / No.SP</td>
        <td colspan="5" style="border: 1px solid #000000; text-align: center; font-weight: bold;">Keterangan</td>
        <td style="border: 1px solid #000000; text-align: center; font-weight: bold;">Jumlah</td>
    </tr>
    
    @if (count($datas) > 0)
        <?php 
        $jml = 0;
        ?>
        @foreach($datas as $data)
            <tr>
                <td style="border-left: 1px solid #000000;border-right: 1px solid #000000;border-bottom: 1px solid #000000;">{{$data->tanggal}}</td>
                <td colspan="2" style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">{{$data->nomor}}</td>
                <td colspan="4" style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">
                    {{!empty($data->source->customer)?$data->source->customer->nama:"-"}} / {{ !empty($data->source)?$data->source->no_sp:"-" }}
                </td>
                <td colspan="5" style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">
                    {{ $data->keterangan }}
                </td>
                <td style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;text-align: right;">{{number_format($data->jumlah, 2, ',', '.')}}</td>
            </tr>
            <?php  
            $jml = $jml + $data->jumlah;
            ?>
        @endforeach

        <tr>
            <td colspan="7">
                &nbsp;
            </td>
            <td>
                Uang Muka
            </td>
            <td colspan="3" style="font-weight: bold;text-align: center;">
                {{!empty($data->source->rp_uangmuka)?number_format($data->source->rp_uangmuka, 2, ',', '.'):0}}
            </td>
            <td>
                Pembayaran
            </td>
            <td style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;border-left: 1px solid #000000;text-align: right;">
                {{number_format($jml, 2, ',', '.')}}
            </td>
        </tr>
        <tr>
            <td colspan="12" style="text-align: right;">Kekurangan Pembayaran</td>
            <td style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;border-left: 1px solid #000000;text-align: right;font-weight: bold;">
                <?php 
                $kurang = $jml;
                if ($data->source->rp_uangmuka > 0) {
                    $kurang = $data->source->rp_uangmuka - $jml;
                }
                ?>
                {{ number_format($kurang, '2', ',', '.') }}
            </td>
        </tr>
    @else
        <tr>
            <td colspan="13" style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;border-left: 1px solid #000000;text-align: center;">
                Data Tidak ditemukan
            </td>
        </tr>
    @endif
</table>