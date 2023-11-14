<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KWITANSI KWT</title>
<!-- <link rel="stylesheet" href="style.css"> -->
<style type="text/css">
	body {
		padding-left: 20px;
	}
	.ver 
{
  vertical-align: top;
  text-align: right;
  font-size: 20px;
}

.ver div 
{
  -ms-writing-mode: tb-rl;
  -webkit-writing-mode: vertical-rl;
  writing-mode: vertical-rl;
  transform: rotate(270deg);
  white-space: nowrap;
}
</style>
</head>
<body>

<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;margin-top:-1.5em;margin-bottom: 5px;">
  <tr>
	<td class="ver" width="10%">
		<div style="margin-top:10.3em;margin-bottom: 10em;margin-left:-10.8em;margin-right: -9em;">
			<h1 style="margin-bottom: 1px;">PT. YEKAPE SURABAYA</h1>
			<span style="font-size: 25px;">PERUSAHAAN PEMBANGUNAN PERUMAHAN</span><br>
			<span style="font-size: 17.5px;">NPWP : 01.610.686.631.000</span><br>
			<span style="font-size: 17.5px;">Jl. Wijaya Kusuma No.36 Surabaya, Tlp. (031) 5344822, Fax.(031) 5318274</span>
			<hr style="border-top: 3px solid #000;">
		</div>
	</td>

	<td width="80%" style="vertical-align: top;padding-left: 10px;padding-right: 10px;font-size: 16px;">
	 	<table border="0" width="100%" style="font-size: 16px; font-family: Arial, Helvetica, sans-serif;">
	 		<tr>
	 			<td style="font-weight: bold;text-align: left;vertical-align: top;font-size: 21px;">Kwitansi No : {{ $data->nomor }}</td>
	 			<td style="text-align: right;">
	 				SP. NO {{$spr->no_sp}}<br>
	 				Tgl {{ date('j F Y', strtotime($spr->created_at)) }}, {{ $spr->lm_angsuran }} bln, {{ $spr->tipe_pembelian }}
	 			</td>
	 		</tr>
	 	</table>
	 	<table width="100%" border="0" style="font-size: 16px; font-family: Arial, Helvetica, sans-serif;">
	 		<tr>
	 			<td width="29%" style="vertical-align:top;">Sudah terima dari </td>
	 			<td width="1%" style="vertical-align:top;">:</td>
	 			<td width="70%">
	 				{{$data->nama}}
	 				<hr style="border-top:1px dotted #000">
	 				{{ $data->alamat }}
	 				<hr style="border-top: 1px dotted #000;">
	 			</td>
	 		</tr>
	 		<tr>
	 			<td><i>Terbilang</i></td>
	 			<td>:</td>
	 			<td><i>--- {{ucwords(terbilang($data->jumlah)) . ' Rupiah'}} ---</i></td>
	 		<tr>
	 			<td colspan="3">&nbsp;</td>
	 		</tr>
	 		<tr>
	 			<td>Dibayarkan dengan</td>
	 			<td>:</td>
	 			<td>
	 				@if ($data->tipe_bayar == 'transfer')
	 					{{ 'Transfer dari bank '. strtoupper($data->bank).' Tgl Transfer : '. date('d-m-Y', strtotime($data->tanggal_transfer))}}
	 				@else
	 					{{ $data->tipe_bayar }}
	 				@endif
	 			</td>
	 		</tr>
	 		<tr>
	 			<td>Untuk Pembayaran</td>
	 			<td>:</td>
	 			<td>
	 				{{ !empty($data->keterangan)?strtoupper(substr($data->keterangan, 0, 56)):'' }}
	 				<hr style="border-bottom: 1px dotted #000;margin-bottom:1px;margin-top:1px">
	 			</td>
	 		</tr>
	 		<tr>
	 			<td colspan="3">
	 				@if (!empty($data->keterangan))
	 					@if (strlen($data->keterangan) > 56)
	 						{{ strtoupper(substr($data->keterangan, 56, 80)) }}
	 					@else
	 						&nbsp;
	 					@endif
	 				@else
	 					&nbsp;
	 				@endif
	 				<hr style="border-bottom: 1px dotted #000;margin-bottom:1px;margin-top:1px">
	 				@if (!empty($data->keterangan))
	 					@if (strlen($data->keterangan) > 136)
	 						{{ strtoupper(substr($data->keterangan, 136)) }}
	 					@else
	 						&nbsp;
	 					@endif
	 				@else
	 					&nbsp;
	 				@endif
	 				<hr style="border-bottom: 1px dotted #000;margin-bottom:1px;margin-top:1px">
	 			</td>
	 		</tr>
	 	</table>

	 	<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 16px; font-family: Arial, Helvetica, sans-serif;">
	 		<tr>
	 			<td width="50%">&nbsp;</td>
	 			<td width="25%">Total Tagihan Sebelumnya</td>
	 			<td width="5%">: Rp.</td>
	 			<td style="text-align: right;" width="20%">566.370.000</td>
	 		</tr>
	 		<tr>
	 			<td>&nbsp;</td>
	 			<td>Angsuran/Pembayaran</td>
	 			<td style="border-bottom: 1px solid #000;">: Rp.</td>
	 			<td style="text-align: right;border-bottom: 1px solid #000;">60.000.000</td>
	 		</tr>
	 		<tr>
	 			<td>&nbsp;</td>
	 			<td>Total Tagihan Baru</td>
	 			<td>: Rp.</td>
	 			<td style="text-align: right;">503.370.000</td>
	 		</tr>
	 	</table>

	 	<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 16px; font-family: Arial, Helvetica, sans-serif;margin-top: 10px;">
	 		<tr>
	 			<td width="20%">Jumlah Angsuran</td>
	 			<td width="5%">: Rp.</td>
	 			<td style="text-align: right;" width="15%">60.000.000</td>
	 			<td width="60%">&nbsp;</td>
	 		</tr>
	 		<tr>
	 			<td>Sanksi Denda</td>
	 			<td style="border-bottom: 1px solid #000;">: Rp.</td>
	 			<td style="text-align: right;border-bottom: 1px solid #000;">0</td>
	 			<td>&nbsp;</td>
	 		</tr>
	 		<tr>
	 			<td>&nbsp;</td>
	 			<td>: Rp.</td>
	 			<td style="text-align: right;">60.000.000</td>
	 			<td>&nbsp;</td>
	 		</tr>
	 	</table>

	 	<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 16px; font-family: Arial, Helvetica, sans-serif;margin-top: 30px;">
	 		<tr>
	 			<td width="75%" rowspan="2" style="padding-top: 4px;padding-bottom: 41px;">
	 				<span style="border-top: 2px solid #000;padding-top: 8px;padding-bottom: 8px;padding-right:50px;border-bottom: 2px solid #000;font-weight: bold;font-size: 20px;width: 50%;margin-bottom: 25px;">TOTAL Rp. 60.000.000</span><br><br>
	 				*) Pembayaran dengan BG/CEK dianggap sah jika telah dapat diuangkan<br>
	 				*) Pembayaran dengan transfer dianggap sah jika uang telah diterima dan masuk di rekening PT. Yekape Surabaya
	 			</td>
	 			<td width="25%" style="vertical-align: top;text-align: right;">
	 				<span style="text-align: right;">Surabaya, {{ date('j F Y', strtotime($spr->created_at)) }}</span>
	 				<hr style="border-top: 1px dotted #000;margin-top: 1px;">
	 			</td>
	 		</tr>
	 		<tr>
	 			<td width="25%" style="text-align: center;vertical-align: bottom;">
	 				<span>ARIFIANTO</span>
	 				<hr style="border-top: 1px dotted #000;margin-top: 1px;">
	 			</td>
	 		</tr>
	 	</table>
	</td>
  </tr>
</table>
<span><i>print by : {{!empty($data->created_by)?$data->created_by:'KASIR'}} {{ date('d/m/Y', strtotime($data->created_at)) }} (PCKASIR{{ sprintf('%02d', $data->counter) }})</i></span>

</body>
</html>