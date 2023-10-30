@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['master.cluster.store', $data->id], 'class' => 'form', 'id' => "form-kavling", 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id', $data->id) !!}
            @else
                {!! Form::open(['url' => route('master.cluster.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kavling", 'enctype' => 'multipart/form-data']) !!}
            @endif

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Cluster</h3>
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

                        <div class="form-group col-lg-6 mb-3">
                            <label class="form-label">Tanah Mentah</label>
                            {!! Form::select('tanah_mentah_id', $tanahmentah, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tanah_mentah_id']) !!}
                        </div>

                        <div class="form-group col-lg-6 mb-3">
                            <label class="form-label">Lokasi</label>
                            {!! Form::select('lokasi', $lokasi, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'lokasi']) !!}
                        </div>
                    </div>
                </div>
            
                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('master.cluster.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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
    $('#tanah_mentah_id').select2({
        placeholder: "Pilih Tanah Mentah",
        allowClear: true
    });

    $('#lokasi').select2({
        placeholder: "Pilih Lokasi",
        allowClear: true
    });
});


</script>
@endsection