@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['karyawan.update', $data->id], 'class' => 'form', 'id' => "form-kavling", 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id', $data->id) !!}
                @method('PUT')
            @else
                {!! Form::open(['url' => route('karyawan.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kavling", 'enctype' => 'multipart/form-data']) !!}
            @endif
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Karyawan</h3>
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
                            <label class="form-label">NIK</label>
                            {!! Form::text('nik', null, ['class'=>'form-control', 'id'=>'nik', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nama</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat KTP</label>
                            {!! Form::text('alamat_ktp', null, ['class'=>'form-control', 'id'=>'alamat_ktp', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat Domisili</label>
                            {!! Form::text('alamat_domisili', null, ['class'=>'form-control', 'id'=>'alamat_domisili', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            {!! Form::text('tempat_lahir', null, ['class'=>'form-control', 'id'=>'tempat_lahir', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            {!! Form::text('tgl_lahir', $data ? date('d-m-Y', strtotime($data->tgl_lahir)) : null, ['class'=>'form-control kt-datepicker', 'id'=>'tgl_lahir', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">No HP</label>
                            {!! Form::text('no_hp', null, ['class'=>'form-control', 'id'=>'no_hp', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            {!! Form::select('jenis_kelamin', $genders, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis_kelamin']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jabatan</label>
                            {!! Form::select('jabatan_id', $jabatans, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jabatan_id']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Upload foto</label>
                            {!! Form::file('file', ['class' => 'form-control', 'id' => 'file', "accept" => "image/jpg,image/png, image/jpeg"]) !!}
                            @if ($data && ($data->data['foto'] ?? false))
                                <label class="form-label">Foto</label>
                                <img src="{{ route('api.gambar', ['kode' => str_replace('/', '&', $data->data['foto'])]) }}" width="400">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('karyawan.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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

    });


</script>
@endsection
