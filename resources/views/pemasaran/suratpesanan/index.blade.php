@extends('layout')
@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Surat Pesanan Rumah</h3>
                    <div class="card-toolbar">
                        @if (in_array('add', json_decode(session('ACTION_MENU_' . auth()->user()->id))))
                            <a href="{{route('pemasaran.suratpesanan.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
                        @endif
                        &nbsp;
                        @if (in_array('export', json_decode(session('ACTION_MENU_' . auth()->user()->id))))
                            <a href="javascript:void(0)" class="btn btn-light-success" data-bs-toggle="modal" data-bs-target="#exportModal">Export</a>
                        @endif
                    </div>
                </div>

                <div class="card-body py-5">
                	<div class="row">
                		<div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Tipe Pembelian</label>
                            {!! Form::select('tipe_pembelian', $tipe, null, ['class'=>'form-control form-select-solid', 'required', 'data-control'=>'select2', 'id'=>'tipe_pembelian']) !!}
                        </div>
                	</div>
                    <table id="tabel_master_driver" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>Nomor</th>
                                <th>Tanggal SP</th>
                                <th>Tipe SP</th>
                                <th>Customer</th>
                                <th>Kavling</th>
                                <th>Status</th>
                                <th>Menu</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
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

<!-- EXPORT -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal_export">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Export to Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <input type="hidden" name="id" id="idspr"> -->
                <div class="mb-3">
                    <label for="periode" class="form-label">Periode</label>
                    <input type="text" name="periode" class="form-control" id="periode">
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <select class="form-select" name="lokasi" id="lokasi">
                        <option value="">Pilih Lokasi</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="gresik">Gresik</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="exportBtn">Export</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sppk" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="modal_sppk_header">
                <!--begin::Modal title-->
                <h2>Input Data SPPK</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Form-->
            <!--begin::Modal body-->
			{!! Form::open(['url' => route('pemasaran.suratpesanan.sppk'), 'class' => 'form', 'method' => 'post', 'id' => "form-spr"]) !!}
            <div class="modal-body px-lg-10">
                <!--begin::Scroll-->
                {{-- <div class="scroll-y me-n7 pe-7" id="modal_sppk_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal_sppk_header" data-kt-scroll-wrappers="#modal_sppk_scroll" data-kt-scroll-offset="300px">
                    
                </div> --}}
                <!--end::Scroll-->
				<input type="hidden" name="id" id="modal_id">
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="form-label">Bank KPR</label>
                        {!! Form::text('bank_kpr', "", ['class'=>'form-control modal-text', 'id'=>'modal_bank_kpr']) !!}
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label">No SPPK</label>
                        {!! Form::text('no_sppk', "", ['class'=>'form-control modal-text', 'id'=>'modal_no_sppk']) !!}
                    </div>
                </div>
            </div>
            <!--end::Modal body-->

            <!--begin::Modal footer-->
            <div class="modal-footer flex-right">
                <button type="submit" id="modal_sppk_submit" class="btn btn-primary">
                    <span class="indicator-label" id="modal_sppk_btn">Simpan</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
@endsection
@section('css')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
<style>
    .custom-form {
        display: flex;
    }
    .custom-label {
        display: flex; 
        align-items: center;
        margin-bottom: 0px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
@section('js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
	"use strict";

	// Class definition
	var KTDatatablesServerSide = function () {
	    // Shared variables
	    var table;
	    var dt;

	    // Private functions
	    var initDatatable = function () {
	        dt = $("#tabel_master_driver").DataTable({
				language: {
  					lengthMenu: "Show _MENU_",
 				},
 				dom:
					"<'row'" +
					"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
					"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
					">" +

					"<'table-responsive'tr>" +

					"<'row'" +
					"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
					"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
					">",
	            searchDelay: 500,
	            processing: true,
	            serverSide: true,
	            order: [[0, 'desc']],
	            stateSave: true,
	            ajax: "{{ route('pemasaran.suratpesanan.data') }}",
	            columns: [
	                {data: 'no_sp', name: 'no_sp', defaultContent: '-'},
	                {data: 'tgl_sp', name: 'tgl_sp', defaultContent: '-'},
	                {data: 'tipe_pembelian', name: 'tipe_pembelian', defaultContent: '-'},
	                {data: 'customer.nama', name: 'customer.nama', defaultContent: '-'},
	                {data: 'kavling.kode_kavling', name: 'kavling.nama', defaultContent: '-'},
	                {data: 'status', orderable: false, searchable: false},
	                {data: 'menu', orderable: false, searchable: false}
	            ],
	        });

	        table = dt.$;
	    }
	    
	    // Public methods
	    return {
	        init: function () {
	            initDatatable();
	        }
	    }
	}();

	// On document ready
	KTUtil.onDOMContentLoaded(function () {
	    KTDatatablesServerSide.init();
	});

	$("#tipe_pembelian").change(function(){
        var id = $('#tipe_pembelian option:selected').val();
        var url = "{{ url('pemasaran/suratpesanan/loadData') }}?tipe_pembelian=" + id;
        // alert(url);
		$('#tabel_master_driver').DataTable().ajax.url(url).load();
    });

    $("#periode").datepicker({
        format: "yyyymm",
        viewMode: "months", 
        minViewMode: "months"
    });

    $('#exportBtn').on('click', function (e) {
    	e.preventDefault()

    	let periode = $("#periode").val()
    	let lokasi = $("#lokasi").val()

    	let exportExcelUrl = "{{ URL::to('pemasaran/suratpesanan/exportExcel') }}?periode=" + periode + '&lokasi=' + lokasi;
    	window.open(exportExcelUrl, '_blank');
    });

    $('body').on('click', '.exportSpr', function () {
    	var id = $(this).data('id')

    	$("#idspr").val(id)
    });

    $('body').on('click', '.input-sppk', function () {
		$("#modal_id").val($(this).attr('data-id'));
		$("#modal_bank_kpr").val($(this).attr('data-bank'));
		$("#modal_no_sppk").val($(this).attr('data-sppk'));
		$('#modal_sppk').modal('toggle');
    });

	$('body').on('click', '.delete', function () {
		if (confirm("Delete Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('pemasaran/suratpesanan/destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_master_driver').DataTable().ajax.url("{{ route('pemasaran.suratpesanan.data') }}").load();
					}
				}
			});
		}
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

</script>
@endsection