<div class="col-12 mb-md-5 mb-xl-12">
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">List Monitoring Serapan</h3>
        </div>

        <div class="card-body py-5">
        	<div class="row">
                <div class="table-responsive">
            		<table width="100%" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                			<tr>
                                <th class="txtheader pxl-5 b-right" rowspan="3">SUB BAGIAN</th>
                                <th class="txtheader b-right" rowspan="3">KODE PERKIRAAN</th>
                                <th class="txtheader b-right" rowspan="3">NAMA PERKIRAAN</th>
                                {{-- <th class="txtheader b-right" rowspan="3">LAP KEU</th> --}}
                                {{-- <th class="txtheader b-right" rowspan="3">KELOMPOK</th> --}}
                                <th class="txtheader b-right" rowspan="2">RKAP TAHUN {{ $tahun }}</th>
                                <th class="txtheader b-right" colspan="4">PROGRESS SERAPAN</th>
                                <th class="txtheader b-right" rowspan="2">Jumlah Serapan + BS</th>
                                <th class="txtheader b-right" rowspan="2">SISA ANGGARAN<br>BELUM<br>TERSERAP </th>
                                <th class="txtheader b-right" rowspan="2">SISA ANGGARAN<br>BELUM<br>TERSERAP (+BS) </th>
                                <th class="txtheader pxr-5" rowspan="2">Bon<br>Sementara</th>
                            </tr>
                            <tr>
                                <th class="txtheader b-right">Permohonan<br>Pengadaan<br>(PP)</th>
                                <th class="txtheader b-right">Proses<br>Pelaksanaan<br>(SPK)</th>
                                <th class="txtheader b-right">Pengajuan<br>non SPK / PL</th>
                                <th class="txtheader b-right">Jumlah<br>Serapan</th>
                            </tr>
                            <tr>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center b-right">Rp</th>
                                <th class="text-center">Rp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas) > 0)
                                <?php $total = 0; ?>
                                @foreach($datas as $header)
                                    <?php
                                    $total += $header->detail->sum('total');
                                    ?>
                                    <tr>
                                        <td class="b-right pxl-5"><b>{{ $header->bagian->nama }}</b></td>
                                        <td class="b-right"></td>
                                        <td class="b-right">{{ $header->nama }}</td>
                                        {{-- <td class="b-right">-</td> --}}
                                        {{-- <td class="b-right">-</td> --}}
                                        <td class="b-right txtright">{{ number_format($header->detail->sum('total'), '0', '.', ',') }}</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                        <td class="b-right">-</td>
                                    </tr>

                                    <!-- Loop detail serapan -->
                                    @foreach($header->detail as $row)
                                        <tr>
                                            <td class="b-right pxl-5">{{ $header->bagian->nama }}</td>
                                            <td class="b-right">{{ $row->kode_perkiraan }}</td>
                                            <td class="b-right">{{ $row->komponen->nama }}</td>
                                            {{-- <td class="b-right">-</td> --}}
                                            {{-- <td class="b-right">-</td> --}}
                                            <td class="b-right txtright">{{ number_format($row->total, '0', '.', ',') }}</td>
                                            <td class="b-right txtright">{{ number_format($row->serapan->sum('total'), '0', '.', ',') }}</td>
                                            <td class="b-right">-</td>
                                            <td class="b-right">-</td>
                                            <td class="b-right txtright">{{ number_format($row->serapan->sum('total'), '0', '.', ',') }}</td>
                                            <td class="b-right txtright">{{ number_format($row->serapan->sum('total'), '0', '.', ',') }}</td>
                                            <td class="b-right txtright">{{ number_format($row->total - $row->serapan->sum('total'), '0', '.', ',') }}</td>
                                            <td class="b-right txtright">{{ number_format($row->total - $row->serapan->sum('total'), '0', '.', ',') }}</td>
                                            <td class="b-right">-</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td colspan="3" class="b-right pxl-5"><b>TOTAL</b></td>
                                    <td class="b-right b-top txtright">{{ number_format($total, '0', '.', ',') }}</td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                    <td class="b-right b-top"></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="14">Data tidak ditemukan</td>
                                </tr>
                            @endif
                        </tbody>
            		</table>

                </div>
        	</div>
        </div>
    </div>
</div>
<!--end::Col
