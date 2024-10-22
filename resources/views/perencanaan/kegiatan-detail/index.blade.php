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
                    <h3 class="card-title">Data Rincian Kegiatan</h3>
                    <div class="card-toolbar">
                        <a href="javascript:void(0)" class="btn btn-light-success me-2" data-bs-toggle="modal" data-bs-target="#exportModal">Export</a>
                    </div>
                </div>

                <div class="card-body py-5">
                    <table id="tabel_master_driver" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>Tahun</th>
								<th>Nama</th>
								<th>Program</th>
								<th>Bagian</th>
                                <th>Total Anggaran</th>
                                <th>Serapan</th>
                                <th>Saldo</th>
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

<!-- EXPORT -->
<div class="modal fade" id="exportModal" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Rekap Monitoring Anggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            	<div class="alert alert-danger" role="alert" id="errMsg">
				  	
				</div>

            	<div class="row">
            		<div class="fv-row form-group col-lg-12 mb-3">
	                    <label for="tahun" class="form-label">Tahun</label>
	                    {!! Form::select('tahun', $tahun, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tahun']) !!}
	                </div>
	                <div class="fv-row form-group col-lg-12 mb-3">
	                    <label for="jenispembayaran" class="form-label">Bagian</label>
	                    {!! Form::select('bagian_id', $bagian, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'bagian']) !!}
	                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="exportBtn">Export to Excel</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
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
	            ajax: "{{ route('perencanaan.kegiatan-detail.data') }}",
	            columns: [
	                {data: 'tahun', name: 'tahun', defaultContent: '-'},
	                {data: 'nama', name: 'nama', defaultContent: '-'},
	                {data: 'program.nama', name: 'program.nama', defaultContent: '-'},
	                {data: 'bagian.nama', name: 'bagian.nama', defaultContent: '-'},
                    {data: 'anggaran', name: 'anggaran', defaultContent: '-', orderable: false, searchable: false},
                    {data: 'serapan', name: 'serapan', defaultContent: '-', orderable: false, searchable: false},
                    {data: 'saldo', name: 'saldo', defaultContent: '-', orderable: false, searchable: false},
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
	    $("#errMsg").hide()
	});

	$('#exportBtn').on('click', function (e) {
    	e.preventDefault()

    	let tahun = $("#tahun").val()
    	let bagian = $("#bagian").val()
    	let bagianLabel = $("#bagian option:selected").text()

    	console.log(bagianLabel)

    	if (tahun != '' && bagian != '') {
	    	let exportExcelUrl = "{{ URL::to('perencanaan/rincian-kegiatan/exportExcel') }}?tahun=" + tahun + '&bagian=' + bagian + '&bagianLabel=' + bagianLabel;
	    	window.open(exportExcelUrl, '_blank');
    	} else {
    		$("#errMsg").show()
    		$("#errMsg").text('Mohon lengkapi filter terlebih dahulu')

    		setTimeout(() => {
                $("#errMsg").hide()
            }, 2000)
    	}
    });

	$('body').on('click', '.delete', function () {
		if (confirm("Are You sure want to delete this Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ route('perencanaan.kegiatan-detail.destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data has been deleted successfully!");

						$('#tabel_teacher').DataTable().ajax.url("{{ route('perencanaan.kegiatan-detail.data') }}").load();
					}
				}
			});
		}
	});

	/*var exampleModal = document.getElementById('imageModal')
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
