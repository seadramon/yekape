@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            {!! Form::model($data, ['route' => ['keuangan.validasi-pengajuan-kegiatan.update', $data->id], 'class' => 'form', 'id' => "form-kegiatan",]) !!}
            {!! Form::hidden('id', $data->id) !!}
            @method('PUT')
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Validasi Pengajuan Kegiatan</h3>
                </div>

                <div class="card-body">
                    @if (count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif

                    <div class="row">
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Bagian</label>
                            {!! Form::select('bagian_id', $bagian, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'bagian', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nama</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jenis  Pengajuan</label>
                            {!! Form::select('jenis', $jenis, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3 optional hidden">
                            <label class="form-label">Metode Pengadaan</label>
                            {!! Form::select('jenis_lelang', $jenis_lelang, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis_lelang', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3 optional hidden">
                            <label class="form-label">Bentuk Kontrak</label>
                            {!! Form::select('metode', $metode, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'metode', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3 optional hidden">
                            <label class="form-label">Metode Pembayaran</label>
                            {!! Form::select('jenis_bayar', $jenis_bayar, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis_bayar', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3 optional hidden">
                            <label class="form-label">Tahun</label>
                            {!! Form::select('tahun', $tahun, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tahun', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3 optional hidden">
                            <label class="form-label">Tanggal Verifikasi</label>
                            {!! Form::text('costing_date', null, ['class'=>'form-control kt-datepicker', 'id'=>'costing_date', 'autocomplete'=>'off', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Approval</label>
                            {!! Form::select('approval', $karyawan, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'approval', 'disabled'], $opt_karyawan) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jabatan</label>
                            {!! Form::text('approval_jabatan', null, ['class'=>'form-control', 'id'=>'approval_jabatan', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>
                        @if ($data->jenis == 'BS')
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Penerima</label>
                                {!! Form::select('penerima', $karyawan, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'penerima'], $opt_karyawan) !!}
                            </div>
                        @endif
                        <div class="fv-row form-group col-lg-12 mb-3 mt-2">
                            {{-- <button type="button" class="btn btn-light-primary" id="add-kegiatan-detail">
                                <i class="la la-plus"></i>Tambah Komponen Kegiatan
                            </button> --}}
                        </div>
                        <div class="fv-row form-group col-lg-12 mb-3">
                            <table id="tabel_kegiatan_detail" class="table table-row-bordered text-center">
                                <thead>
                                    <tr style="font-weight: bold;">
                                        <th>Kegiatan</th>
                                        <th>Nama</th>
                                        <th>Harga Satuan</th>
                                        <th>Volume</th>
                                        <th>PPN</th>
                                        <th>Nilai PPN</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-kegiatan-detail">
                                    @if (isset($data))
                                        @foreach ($data->detail as $item)
                                            @php
                                                $total = $item->harga_satuan * $item->volume;
                                                $nilai_ppn = $total * $item->ppn / 100;
                                            @endphp
                                            <tr style="text-align: center; vertical-align: middle;">
                                                <td><input name="detail_id[]" class="detail_id" type="hidden" value="{{ $item->id }}">{{ $item->kegiatan_detail->kegiatan->nama }}</td>
                                                <td><input name="komponen_kegiatan[]" class="komponen_kegiatan" type="hidden" value="{{ $item->kegiatan_detail_id }}">{{ $item->kegiatan_detail->kode_perkiraan}}<br>{{ $item->kegiatan_detail->komponen->kode}}<br>{{$item->kegiatan_detail->komponen->nama }}</td>
                                                <td style="text-align: right;"><input name="hargasatuan[]" class="hargasatuan" type="hidden" value="{{ number_format($item->harga_satuan, 2, ',', '.') }}">{{ number_format($item->harga_satuan, 2, ',', '.') }}</td>
                                                <td><input name="volume[]" class="volume" type="hidden" value="{{ number_format($item->volume, 0, ',', '.') }}">{{ number_format($item->volume, 0, ',', '.') }}</td>
                                                <td><input name="ppn[]" class="ppn" type="hidden" value="{{ number_format($item->ppn, 0) }}">{{ number_format($item->ppn, 0) }}%</td>
                                                <td style="text-align: right;"><input name="nilaippn[]" class="nilaippn" type="hidden" value="{{ number_format($nilai_ppn, 2, ',', '.') }}">{{ number_format($nilai_ppn, 2, ',', '.') }}</td>
                                                <td style="text-align: right;"><input name="total[]" class="total" type="hidden" value="">{{ number_format($total + $nilai_ppn, 2, ',', '.') }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('keuangan.validasi-pengajuan-kegiatan.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
                    <input type="submit" class="btn btn-success" id="btn-submit" value="Validasi">
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Content container-->
@endsection

@section('css')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#jenis").trigger('change');
    });

    $(document).on('change', '#jenis', function(event){
        if($("#jenis").val() == 'BS'){
            $(".optional").addClass('hidden');
        }else{
            $(".optional").removeClass('hidden');
        }
    });
    
</script>
<script type="text/javascript">
    
    
</script>
@endsection
