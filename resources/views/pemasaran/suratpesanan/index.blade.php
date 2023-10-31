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
                        <a href="{{route('pemasaran.suratpesanan.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
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
	            ajax: "{{ route('pemasaran.suratpesanan.data') }}",
	            columns: [
	                {data: 'no_sp', name: 'no_sp', defaultContent: '-'},
	                {data: 'tgl_sp', name: 'tgl_sp', defaultContent: '-'},
	                {data: 'tipe_pembelian', name: 'tipe_pembelian', defaultContent: '-'},
	                {data: 'customer.nama', name: 'customer.nama', defaultContent: '-'},
	                {data: 'kavling.nama', name: 'kavling.nama', defaultContent: '-'},
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