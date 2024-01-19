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
                    <h3 class="card-title">Monitoring Kavling</h3>
                    <div class="card-toolbar">

                    </div>
                </div>

                <div class="card-body py-5">
                	<div class="row">
                		<div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">Lokasi</label>
                            {!! Form::select('lokasi', $lokasi, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'lokasi']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">Cluster</label>
                            {!! Form::select('cluster', $cluster, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'cluster']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">Status Kavling</label>
                            {!! Form::select('status', $status, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'status']) !!}
                        </div>
                	</div>

                    <table id="tabel_master_driver" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>Kode Kavling</th>
                                <th>NO SPR</th>
                                <th>Letak</th>
                                <th>Luas Tanah</th>
                                <th>Status Kavling</th>
                                <th>No PBB</th>
                                <th>No SHGB</th>
                                <th>Masa Berlaku</th>
                                <th>No IMB</th>
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
	            ajax: "{{ route('monitoring.stokkavling.data') }}",
	            columns: [
	                {data: 'kode_kavling', name: 'kode_kavling', defaultContent: '-'},
	                {data: 'spr.no_sp', name: 'spr.no_sp', defaultContent: '-', orderable: false, searchable: false},
	                {data: 'letak', name: 'letak', defaultContent: '-'},
	                {data: 'luas_tanah', name: 'luas_tanah', defaultContent: '-', render: $.fn.dataTable.render.number( '.', ',', 0, '' )},
	                {data: 'status', name: 'status', defaultContent: '-', orderable: false, searchable: false},
	                {data: 'no_pbb', name: 'no_pbb', defaultContent: '-'},
	                {data: 'no_shgb', name: 'no_shgb', defaultContent: '-'},
	                {data: 'tgl_sertifikat', name: 'tgl_sertifikat', defaultContent: '-'},
	                {data: 'no_imb', name: 'no_imb', defaultContent: '-'},
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

	$("#lokasi").change(function(){
        var lokasi = $('#lokasi option:selected').val();
        var cluster = $('#cluster option:selected').val();
        var status = $('#status option:selected').val();

        var url = "{{ url('monitoring/stokkavling/data') }}?lokasi=" + lokasi + "&cluster=" + cluster + "&status=" + status;
		$('#tabel_master_driver').DataTable().ajax.url(url).load();
    });

    $("#cluster").change(function(){
        var lokasi = $('#lokasi option:selected').val();
        var cluster = $('#cluster option:selected').val();
        var status = $('#status option:selected').val();

        var url = "{{ url('monitoring/stokkavling/data') }}?lokasi=" + lokasi + "&cluster=" + cluster + "&status=" + status;
		$('#tabel_master_driver').DataTable().ajax.url(url).load();
    });

    $("#status").change(function(){
        var lokasi = $('#lokasi option:selected').val();
        var cluster = $('#cluster option:selected').val();
        var status = $('#status option:selected').val();

        var url = "{{ url('monitoring/stokkavling/data') }}?lokasi=" + lokasi + "&cluster=" + cluster + "&status=" + status;
		$('#tabel_master_driver').DataTable().ajax.url(url).load();
    });

	/*$('body').on('click', '.delete', function () {
		if (confirm("Are You sure want to delete this Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ route('karyawan.destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data has been deleted successfully!");

						$('#tabel_teacher').DataTable().ajax.url("{{ route('karyawan.data') }}").load();
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
	})*/

</script>
@endsection
