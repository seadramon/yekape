@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            @if (isset($data))
                {!! Form::model($data, ['route' => ['perencanaan.kegiatan-detail.update', $data->id], 'class' => 'form', 'id' => "form-kegiatan",]) !!}
                {!! Form::hidden('id', $data->id) !!}
                @method('PUT')
            @else
                {!! Form::open(['url' => route('perencanaan.kegiatan.store'), 'class' => 'form', 'method' => 'post', 'id' => "form-kegiatan"]) !!}
            @endif
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">@if (isset($data))Rincian @else Tambah @endif Kegiatan</h3>
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
                            <label class="form-label">Program</label>
                            {!! Form::select('program_id', $program, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'program', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Bagian</label>
                            {!! Form::select('bagian_id', $bagian, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'bagian', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Nama</label>
                            {!! Form::text('nama', null, ['class'=>'form-control', 'id'=>'nama', 'autocomplete'=>'off', 'required', 'readonly']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tahun</label>
                            {!! Form::select('tahun', $tahun, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tahun', 'disabled']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-12 mb-3 mt-2">
                            <button type="button" class="btn btn-light-primary" id="add-kegiatan-detail">
                                <i class="la la-plus"></i>Tambah Komponen
                            </button>
                        </div>
                        <div class="fv-row form-group col-lg-12 mb-3">
                            <table id="tabel_kegiatan_detail" class="table table-row-bordered text-center">
                                <thead>
                                    <tr style="font-weight: bold;">
                                        <th>Perkiraan</th>
                                        <th>Komponen</th>
                                        <th>Harga Satuan</th>
                                        <th>Volume</th>
                                        <th>PPN</th>
                                        <th>Nilai PPN</th>
                                        <th>Total</th>
                                        <th>Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-kegiatan-detail">
                                    @if (isset($data))
                                        @foreach ($data->detail as $item)
                                            @php
                                                $total = $item->harga_satuan * $item->volume;
                                                $nilai_ppn = $total * $item->ppn / 100;
                                            @endphp
                                            <tr style="text-align: center; vertical-align: middle;">
                                                <td><input name="detail_id[]" class="detail_id" type="hidden" value="{{ $item->id }}"><input name="perkiraan[]" class="perkiraan" type="hidden" value="{{ $item->kode_perkiraan }}">{{ $item->kode_perkiraan }}<br>{{$item->perkiraan->keterangan}}</td>
                                                <td><input name="komponen[]" class="komponen" type="hidden" value="{{ $item->komponen_id }}"><input name="komponen_tipe[]" class="komponen_tipe" type="hidden" value="{{ $item->komponen_type }}">{{ $item->komponen->kode}}<br>{{$item->komponen->nama }}</td>
                                                <td style="text-align: right;"><input name="hargasatuan[]" class="hargasatuan" type="hidden" value="{{ number_format($item->harga_satuan, 2, ',', '.') }}">{{ number_format($item->harga_satuan, 2, ',', '.') }}</td>
                                                <td><input name="volume[]" class="volume" type="hidden" value="{{ number_format($item->volume, 0, ',', '.') }}">{{ number_format($item->volume, 0, ',', '.') }}</td>
                                                <td><input name="ppn[]" class="ppn" type="hidden" value="{{ number_format($item->ppn, 0) }}">{{ number_format($item->ppn, 0) }}%</td>
                                                <td style="text-align: right;"><input name="nilaippn[]" class="nilaippn" type="hidden" value="{{ number_format($nilai_ppn, 2, ',', '.') }}">{{ number_format($nilai_ppn, 2, ',', '.') }}</td>
                                                <td style="text-align: right;"><input name="total[]" class="total" type="hidden" value="">{{ number_format($total + $nilai_ppn, 2, ',', '.') }}</td>
                                                <td><input name="keterangan[]" class="keterangan" type="hidden" value="{{ $item->keterangan }}">{{ $item->keterangan }}</td>
                                                <td><button class="btn btn-danger btn-sm delete_kegiatan_detail me-1 mb-1" style="padding: 5px 6px;"><span class="bi bi-trash"></span></button><button class="btn btn-warning btn-sm edit_kegiatan_detail me-1 mb-1" style="padding: 5px 6px;"><span class="bi bi-pencil-square"></span></button></td>
                                            </tr>
                                        @endforeach
                                    @endif              
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('perencanaan.kegiatan-detail.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
                    <input type="submit" class="btn btn-success" id="btn-submit" value="Simpan">
                </div>
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Content container-->
@include('perencanaan.kegiatan-detail.modal_komponen')
@endsection

@section('css')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

    });

    $('#add-kegiatan-detail').on('click', function(){
        resetModalKegiatanDetail()
        $('#modal_kegiatan_detail').modal('toggle');
    });
    $(document).on('click', '.delete_kegiatan_detail', function(event){
        event.preventDefault();
        $(this).parent().parent().remove();
        // calculateTotal();
    });
    $(document).on('click', '.edit_kegiatan_detail', function(event){
        event.preventDefault();
        resetModalKegiatanDetail()

        $(this).parent().parent().addClass('editing');
        $("#modal_for").val("edit");
        $("#modal_id").val($(this).parent().parent().find("input.detail_id").val());
        $("#modal_kegiatan_detail_btn").text("Edit");

        $("#modal_perkiraan").val($(this).parent().parent().find("input.perkiraan").val()).trigger("change");
        $("#modal_komponen").val($(this).parent().parent().find("input.komponen").val()).trigger("change");
        $("#modal_ppn").val($(this).parent().parent().find("input.ppn").val()).trigger("change");
        $("#modal_satuan").val($(this).parent().parent().find("input.satuan").val());
        $("#modal_keterangan").val($(this).parent().parent().find("input.keterangan").val());
        $("#modal_hargasatuan").val($(this).parent().parent().find("input.hargasatuan").val());
        $("#modal_volume").val($(this).parent().parent().find("input.volume").val());
        $("#modal_nilaippn").val($(this).parent().parent().find("input.nilaippn").val());
        $("#modal_hargasatuan").trigger('keyup');
        $("#modal_volume").trigger('keyup');
        $("#modal_nilaippn").trigger('keyup');
        $('#modal_kegiatan_detail').modal('toggle');
        // calculateTotal();
    });

    function resetModalKegiatanDetail(){
        $(".modal-select2").val("").trigger("change");
        $(".modal-text").val("");
        $("#modal_for").val("add");
        $("#modal_id").val("0");
        $("#modal_kegiatan_detail_btn").text("Tambah");
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.form-select-modal-solid').select2({
            dropdownParent: $("#modal_kegiatan_detail")
        });
    });
    $('#modal_komponen').on('change', function(e){
        $("#modal_hargasatuan").val($("#modal_komponen option:selected").attr('data-hargasatuan').replaceAll('.', ','));
        $("#modal_hargasatuan").trigger('keyup');
    });

    $(document).on('change', '#modal_ppn, #modal_volume, #modal_komponen', function(event){
        var harsat = parseFloat($("#modal_komponen option:selected").attr('data-hargasatuan'));
        var vol = parseFloat($("#modal_volume").val().replaceAll('.', '').replaceAll(',', '.'));
        var ppn = parseFloat($("#modal_ppn").val().replaceAll('.', '').replaceAll(',', '.'));
        var total = harsat * vol;
        var nilai_ppn = (total * ppn / 100).toFixed(2).replaceAll('.', ',');
        
        $("#modal_nilaippn").val(nilai_ppn);
        $("#modal_nilaippn").trigger('keyup');
        // calculateTotal();
    });

    $('#modal_kegiatan_detail_submit').on('click', function(e){
        e.preventDefault();
        var data_ = modalKegiatanDetailData();
        // kd_jmember
        var table_row = "<td><input name=\"detail_id[]\" class=\"detail_id\" type=\"hidden\" value=\"" + data_.detail_id + "\"><input name=\"perkiraan[]\" class=\"perkiraan\" type=\"hidden\" value=\"" + data_.perkiraan + "\">" + data_.perkiraan_teks + "</td>" + 
            "<td><input name=\"komponen[]\" class=\"komponen\" type=\"hidden\" value=\"" + data_.komponen + "\"><input name=\"komponen_tipe[]\" class=\"komponen_tipe\" type=\"hidden\" value=\"" + data_.komponen_tipe + "\">" + data_.komponen_teks + "</td>" + 
            "<td style=\"text-align: right;\"><input name=\"hargasatuan[]\" class=\"hargasatuan\" type=\"hidden\" value=\"" + data_.hargasatuan + "\">" + data_.hargasatuan + "</td>" + 
            "<td><input name=\"volume[]\" class=\"volume\" type=\"hidden\" value=\"" + data_.volume + "\">" + data_.volume + "</td>" + 
            "<td><input name=\"ppn[]\" class=\"ppn\" type=\"hidden\" value=\"" + data_.ppn + "\">" + data_.ppn_teks + "</td>" + 
            "<td style=\"text-align: right;\"><input name=\"nilaippn[]\" class=\"nilaippn\" type=\"hidden\" value=\"" + data_.nilaippn + "\">" + data_.nilaippn + "</td>" + 
            "<td style=\"text-align: right;\"><input name=\"total[]\" class=\"total\" type=\"hidden\" value=\"" + data_.total + "\">" + data_.total + "</td>" + 
            "<td><input name=\"keterangan[]\" class=\"keterangan\" type=\"hidden\" value=\"" + data_.keterangan + "\">" + data_.keterangan + "</td>" + 
            "<td><button class=\"btn btn-danger btn-sm delete_kegiatan_detail me-1 mb-1\" style=\"padding: 5px 6px;\"><span class=\"bi bi-trash\"></span></button><button class=\"btn btn-warning btn-sm edit_kegiatan_detail me-1 mb-1\" style=\"padding: 5px 6px;\"><span class=\"bi bi-pencil-square\"></span></button></td>";
        
        if($("#modal_for").val() == "add"){
            $("#tbody-kegiatan-detail").append(
                "<tr style=\"text-align: center; vertical-align: middle;\">" + table_row + "</tr>"
            );
        }else{
            $(".editing").html(table_row);
            $(".editing").removeClass("editing");
        }
        // calculateTotal();
        $('#modal_kegiatan_detail').modal('toggle');
    });

    function modalKegiatanDetailData(){
        var detail_id = $("#modal_id").val();
        var komponen = $("#modal_komponen").val();
        var komponen_tipe = $("#modal_komponen option:selected").attr('data-tipe');
        var komponen_teks = $("#modal_komponen option:selected").text().replaceAll(' | ', '<br>');
        var perkiraan = $("#modal_perkiraan").val();
        var perkiraan_teks = $("#modal_perkiraan option:selected").text().replaceAll(' | ', '<br>');
        var hargasatuan = $("#modal_hargasatuan").val();
        var volume = $("#modal_volume").val();
        var ppn = $("#modal_ppn").val();
        var ppn_teks = $("#modal_ppn option:selected").text();
        var nilaippn = $("#modal_nilaippn").val();
        var keterangan = $("#modal_keterangan").val();

        var harsat = parseFloat(hargasatuan.replaceAll('.', '').replaceAll(',', '.'));
        var vol = parseFloat(volume.replaceAll('.', '').replaceAll(',', '.'));
        var n_ppn = parseFloat(nilaippn.replaceAll('.', '').replaceAll(',', '.'));
        
        return {
            detail_id: detail_id,
            komponen: komponen,
            komponen_teks: komponen_teks,
            komponen_tipe: komponen_tipe,
            perkiraan: perkiraan,
            perkiraan_teks: perkiraan_teks,
            ppn: ppn,
            ppn_teks: ppn_teks,
            hargasatuan: hargasatuan,
            volume: volume,
            nilaippn: nilaippn,
            keterangan: keterangan,
            total: formatRupiah((harsat * vol + n_ppn).toString().replaceAll('.', ',')),
        };
    }
</script>
@endsection
