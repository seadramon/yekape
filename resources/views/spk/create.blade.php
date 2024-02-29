@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['spk.update', $data->id], 'class' => 'form', 'id' => "form-spk", 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id', $data->id) !!}
                @method('PUT')
            @else
                {!! Form::open(['url' => route('spk.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-spk", 'enctype' => 'multipart/form-data']) !!}
            @endif
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif SPK</h3>
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
                            <label class="form-label">Nomor</label>
                            {!! Form::text('nomor', null, ['class'=>'form-control', 'id'=>'nomor', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jenis </label>
                            {!! Form::select('jenis', $jenis, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tanggal </label>
                            {!! Form::text('tanggal', null, ['class'=>'form-control kt-datepicker', 'id'=>'tanggal', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">PP</label>
                            {!! Form::select('serapan', $serapan, $data->serapan_id ?? null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'serapan', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kontraktor</label>
                            {!! Form::select('kontraktor', $kontraktor, $data->kontraktor_id ?? null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'kontraktor', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Uraian</label>
                            {!! Form::text('uraian', null, ['class'=>'form-control', 'id'=>'uraian', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nilai SPK</label>
                            {!! Form::text('nilai', null, ['class'=>'form-control currency', 'id'=>'nilai', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">PPn</label>
                            {!! Form::select('ppn', $ppn, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'ppn']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nilai PPn</label>
                            {!! Form::text('ppn_nilai', 0, ['class'=>'form-control currency', 'id'=>'ppn_nilai', 'autocomplete'=>'off', 'readonly']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Total</label>
                            {!! Form::text('total', 0, ['class'=>'form-control currency', 'id'=>'total', 'autocomplete'=>'off', 'readonly']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Upload (Format PDF)</label>
                            {!! Form::file('file', ['class' => 'form-control', 'id' => 'file', "accept" => "application/pdf"]) !!}
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('spk.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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
        @if (isset($data))
            $("#ppn").trigger('change');
        @endif
    });

    $(document).on('change', '#ppn', function(){
        var jml = parseFloat($("#nilai").val().replaceAll('.', '').replaceAll(',', '.'));
        var ppn = parseInt($("#ppn").val());

        $("#ppn_nilai").val((jml * ppn / 100).toFixed(2).replaceAll('.', ','));
        $("#ppn_nilai").trigger('keyup');
        $("#total").val((jml + (jml * ppn / 100)).toFixed(2).replaceAll('.', ','));
        $("#total").trigger('keyup');
    });

</script>
@endsection
