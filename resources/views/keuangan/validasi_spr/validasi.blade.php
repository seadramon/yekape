@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            {!! Form::model($data, ['route' => 'keuangan.validasi-spr.store', 'class' => 'form', 'id' => "form-spr", 'enctype' => 'multipart/form-data']) !!}
            {!! Form::hidden('id', $data->id) !!}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Validasi Surat Pesanan</h3>
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
                        <div class="fv-row form-group col-lg-12 mb-3">
                            <label class="form-label">Booking Fee</label>
                            {!! Form::select('booking', $booking, $data->booking_fee_id ?? null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'booking']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3 @if(!isset($data)) hidden @endif">
                            <label class="form-label">Nomor SP</label>
                            {!! Form::text('no_sp', null, ['class'=>'form-control', 'id'=>'no_sp', 'autocomplete'=>'off', 'required', 'readonly' => 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tanggal SP</label>
                            {!! Form::text('tgl_sp', date('Y-m-d'), ['class'=>'form-control kt-datepicker', 'id'=>'tgl_sp', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tipe Pembelian</label>
                            {!! Form::select('tipe_pembelian', $tipe, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'tipe_pembelian', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jenis</label>
                            {!! Form::select('jenis_pembeli', $jenis, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'jenis_pembeli', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Customer</label>
                            {!! Form::select('customer_id', $customer, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'customer_id', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kavling</label>
                            {!! Form::select('kavling_id', $kavling, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'kavling_id', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Bank Pemberi KPR</label>
                            {!! Form::text('bank_kpr', null, ['class'=>'form-control', 'id'=>'bank_kpr', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Harga Jual</label>
                            {!! Form::text('harga_jual', null, ['class'=>'form-control currency', 'id'=>'harga_jual', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Total Uang Muka</label>
                            {!! Form::text('rp_uangmuka', null, ['class'=>'form-control currency', 'id'=>'rp_uangmuka', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Pembayaran UM 1</label>
                            {!! Form::text('rp_angsuran', null, ['class'=>'form-control currency', 'id'=>'rp_angsuran', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Lama Angsuran UM</label>
                            {!! Form::text('lm_angsuran', null, ['class'=>'form-control currency', 'id'=>'lm_angsuran', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">No SPPPK</label>
                            {!! Form::text('no_sppk', null, ['class'=>'form-control', 'id'=>'no_sppk', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Rencana Realisasi</label>
                            {!! Form::text('rencana_ajb', null, ['class'=>'form-control kt-datepicker', 'id'=>'rencana_ajb', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Lama Pembangunan</label>
                            {!! Form::text('masa_bangun', null, ['class'=>'form-control', 'id'=>'masa_bangun', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Mulai/Selesai Pembangunan</label>
                            {!! Form::text('range_pembangunan', null, ['class'=>'form-control kt-daterangepicker', 'id'=>'range_pembangunan', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('keuangan.validasi-spr.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
                    <input type="submit" class="btn btn-success" id="btn-submit" value="Validasi">
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Content container-->

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('assets/img/empty.jpg') }}" id="fileImage" width="300px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
