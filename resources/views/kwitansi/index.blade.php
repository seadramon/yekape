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
                    <h3 class="card-title">Data Kwitansi</h3>
                    <div class="card-toolbar">
                        <a href="{{route('kwitansi.create', ['tipe' => 'KWT'])}}" class="btn btn-light-primary me-2">Buat KWT</a>
                        <a href="{{route('kwitansi.create', ['tipe' => 'KWU'])}}" class="btn btn-light-warning me-2">Buat KWU</a>
                        <a href="javascript:void(0)" class="btn btn-light-success me-2" data-bs-toggle="modal" data-bs-target="#exportModal">Export</a>
                    </div>
                </div>

                <div class="card-body py-5">
                    <table id="tabel_master_driver" class="table table-row-bordered gy-5" style="vertical-align: middle;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-muted">
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Keterangan</th>
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
                <h5 class="modal-title" id="exportModalLabel">Rekap Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            	<div class="alert alert-danger" role="alert" id="errMsg">
				  	
				</div>

            	<div class="row">
            		<div class="fv-row form-group col-lg-12 mb-3">
	                    <label for="periode" class="form-label">Tanggal Kwitansi</label>
	                    <input type="text" name="periode" class="form-control" id="periode">
	                </div>
                    <div class="fv-row form-group col-lg-6 mb-3">
                    	<label for="jeniskwitansi" class="form-label">Jenis Kwitansi</label>
                    	<select class="form-select" name="jeniskwitansi" id="jeniskwitansi">
                    	    <option value="">Pilih Jenis Kwitansi</option>
                    	    <option value="KWU">KWU</option>
                    	    <option value="KWT">KWT</option>
                    	</select>
                    </div>
	                <div class="fv-row form-group col-lg-6 mb-3">
	                    <label for="jenispenerimaan" class="form-label">Jenis Penerimaan</label>
	                    <select class="form-select" name="jenispenerimaan" id="jenispenerimaan">
	                        <option value="">Pilih Jenis Penerimaan</option>
	                    </select>
	                </div>
	                <div class="fv-row form-group col-lg-12 mb-3">
	                    <label for="periode" class="form-label">Nama</label>
	                    <select class="form-control" name="customer" id="customer"></select>
	                </div>
	                <div class="fv-row form-group col-lg-6 mb-3">
	                    <label for="jenispembayaran" class="form-label">Jenis Pembayaran</label>
	                    <select class="form-select" name="jenispembayaran" id="jenispembayaran">
	                        <option value="">Pilih Jenis Pembayaran</option>
	                        <option value="cash">Cash</option>
	                        <option value="transfer">Transfer</option>
	                    </select>
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
	            order: [[1, 'desc']],
	            stateSave: true,
	            ajax: "{{ route('kwitansi.data') }}",
	            columns: [
	                {data: 'nomor', name: 'nomor', defaultContent: '-'},
	                {data: 'tanggal', name: 'tanggal', defaultContent: '-'},
	                {data: 'nama', name: 'nama', defaultContent: '-'},
	                {data: 'keterangan', name: 'keterangan', defaultContent: '-'},
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

	$("#periode").flatpickr({
	    altInput: true,
	    altFormat: "j F Y",
	    dateFormat: "Y-m-d",
	    mode: "range"
	});

	$("#jeniskwitansi").on('change', function(e) {
		if ($(this).val() == 'KWT') {
			$("#jenispenerimaan")
			.empty()
			.append(
            	'<option value="">Pilih Jenis Penerimaan</option><option value="um">Uang Muka</option><option value="tambahan">Tambahan</option>'
            )
		} else if ($(this).val() == 'KWU') {
			$("#jenispenerimaan")
			.empty()
			.append(
            	'<option value="">Pilih Jenis Penerimaan</option><option value="nup">NUP</option><option value="utj">Booking Fee</option><option value="jampel">Jampel</option>'
            )
		} else {
			$("#jenispenerimaan")
			.empty()
			.append(
            	'<option value="">Pilih Jenis Penerimaan</option>'
            )
		}
	})

    $('#exportBtn').on('click', function (e) {
    	e.preventDefault()

    	let periode = $("#periode").val()
    	let jeniskwitansi = $("#jeniskwitansi").val()
    	let jenispenerimaan = $("#jenispenerimaan").val()
    	let jenispembayaran = $("#jenispembayaran").val()
    	let customer = $("#customer").val()

    	/*if (periode != '' && jeniskwitansi != '' &&  jenispenerimaan != '' && jenispembayaran != '' && customer != '') {*/
	    	let exportExcelUrl = "{{ URL::to('kwitansi/exportExcel') }}?periode=" + periode + '&jenis=' + jeniskwitansi + '&jenispenerimaan=' + jenispenerimaan + '&jenispembayaran=' + jenispembayaran + '&customer=' + customer;
	    	window.open(exportExcelUrl, '_blank');
    	/*} else {
    		$("#errMsg").show()
    		$("#errMsg").text('Mohon lengkapi filter terlebih dahulu')

    		setTimeout(() => {
                $("#errMsg").hide()
            }, 2000)
    	}*/
    });

    $('body').on('click', '.exportSpr', function () {
    	// TODO HERE
    })

	$('body').on('click', '.delete', function () {
		if (confirm("Are You sure want to delete this Record?") == true) {
			var id = $(this).data('id');

			// ajax
			$.ajax({
				type:"post",
				url: "{{ route('kwitansi.destroy') }}",
				data: {id : id, _token: "{{ csrf_token() }}"},
				success: function(res){
					if (res.result == 'success') {
						flasher.success("Data has been deleted successfully!");

						$('#tabel_master_driver').DataTable().ajax.url("{{ route('kwitansi.data') }}").load();
					}
				}
			});
		}
	});

	$('#customer').select2({
        placeholder: 'Cari...',
        dropdownParent: $('#exportModal'),
        ajax: {
            url: "{{ route('master.customer.search') }}",
            minimumInputLength: 2,
            dataType: 'json',
            cache: true,
            data: params => {
                var query = {
                    search: params.term,
                    type: 'public'
                }

                return query;
            },
            processResults: (data) => {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
        }
    })

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