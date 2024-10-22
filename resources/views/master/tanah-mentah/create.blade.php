@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['master.tanah-mentah.store', $data->id], 'class' => 'form', 'id' => "form-kavling", 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id', $data->id) !!}
            @else
                {!! Form::open(['url' => route('master.tanah-mentah.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kavling", 'enctype' => 'multipart/form-data']) !!}
            @endif

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Tanah Mentah</h3>
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

                    @if (empty($data))
                        <div class="row">
                            <div class="form-group col-lg-6 mb-3">
                                <label class="form-label">Kode Perkiraan</label>
                                {!! Form::select('perkiraan_id', $perkiraan, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'perkiraan_id']) !!}
                            </div>

                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">No SKRK</label>
                                {!! Form::text('no_skrk', null, ['class'=>'form-control', 'id'=>'no_skrk', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">No PBB</label>
                                {!! Form::text('no_pbb', null, ['class'=>'form-control mask-pbb', 'id'=>'no_pbb', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">No SHGB</label>
                                {!! Form::text('no_shgb', null, ['class'=>'form-control', 'id'=>'no_shgb', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Nama</label>
                                {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                {!! Form::text('lokasi', null, ['class'=>'form-control', 'id'=>'lokasi', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Luas Tanah</label>
                                {!! Form::text('luas_tanah', null, ['class'=>'form-control', 'id'=>'luas_tanah', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="form-group col-lg-6 mb-3">
                                <label class="form-label">Nama Wajib Pajak</label>
                                {!! Form::text('nama_wp', null, ['class'=>'form-control', 'id'=>'nama_wp', 'autocomplete'=>'off']) !!}
                            </div>

                            <div class="form-group col-lg-6 mb-3">
                                <label class="form-label">Alamat Wajib Pajak</label>
                                {!! Form::textarea('alamat_wp', null, ['class'=>'form-control', 'id'=>'alamat_wp', 'autocomplete'=>'off', 'rows' => '3']) !!}
                            </div>

                            <div class="form-group col-lg-6 mb-3">
                                <label class="form-label">Alamat Objek Pajak</label>
                                {!! Form::textarea('alamat_op', null, ['class'=>'form-control', 'id'=>'alamat_op', 'autocomplete'=>'off', 'rows' => '3']) !!}
                            </div>
                        </div>
                    @else

                    @endif
                </div>
            
                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('master.tanah-mentah.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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
    
    /*$(".mask-pbb").inputmask({
        "mask": "99.99.999.999.999-9999.9"
    });*/
    Inputmask({
        "mask" : "99.99.999.999.999-9999.9"
    }).mask(".mask-pbb");
});


</script>
@endsection