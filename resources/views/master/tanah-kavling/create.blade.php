@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['master.tanah-kavling.store', $data->id], 'class' => 'form', 'id' => "form-kavling", 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id', $data->id) !!}
            @else
                {!! Form::open(['url' => route('master.tanah-kavling.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kavling", 'enctype' => 'multipart/form-data']) !!}
            @endif

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Tanah Kavling</h3>
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
                            <label class="form-label">Nama</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Blok</label>
                            {!! Form::text('blok', null, ['class'=>'form-control', 'id'=>'blok', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nomor</label>
                            {!! Form::text('nomor', null, ['class'=>'form-control', 'id'=>'nomor', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kode Kavling</label>
                            {!! Form::text('kode_kavling', null, ['class'=>'form-control', 'id'=>'kode_kavling', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            {!! Form::text('lokasi', null, ['class'=>'form-control', 'id'=>'lokasi', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">No PBB</label>
                            {!! Form::text('no_pbb', null, ['class'=>'form-control', 'id'=>'no_pbb', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="form-group col-lg-6 mb-3">
                            <label class="form-label">No SHGB</label>
                            {!! Form::text('no_shgb', null, ['class'=>'form-control', 'id'=>'no_shgb', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">No IMB</label>
                            {!! Form::text('no_imb', null, ['class'=>'form-control', 'id'=>'no_imb', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="form-group col-lg-6 mb-3">
                            <label class="form-label">Perkiraan</label>
                            {!! Form::select('perkiraan_id', $perkiraan, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'perkiraan_id']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Luas Bangun</label>
                            {!! Form::text('luas_bangun', null, ['class'=>'form-control', 'id'=>'luas_bangun', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Luas Tanah</label>
                            {!! Form::text('luas_tanah', null, ['class'=>'form-control', 'id'=>'luas_tanah', 'autocomplete'=>'off']) !!}
                        </div>

                        {{--<div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nama WP</label>
                            {!! Form::text('nama_wp', null, ['class'=>'form-control', 'id'=>'nama_wp', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat WP</label>
                            {!! Form::textarea('alamat_wp', null, ['class'=>'form-control', 'rows'=>'3', 'id'=>'alamat_wp', 'autocomplete'=>'off']) !!}
                        </div>--}}

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat OP</label>
                            {!! Form::textarea('alamat_op', null, ['class'=>'form-control', 'rows'=>'3', 'id'=>'alamat_op', 'autocomplete'=>'off']) !!}
                        </div>
                        
                    </div>
                </div>
            
                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('master.tanah-kavling.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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
    $('#perkiraan_id').select2({
        placeholder: "Pilih Perkiraan",
        allowClear: true
    });
    
});


</script>
@endsection