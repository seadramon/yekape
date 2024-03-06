@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['master.customer.store', $data->id], 'class' => 'form', 'id' => "form-kavling", 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                {!! Form::hidden('id', $data->id) !!}
            @else
                {!! Form::open(['url' => route('master.customer.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kavling", 'enctype' => 'multipart/form-data']) !!}
            @endif

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif Customer</h3>
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
                        <div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">No. KTP</label>
                            {!! Form::text('no_ktp', null, ['class'=>'form-control', 'id'=>'no_ktp', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">No. KK</label>
                            {!! Form::text('no_kk', null, ['class'=>'form-control', 'id'=>'no_kk', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">No. NPWP</label>
                            {!! Form::text('no_npwp', null, ['class'=>'form-control', 'id'=>'no_npwp', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-12 mb-3">
                            <label class="form-label">Nama</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            {!! Form::text('tempat_lahir', null, ['class'=>'form-control', 'id'=>'tempat_lahir', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            {!! Form::text('tanggal_lahir', null, ['class'=>'form-control kt-datepicker', 'id'=>'tanggal_lahir', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Agama</label>
                            {!! Form::select('agama', $agama, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'agama']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            {!! Form::select('jenis_kelamin', $jk, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'jenis_kelamin']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat</label>
                            {!! Form::textarea('alamat', null, ['class'=>'form-control', 'rows'=>'3', 'id'=>'alamat', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kelurahan</label>
                            {!! Form::text('kelurahan', null, ['class'=>'form-control', 'id'=>'kelurahan', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kecamatan</label>
                            {!! Form::text('kecamatan', null, ['class'=>'form-control', 'id'=>'kecamatan', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kota/Kab</label>
                            {!! Form::text('kota', null, ['class'=>'form-control', 'id'=>'kota', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Telepon 1</label>
                            {!! Form::text('telp_1', null, ['class'=>'form-control', 'id'=>'telp_1', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Telepon 2</label>
                            {!! Form::text('telp_2', null, ['class'=>'form-control', 'id'=>'telp_2', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat Domisili</label>
                            {!! Form::textarea('alamat_domisili', null, ['class'=>'form-control', 'rows'=>'3', 'id'=>'alamat_domisili', 'autocomplete'=>'off']) !!}
                        </div>

                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nama Pajak</label>
                            {!! Form::text('nama_pajak', null, ['class'=>'form-control', 'id'=>'nama_pajak', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Alamat Pajak</label>
                            {!! Form::text('alamat_pajak', null, ['class'=>'form-control', 'rows'=>'3', 'id'=>'alamat_pajak', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Kota Pajak</label>
                            {!! Form::text('kota_pajak', null, ['class'=>'form-control', 'id'=>'kota_pajak', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Email</label>
                            {!! Form::text('email', null, ['class'=>'form-control', 'id'=>'email', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Pekerjaan</label>
                            {!! Form::text('pekerjaan', null, ['class'=>'form-control', 'id'=>'pekerjaan', 'autocomplete'=>'off']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            &nbsp;
                        </div>


                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">
                                Upload KTP Suami
                            </label>
                            {!! Form::file('file_ktp_suami', ['class' => 'form-control', 'id' => 'ktp_suami']) !!}

                            @if (isset($data->file_ktp_suami))
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File KTP Suami" data-bs-image="{{asset($data->file_ktp_suami)}}">(Show KTP Suami)</a>
                            @endif
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Upload KTP Istri</label>
                            {!! Form::file('file_ktp_istri', ['class' => 'form-control', 'id' => 'ktp_istri']) !!}

                            @if (isset($data->file_ktp_istri))
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File KTP Istri" data-bs-image="{{asset($data->file_ktp_istri)}}">(Show KTP Istri)</a>
                            @endif
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Upload KK</label>
                            {!! Form::file('file_kk', ['class' => 'form-control', 'id' => 'kk']) !!}

                            @if (isset($data->file_kk))
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File KK" data-bs-image="{{asset($data->file_kk)}}">(Show KK)</a>
                            @endif
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Upload NPWP</label>
                            {!! Form::file('file_npwp', ['class' => 'form-control', 'id' => 'npwp']) !!}

                            @if (isset($data->file_npwp))
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File NPWP" data-bs-image="{{asset($data->file_npwp)}}">(Show NPWP)</a>
                            @endif
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Upload SK</label>
                            {!! Form::file('file_sk', ['class' => 'form-control', 'id' => 'sk']) !!}

                            @if (isset($data->file_sk))
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-title="File SK" data-bs-image="{{asset($data->file_sk)}}">(Show SK)</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('master.customer.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
                    <input type="submit" class="btn btn-success" id="btn-submit" value="Simpan">
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
    $('#perkiraan_id').select2({
        placeholder: "Pilih Perkiraan",
        allowClear: true
    });

    var exampleModal = document.getElementById('imageModal')
    exampleModal.addEventListener('show.bs.modal', function (event) {

        var button = event.relatedTarget
        var title = button.getAttribute('data-bs-title')
        var image = button.getAttribute('data-bs-image')

        var modalTitle = exampleModal.querySelector('.modal-title')
        var modalBodyInput = exampleModal.querySelector('.modal-body img')

        modalTitle.textContent = title
        $('#fileImage').attr('src', image)
    })
});
</script>
@endsection
