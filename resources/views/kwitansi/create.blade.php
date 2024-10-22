@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            {!! Form::open(['url' => route('kwitansi.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kwitansi"]) !!}
            {!! Form::hidden('jenis_kwitansi', $tipe) !!}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Buat @endif Kwitansi {{$tipe}}</h3>
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
                            <label class="form-label">
                                @php
                                    $attr = ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'spr', 'required']
                                @endphp
                                @if ($tipe == 'KWT')
                                    SPR
                                @else
                                    NUP / Bookin Fee
                                    @php
                                        $attr = ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'nup']
                                    @endphp
                                @endif
                            </label>
                            {!! Form::select('spr', $spr, null, $attr) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tanggal Kwitansi</label>
                            {!! Form::text('tanggal', null, ['class'=>'form-control kt-datepicker', 'id'=>'tanggal', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jenis Penerimaan</label>
                            {!! Form::select('jenis_penerimaan', $jenis_penerimaan, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis_penerimaan', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Terima Dari</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat</label>
                            {!! Form::text('alamat', null, ['class'=>'form-control', 'id'=>'alamat', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Untuk Pembayaran</label>
                            {!! Form::text('keterangan', null, ['class'=>'form-control', 'id'=>'keterangan', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tipe Bayar</label>
                            {!! Form::select('tipe_bayar', $tipe_bayar, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tipe_bayar']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Bank</label>
                            {!! Form::select('bank', $bank, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'bank']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tanggal Transfer</label>
                            {!! Form::text('tanggal_transfer', null, ['class'=>'form-control kt-datepicker', 'id'=>'tanggal_transfer', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jumlah</label>
                            {!! Form::text('jumlah', null, ['class'=>'form-control currency', 'id'=>'jumlah', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        @if ($tipe == 'KWT')
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">DPP</label>
                                {!! Form::text('dpp', null, ['class'=>'form-control currency', 'id'=>'dpp', 'autocomplete'=>'off']) !!}
                            </div>
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Tipe Bayar</label>
                                {!! Form::select('ppn', $ppn, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'ppn']) !!}
                            </div>
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">PPN Nilai</label>
                                {!! Form::text('ppn_rp', null, ['class'=>'form-control currency', 'id'=>'ppn_rp', 'autocomplete'=>'off', 'readonly']) !!}
                            </div>
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Sanksi/Denda</label>
                                {!! Form::text('ppn', null, ['class'=>'form-control currency', 'id'=>'ppn', 'autocomplete'=>'off']) !!}
                            </div>
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Total</label>
                                {!! Form::text('total', null, ['class'=>'form-control currency', 'id'=>'total', 'autocomplete'=>'off', 'disabled' => 'disabled']) !!}
                            </div>
                        @endif
                    </div>
                </div>
            
                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('kwitansi.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
                    <input type="submit" class="btn btn-success" id="btn-submit" value="Simpan">
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
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var blockUI = new KTBlockUI(document.querySelector("#kt_content_container"));
        $("#spr").on('change', function(){
            blockUI.block();
            $.get("{{ route('kwitansi.source-data') }}", { source: 'spr', source_id: $(this).val() }).done(function(result){
                // $("#body-arrival").html(result);
                $("#nama").val(result.data.terima_dari);
                $("#alamat").val(result.data.alamat);
                $("#jumlah").val(result.data.jumlah);
                $("#ppn").val(result.data.ppn).trigger('change');
                
                blockUI.release();
            });
        });
        $("#ppn").on('change', function(){
            var jml = parseFloat($("#jumlah").val());
            var ppn = parseInt($("#ppn").val());
            $("#ppn_rp").val(jml * ppn / 100);
        });
    });

    
</script>
@endsection