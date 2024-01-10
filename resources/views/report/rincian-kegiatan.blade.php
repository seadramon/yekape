<table>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td colspan="17" style="font-weight: bold; font-size: 16px;">
			REKAP MONITORING SERAPAN ANGGARAN TAHUN {{ $tahun }}
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="17" style="font-weight: bold; font-size: 16px;">
			{{ $bagian }}
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>&nbsp;</td>
		<td rowspan="3" style="font-weight: bold;text-align: center;vertical-align: middle;">SUB BAGIAN</td>
		<td rowspan="3" style="font-weight: bold;text-align: center;vertical-align: middle;">KODE PERKIRAAN</td>
		<td rowspan="3" style="font-weight: bold;text-align: center;vertical-align: middle;">NAMA PERKIRAAN</td>
		<td rowspan="3" style="font-weight: bold;text-align: center;vertical-align: middle;">LAP KEU</td>
		<td rowspan="3" style="font-weight: bold;text-align: center;vertical-align: middle;">KELOMPOK</td>
		<td rowspan="2" style="font-weight: bold;text-align: center;vertical-align: middle;">RKAP TAHUN {{ $tahun }}</td>
		<td colspan="4" style="font-weight: bold;text-align: center;vertical-align: middle;">PROGRESS SERAPAN</td>
		<td rowspan="2" style="font-weight: bold;text-align: center;vertical-align: middle;">Jumlah Serapan + BS</td>
		<td rowspan="2" style="font-weight: bold;text-align: center;vertical-align: middle;">Jurnal Koreksi / Jurnal Penyesuaian (dg Lap Keuangan)</td>
		<td rowspan="2" style="font-weight: bold;text-align: center;vertical-align: middle;">SISA ANGGARAN<br>BELUM<br>TERSERAP </td>
		<td rowspan="2" style="font-weight: bold;text-align: center;vertical-align: middle;">SISA ANGGARAN<br>BELUM<br>TERSERAP (+BS) </td>
		<td colspan="3" style="font-weight: bold;text-align: center;vertical-align: middle;">REALISASI PEMBAYARAN / SPMU</td>

		<td rowspan="3">&nbsp;</td>
		<td rowspan="2" style="font-weight: bold;text-align: center;vertical-align: middle;">Bon<br>Sementara</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">Permohonan<br>Pengadaan<br>(PP)</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">Proses<br>Pelaksanaan<br>(SPK)</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">Pengajuan<br>non SPK / PL</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">Jumlah<br>Serapan</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">NON SPK</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">SPK</td>
		<td style="font-weight: bold;text-align: center;vertical-align: middle;">Jumlah<br>Pembayaran</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
		<td style="text-align: center;">Rp</td>
	</tr>

	<?php $total = 0; ?>
	@foreach($datas as $header)
		<?php 
		$total += $header->detail_sum_harga_satuan;
		?>
		<tr>
			<td>&nbsp;</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;font-weight: bold;">{{ $header->bagian->nama }}</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">{{ '' }}</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;font-weight: bold;">{{ $header->nama }}</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;font-weight: bold;text-align: right;">{{ number_format($header->detail_sum_harga_satuan, '0', '.', ',') }}</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black">-</td>

			<td>&nbsp;</td>
			<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black">-</td>
		</tr>

		@foreach($header->detail as $row)
			<tr>
				<td>&nbsp;</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">{{ $header->bagian->nama }}</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;text-align: center;">{{ $row->kode_perkiraan }}</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">{{ $header->nama }}</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;text-align: right;">{{ number_format($row->harga_satuan, '0', '.', ',') }}</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;">-</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">-</td>

				<td>&nbsp;</td>
				<td style="border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black">-</td>
			</tr>
		@endforeach
	@endforeach

	<tr>
		<td>&nbsp;</td>
		<td style="border-bottom: 1px solid black;border-left: 1px solid black;font-weight: bold;background-color: coral;">TOTAL</td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;text-align: center;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;text-align: right;font-weight: bold;">{{ number_format($total, '0', '.', ',') }}</td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"></td>

		<td>&nbsp;</td>
		<td style="background-color: coral;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black"></td>
	</tr>
</table>