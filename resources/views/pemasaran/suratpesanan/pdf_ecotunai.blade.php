<!DOCTYPE html>
<html lang="en">
<head>
	<title>Surat Pesanan</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	 {{-- <link href="{{asset('assets/css/demo1/style.bundle.css')}}" rel="stylesheet" type="text/css" />  --}}
	{{-- <link href="https://fonts.cdnfonts.com/css/dot-matrix" rel="stylesheet"> --}}
    <link href="https://www.cdnfonts.com/led-dot-matrix" rel="stylesheet">
</head>
<style type="text/css">
	/* @import url('https://fonts.cdnfonts.com/css/dot-matrix'); */
    @import url('https://www.cdnfonts.com/led-dot-matrix');
	table {
		margin: 0;
		font-family: 'Dot Matrix', sans-serif!important;
		font-size: 10px;
		line-height: 1.5;
		/*color: #464E5F;*/
		color: black;
		text-align: left;
		background-color: #ffffff;
	}
</style>
<!-- <style type="text/css">
	body {
		margin: 0;
		font-family: Poppins, Helvetica, "sans-serif";
		font-size: 10px;
		line-height: 1.5;
		/*color: #464E5F;*/
		color: #3a3a3a;
		text-align: left;
		background-color: #ffffff; }
	.table {
		width: 100%;
		margin-bottom: 1rem;
		color: #464E5F;
		border-collapse: collapse;}
	.table th,
	.table td {
		display: table-cell;
		padding: 0.75rem;
		vertical-align: bottom;
		border-top: 1px solid #8c8f91; }
	.table thead th {
		vertical-align: bottom;
		border-bottom: 1px solid #8c8f91; }
	.table tbody + tbody {
		border-top: 1px solid #8c8f91; }

	.table-bordered {
		border: 1px solid #8c8f91; }
	.table-bordered th,
	.table-bordered td {
		border: 1px solid #8c8f91; }
	.table-bordered thead th,
	.table-bordered thead td {
		border-bottom-width: 1px; }

	.table-hover tbody tr:hover {
		color: #464E5F;
		background-color: #E5EAEE; }

	.text-right {
		text-align: right;
	}
	.text-center {
		text-align: center;
	}
	.text-left {
		text-align: left;
	}
	.text-capitalize {
		text-transform: capitalize;
	}
	h2{
		text-align: center;
		text-transform:uppercase;
		line-height: 0.8;
		margin-bottom: 1000px;
	}
	h4{
		text-align: left;
		line-height: 0.8;
	}
	.break-page{
		page-break-before: always;
	}

</style> -->
<body>

	<table border="0" style="font-size: 9px">
		<tr>
			<td style="width: 70%; font-weight: bold;">PT. YEKAPE SURABAYA -</td>
			<!-- td style="width: 13%">Nomor Dokumen</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%">SOP PMS AP 01</td> -->
		</tr>
		<tr>
			<td style="width: 70%">Jl. Wijaya Kusuma No. 36 Surabaya 60272</td>
			<!-- <td style="width: 13%">Nomor Revisi</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%">0.0</td> -->
		</tr>
		<tr>
			<td style="width: 70%">Telp. 031.5344822 Fax. 5318274</td>
			<!-- <td style="width: 13%">Tanggal Terbit</td>
			<td style="width: 2%">:</td>
			<td style="width: 15%">01 November 2012</td> -->
		</tr>
		<tr>
			<td style="width: 70%">Anggota REI No. 03.000364</td>
			<td style="width: 13%"></td>
			<td style="width: 2%"></td>
			<td style="width: 15%"></td>
		</tr>
	</table>

	<br><br>

	<table width="100%">
		<tr>
			<td style="font-weight: bold; font-size: 14px; text-align: center; text-decoration: underline;" >SURAT PESANAN RUMAH</td>
		</tr>
		<tr>
			<td style="font-size: 12px; text-align: center;">PEMBELIAN {{$data->tipe_pembelian}}</td>
		</tr>
		<tr>
			<td style="font-size: 12px; text-align: center;">{{$data->no_sp}}</td>
		</tr>
	</table>

	<br><br>

	<table border="0" width="100%">
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 95%" colspan="7">Yang bertanda tangan di bawah ini :</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Nama</td>
			<td style="width: 2%">:</td>
			<td style="width: 36%" colspan="2">{{$data->customer->nama}}</td>
			<td style="width: 23%">No HP. : {{$data->customer->telp_1}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Kartu / No. Identitas / NPWP </td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">KTP / {{$data->customer->no_ktp}} / {{$data->customer->no_npwp}} </td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Tempat, Tanggal Lahir / Kewarganegaraan </td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->customer->tempat_lahir}} / {{$data->customer->tanggal_lahir}} / {{$data->customer->kewarganegaraan}} </td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Alamat Identitas</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->customer->alamat}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Alamat Domisili</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->customer->alamat_domisili}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Pekerjaan</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->customer->pekerjaan}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 31%" colspan="2">Sumber Dana</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->sumber_dana}}</td>
		</tr>
		<tr> <td style="width: 100%"  colspan="8"></td> </tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 95%"  colspan="7">Dengan ini Konsumen membeli rumah di PT. YEKAPE SURABAYA untuk dipergunakan sendiri, dengan lokasi persil :</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold">I.</td>
			<td style="width: 31% ; font-weight: bold" colspan="2">Lokasi Persil</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->lokasi_rmh}} {{strtoupper($data->kavling->kota)}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold"></td>
			<td style="width: 31%" colspan="2">Luas Tanah dan Bangunan</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->type_rmh}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold">II.</td>
			<td style="width: 31% ; font-weight: bold" colspan="2">Harga Jual</td>
			<td style="width: 2%">:</td>
			<td style="width: 3%">Rp.</td>
			<td style="width: 12% ; text-align: right; font-weight: bold">{{number_format($data->harga_jual,2) }}</td>
			<td style="width: 44%"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold">III.</td>
			<td style="width: 31% ; font-weight: bold" colspan="2">Total Uang Muka</td>
			<td style="width: 2%">:</td>
			<td style="width: 3%">Rp.</td>
			<td style="width: 12% ; text-align: right;font-weight: bold">{{number_format($data->rp_uangmuka,2)}}</td>
			<td style="width: 44%"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">1.</td>
			<td style="width: 28%">Pembayaran Uang Muka I</td>
			<td style="width: 2%">:</td>
			<td style="width: 3%">Rp.</td>
			<td style="width: 12% ; text-align: right">{{number_format($data->um_0,2)}}</td>
			<td style="width: 44%"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">2.</td>
			<td style="width: 28%">Sisa Uang Muka</td>
			<td style="width: 2%">:</td>
			<td style="width: 3%">Rp.</td>
			<td style="width: 12% ; text-align: right;">{{number_format($data->rp_uangmuka - $data->um_0,2)}}</td>
			<td style="width: 44%"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">3.</td>
			<td style="width: 28%">Diangsur Selama</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->lm_angsuran}} Bulan</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">4.</td>
			<td style="width: 28%">Periode Angsuran</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->p_angsuran_awal}} s/d {{$data->p_angsuran_akhir}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">5.</td>
			<td style="width: 28%">Pembayaran Angsuran / Bulan</td>
			<td style="width: 2%">:</td>
			<td style="width: 3%">Rp.</td>
			<td style="width: 12%; text-align: right">{{number_format($data->nilai_angsuran,2)}}</td>
			<td style="width: 44%"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold">IV.</td>
			<td style="width: 31% ; font-weight: bold" colspan="2">Nilai KPR dari Bank</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">1.</td>
			<td style="width: 28%">No. SPPK</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{$data->no_sppk}}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">2.</td>
			<td style="width: 28%">Rencana Realisasi</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{ date('d/m/Y', strtotime($data->rencana_ajb)) }}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold">V.</td>
			<td style="width: 91% ; font-weight: bold" colspan="6">Pembangunan Rumah</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">1.</td>
			<td style="width: 28%">Jangka waktu pembangunan rumah</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">12 bulan</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">2.</td>
			<td style="width: 28%">Rencana mulai pembangunan rumah</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{ date('M Y', strtotime($data->mulai_bangun)) }}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">3.</td>
			<td style="width: 28%">Rencana pembangunan selesai</td>
			<td style="width: 2%">:</td>
			<td style="width: 59%" colspan="3">{{ date('M Y', strtotime($data->selesai_bangun)) }}</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%; font-weight: bold">VI.</td>
			<td style="width: 91% ; font-weight: bold" colspan="6">Keterangan Lain-lain</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">1.</td>
			<td style="width: 84% ; text-align: justify;" colspan="5">
				Harga rumah sudah termasuk Bangunan Standart (tanpa pagar), Sertifikat HGB, IMB, PDAM, PLN 2200 Watt (Prabayar), PPN, PBB s/d Penyerahan Rumah.
			</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">2.</td>
			<td style="width: 84%; font-weight: bold ; text-align: justify" colspan="5">
				Harga tidak termasuk biaya BPHTB, AJB, BBN.
			</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">3.</td>
			<td style="width: 84% ; text-align: justify" colspan="5">
				Apabila pembayaran angsuran perbulan terjadi keterlambatan, maka akan dikenakan tambahan denda sebesar 5% dari kekurangan angsuran yang harus dibayar tiap bulannya, keterlambatan pembayaran tiga bulan berturut turut, maka pembelian rumah ini menjadi batal dengan sendirinya.
			</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">4.</td>
			<td style="width: 84% ; text-align: justify" colspan="5">
				Pembatalan pembelian rumah oleh karena sebab apapun, maka uang muka yang telah disetor akan dikembalikan sebesar 75%.
			</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">5.</td>
			<td style="width: 84% ; text-align: justify" colspan="5">
				Apabila dalam waktu tiga (3) hari kerja, semenjak ditanda tangani Surat Pembelian ini, konsumen tidak melaksanakan penandatanganan PPJB yang diterbitkan oleh PT Yekape Surabaya, maka konsuman dianggap membatalkan pembelian rumah dan surat pembelian ini dinyatakan Batal dan dengan sendirinya tidak berlaku lagi.
			</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%">6.</td>
			<td style="width: 84% ; text-align: justify" colspan="5">
				Sebelum pelaksanaan tanda tangan AJB (sesuai dalam pasal 12 PPJB), konsumen harus sudah menyelesaikan semua pembayaran biaya-biaya yang timbul dari transaksi jual beli rumah.
			</td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 3%"></td>
			<td style="width: 3%"></td>
			<td style="width: 84%" colspan="5"></td>
		</tr>
		<tr>
			<td style="width: 5%"></td>
			<td style="width: 95%"  colspan="7">Dengan ini kami selaku pembeli rumah memahami dan akan mentaati ketentuan tersebut di atas.</td>

			</td>
		</tr>
	</table>

	<br><br>
	<table width="100%" border="0">
		<br><br>
		<tr>
			<td style="width: 5%;"></td>
			<td style="width: 30%; text-align: center;">Disetujui</td>
			<td style="width: 30%; text-align: center;">Mengetahui</td>
			<td style="width: 30%; text-align: center;">Surabaya, {{ date('d/m/Y', strtotime($data->tgl_sp)) }}</td>
			<td style="width: 5%;"></td>
		</tr>
		<tr>
			<td style="width: 5%;"></td>
			<td style="width: 30%; text-align: center; font-weight: bold;">Direktur PT.Yekape Surabaya</td>
			<td style="width: 30%; text-align: center;">Manager Pemasaran</td>
			<td style="width: 30%; text-align: center;">Pembeli</td>
			<td style="width: 5%;"></td>
		</tr>
		<tr>
			<td colspan="5" style="width: 100%;"><br><br><br><br><br><br></td>
		</tr>
		<tr>
			<td style="width: 5%;"></td>
			<td style="width: 30%; text-align: center; font-weight: bold;">Ir. HERMIEN ROOSITA, MM.</td>
			<td style="width: 30%; text-align: center; font-weight: bold;">FITRIAN HANDAJA M, ST</td>
			<td style="width: 30%; text-align: center; font-weight: bold;">{{$data->customer->nama}}</td>
			<td style="width: 5%;"></td>
		</tr>
	</table>
</body>
</html>
