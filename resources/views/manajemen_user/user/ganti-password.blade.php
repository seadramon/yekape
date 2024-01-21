@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            {!! Form::model($data, ['route' => ['manajemen-user.user.ganti-password', $data->id], 'class' => 'form', 'id' => "form-ssh", "method" => "post"]) !!}
            {!! Form::hidden('id', $data->id) !!}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Ganti Passwrod</h3>
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
                            <label class="form-label">Name</label>
                            {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'name', 'autocomplete'=>'off', 'required', "readonly"]) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Username</label>
                            {!! Form::text('username', null, ['class'=>'form-control', 'id'=>'username', 'autocomplete'=>'off', 'required', "readonly"]) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            {!! Form::password('password', ['class'=>'form-control', 'id'=>'password', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Ulangi Password Baru</label>
                            {!! Form::password('re_password', ['class'=>'form-control', 'id'=>'re-password', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('manajemen-user.user.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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
