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
                    <h3 class="card-title">Data Pengajuan Kegiatan</h3>
					<div class="card-toolbar">
						@if (in_array('add', json_decode(session('ACTION_MENU_' . auth()->user()->id))))
							<a href="{{route('keuangan.pengajuan-kegiatan.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Pengajuan</a>
						@endif
                    </div>
                </div>

                <div class="card-body py-5">
					<div class="row">
                		<div class="fv-row form-group col-lg-2 mb-3">
                            <label class="form-label">Bagian</label>
                            {!! Form::select('bagian', $bagian, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'bagian']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-2 mb-3">
                            <label class="form-label">Tahun</label>
                            {!! Form::select('tahun', $tahun, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tahun']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-2 mb-3">
                            <label class="form-label">Status</label>
                            {!! Form::select('status', $status, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'status']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-2 mb-3" style="padding-top: 26px;">
                            <button class="btn btn-primary" id="filter">Filter</button>
                        </div>
                	</div>
                    <table id="tabel" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>Tahun</th>
                                <th>Bagian</th>
								<th>Kode</th>
								<th>Nama</th>
								<th>Jenis</th>
                                <th>Nilai</th>
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
@endsection
@section('js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script type="text/javascript">
	"use strict";

	$(document).ready(function () {
		$("#filter").click(function(){
            var datatableUrl = "{{ route('keuangan.pengajuan-kegiatan.data') }}?" + getParam();
            $('#tabel').DataTable().ajax.url(datatableUrl).load();
        });
	});

	// Class definition
	var KTDatatablesServerSide = function () {
	    // Shared variables
	    var table;
	    var dt;

	    // Private functions
	    var initDatatable = function () {
	        dt = $("#tabel").DataTable({
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
	            ajax: "{{ route('keuangan.pengajuan-kegiatan.data') }}?" + getParam(),
	            columns: [
                    {data: 'tahun', name: 'tahun', defaultContent: '-'},
                    {data: 'bagian.nama', name: 'bagian.nama', defaultContent: '-'},
	                {data: 'kode', name: 'kode', defaultContent: '-'},
	                {data: 'nama', name: 'nama', defaultContent: '-'},
	                {data: 'jenis', name: 'jenis', defaultContent: '-'},
                    {data: 'nilai', name: 'nilai', defaultContent: '-'},
                    {data: 'status', name: 'status', defaultContent: '-'},
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

	$('body').on('click', '.delete', function () {
		if (confirm("Are You sure want to delete this Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ route('keuangan.pengajuan-kegiatan.destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data has been deleted successfully!");

						$('#tabel_teacher').DataTable().ajax.url("{{ route('keuangan.pengajuan-kegiatan.data') }}").load();
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

	function getParam(){
        var bagian = $("#bagian").val();
        var tahun = $("#tahun").val();
        var status = $("#status").val();
        return $.param({bagian, tahun, status});
    }

</script>
@endsection
