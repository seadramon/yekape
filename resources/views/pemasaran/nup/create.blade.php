@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            {!! Form::open(['url' => route('pemasaran.nup.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-nup"]) !!}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif NUP</h3>
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
                            <label class="form-label">Tanggal</label>
                            {!! Form::text('tanggal', null, ['class'=>'form-control kt-datepicker', 'id'=>'tanggal', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kavling</label>
                            {!! Form::select('kavling_id', $kavlings, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'kavling']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Customer</label>
                            {!! Form::select('customer_id', $customers, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'customer']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Marketing</label>
                            {!! Form::select('marketing_id', $marketings, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'marketing']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Biaya</label>
                            {!! Form::text('biaya', null, ['class'=>'form-control currency', 'id'=>'biaya', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                    </div>
                </div>
            
                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('pemasaran.nup.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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