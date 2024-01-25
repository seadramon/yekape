@extends('layout')

@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            {!! Form::model($data, ['route' => ['keuangan.validasi-kegiatan-detail.store'], 'class' => 'form', 'id' => "form-kegiatan", "method" => "post"]) !!}
            {!! Form::hidden('id', $data->id) !!}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Validasi @if (isset($data))Rincian @else Tambah @endif Kegiatan</h3>
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
                                        <th>Validasi</th>
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
                                                <td style="text-align: right;"><input name="total[]" class="total" type="hidden" value="{{ number_format($total + $nilai_ppn, 2, ',', '.') }}">{{ number_format($total + $nilai_ppn, 2, ',', '.') }}</td>
                                                <td><input name="keterangan[]" class="keterangan" type="hidden" value="{{ $item->keterangan }}">{{ $item->keterangan }}</td>
                                                <td style="text-align: center;">
                                                    @if ($item->status == 'valid')
                                                        <span class="badge badge-success">Valid</span>
                                                    @else
                                                        <div class="form-check form-check-custom form-check-success form-check-solid form-check-lg" style="text-align: center;">
                                                            <input class="form-check-input" type="checkbox" value="1" name="valid[{{ $item->id }}]" />
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif              
                                </tbody>
                                <tfoot style="text-align: right; font-weight: bold;">
                                    <th colspan="6" style="">TOTAL</th>
                                    <th id="grand-total"></th>
                                    <th colspan="2">&nbsp;</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="text-align: right;">
                    <a href="{{ route('keuangan.validasi-kegiatan-detail.index') }}" class="btn btn-light btn-active-light-primary me-2">Kembali</a>
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
<script type="text/javascript">
    $(document).ready(function() {
        calculateTotal();
    });

    $(document).on('submit', '#form-kegiatan', function(event){
        if($(".form-check-input:checked").length == 0){
            alert("belum ada yang divalidasi.");
            event.preventDefault();
            return false;
        }
    });

    function calculateTotal(){
        var total = 0;
        $('.total').each(function(i, obj) {
            total += parseFloat($(obj).val().replaceAll('.', '').replaceAll(',', '.'));
        });
        $("#grand-total").text(formatRupiah(total.toString().replaceAll('.', ',')));
    }
</script>
@endsection
