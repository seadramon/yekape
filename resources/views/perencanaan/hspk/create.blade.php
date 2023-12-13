@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['perencanaan.hspk.update', $data->id], 'class' => 'form', 'id' => "form-ssh",]) !!}
                {!! Form::hidden('id', $data->id) !!}
                @method('PUT')
            @else
                {!! Form::open(['url' => route('perencanaan.hspk.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-ssh"]) !!}
            @endif
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Edit @else Tambah @endif SSH</h3>
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
                        @if (isset($data))
                            <div class="fv-row form-group col-lg-6 mb-3">
                                <label class="form-label">Kode</label>
                                {!! Form::text('kode', null, ['class'=>'form-control', 'id'=>'kode', 'autocomplete'=>'off', 'readonly']) !!}
                            </div>
                        @endif
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nama</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Satuan</label>
                            {!! Form::text('satuan', null, ['class'=>'form-control', 'id'=>'satuan', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Harga</label>
                            {!! Form::text('harga', $data ? number_format($data->harga, 2, ',', '.') : null, ['class'=>'form-control currency', 'id'=>'harga', 'autocomplete'=>'off', 'required']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-12 mb-3">
                            <button type="button" class="btn btn-light-primary" id="add-member">
                                <i class="la la-plus"></i>Tambah Member
                            </button>
                        </div>
                        <div class="fv-row form-group col-lg-12 mb-3">
                            <table id="tabel_detail_member" class="table table-row-bordered text-center">
                                <thead>
                                    <tr style="font-weight: bold;">
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Volume</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-member">
                                    @if (isset($data))
                                        @foreach ($data->detail as $item)
                                            <tr>
                                                <td><input name="member_id[]" class="member_id" type="hidden" value="{{ $item->member_id }}">{{ $data->member->kode }}|{{ $data->member->nama }}</td> 
                                                <td><input name="satuan[]" class="satuan" type="hidden" value="{{ $item->member->satuan }}">{{ $item->member->satuan }}</td> 
                                                <td><input name="hargasatuan[]" class="hargasatuan" type="hidden" value="{{ $item->harga_satuan }}">{{ $item->harga_satuan }}</td> 
                                                <td><input name="volume[]" class="volume" type="hidden" value="{{ $item->volume }}">{{ $item->volume }}</td> 
                                                <td><input name="total[]" class="total" type="hidden" value="{{ $item->total }}">{{ number_format($item->total) }}</td> 
                                                <td><button class="btn btn-danger btn-sm delete_member me-1 mb-1" style="padding: 5px 6px;"><span class="bi bi-trash"></span></button><button class="btn btn-warning btn-sm edit_member" style="padding: 5px 6px;"><span class="bi bi-pencil-square"></span></button></td>
                                            </tr>
                                        @endforeach
                                    @endif              
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('perencanaan.hspk.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
                    <input type="submit" class="btn btn-success" id="btn-submit" value="Simpan">
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Content container-->
@include('perencanaan.hspk.modal_member')
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

    $('#add-member').on('click', function(){
        resetModalMember()
        $('#modal_member').modal('toggle');
    });
    $(document).on('click', '.delete_member', function(event){
        event.preventDefault();
        $(this).parent().parent().remove();
        // calculateTotal();
    });
    $(document).on('click', '.edit_member', function(event){
        event.preventDefault();
        resetModalMember()

        $(this).parent().parent().addClass('editing');
        $("#modal_for").val("edit");
        $("#modal_member_btn").text("Edit");

        $("#modal_member").val($(this).parent().parent().find("input.member_id").val()).trigger("change");
        $("#modal_satuan").val($(this).parent().parent().find("input.satuan").val());
        $("#modal_hargasatuan").val($(this).parent().parent().find("input.hargasatuan").val());
        $("#modal_volume").val($(this).parent().parent().find("input.volume").val());
        $("#modal_hargasatuan").trigger('keyup');
        $('#modal_member').modal('toggle');
        // calculateTotal();
    });

    function resetModalMember(){
        $(".modal-select2").val("").trigger("change");
        $(".modal-text").val("");
        $("#modal_for").val("add");
        $("#modal_member_btn").text("Tambah");
    }

</script>
@endsection
