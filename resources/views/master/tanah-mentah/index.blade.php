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
                    <h3 class="card-title">List Tanah Mentah</h3>
                    <div class="card-toolbar">
                        <a href="{{route('master.tanah-mentah.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
                    </div>
                </div>

                <div class="card-body py-5">
                	<div class="row">
                		<div class="fv-row form-group col-lg-6 mb-3">
                            <label class="form-label">Perkiraan</label>
                            {!! Form::select('perkiraan_id', $perkiraan, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'perkiraan_id']) !!}
                        </div>
                	</div>
                    <table id="tabel_master_driver" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>No PBB</th>
                                <th>No SHGB</th>
                                <th>Perkiraan</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Luas Tanah</th>
                                <!-- <th>Menu</th> -->
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
	            ajax: "{{ route('master.tanah-mentah.data') }}",
	            columns: [
	                {data: 'no_pbb', name: 'no_pbb', defaultContent: '-'},
	                {data: 'no_shgb', name: 'no_shgb', defaultContent: '-'},
	                {data: 'perkiraan.kd_perkiraan', name: 'perkiraan.kd_perkiraan', defaultContent: '-'},
	                {data: 'nama', name: 'nama', defaultContent: '-'},
	                {data: 'lokasi', name: 'lokasi', defaultContent: '-'},
	                {data: 'luas_tanah', name: 'luas_tanah', defaultContent: '-'},
	                // {data: 'menu', orderable: false, searchable: false}
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

	$("#perkiraan_id").change(function(){
        var id = $('#perkiraan_id option:selected').val();
        var url = "{{ url('master/tanah-mentah/loadData') }}?perkiraan_id=" + id;
        // alert(url);
		$('#tabel_master_driver').DataTable().ajax.url(url).load();
    });

	$('body').on('click', '.delete', function () {
		if (confirm("Delete Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ url('master/tanah-mentah/destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data telah berhasil dihapus!");

						$('#tabel_master_driver').DataTable().ajax.url("{{ route('master.tanah-mentah.data') }}").load();
					}
				}
			});
		}
	});
</script>
@endsection