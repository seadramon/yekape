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
                    <h3 class="card-title">Data Customer</h3>
                    <div class="card-toolbar">
                        <a href="{{route('master.customer.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
                    </div>
                </div>

                <div class="card-body py-5">
                    <table id="tabel_master_driver" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telp1</th>
                                <th>Jenis Kelamin</th>
                                <th>No KTP</th>
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
	            ajax: "{{ route('master.customer.data') }}",
	            columns: [
	                {data: 'id', name: 'id', defaultContent: '-'},
	                {data: 'nama', name: 'nama', defaultContent: '-'},
	                {data: 'alamat', name: 'alamat', defaultContent: '-'},
	                {data: 'telp_1', name: 'telp_1', defaultContent: '-'},
	                {data: 'jenis_kelamin', name: 'jenis_kelamin', defaultContent: '-'},
	                {data: 'no_ktp', name: 'no_ktp', defaultContent: '-'},
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
		if (confirm("Delete Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('master/tanah-kavling/destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_master_driver').DataTable().ajax.url("{{ route('master.tanah-kavling.data') }}").load();
					}
				}
			});
		}
	});
</script>
@endsection