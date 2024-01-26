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
                    <h3 class="card-title">Monitoring Serapan</h3>
                    <div class="card-toolbar">

                    </div>
                </div>

                <div class="card-body py-5">
                	<div class="row">
                		<div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">Bagian</label>
                            {!! Form::select('bagian', $bagian, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'bagian']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-4 mb-3">
                            <label class="form-label">Tahun</label>
                            {!! Form::select('tahun', $tahun, null, ['class'=>'form-control form-select-solid', 'data-control'=>'select2', 'id'=>'tahun']) !!}
                        </div>
                        <div class="fv-row form-group col-lg-4 mb-3" style="padding-top: 26px;">
                            <a href="javascript: void(0);" class="btn btn-primary" id="tampilkan">Tampilkan Data</a>
                        </div>
                	</div>
                </div>

            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-8" id="box2">
        <!-- Show List Serapan Here -->
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

    .table {
      border: 1px solid black;
      width: 100%;
    }

    .table thead th {
        font-weight: bold !important;
        border-top: 1px solid #000!important;
        border-bottom: 1px solid #000!important;
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }

    .table td {
      border-left: 1px solid #000;
      border-right: 1px solid #000;
      /*border-top: 1px solid #000!important;*/
    }

    .pxl-5 {
        padding-left: 10px !important;
    }
    .pxr-5 {
        padding-right: 10px !important;
    }

    .b-right {
        border-right: 1px solid #000!important;
    }
    .b-top {
        border-top: 1px solid #000!important;
    }

    .txtheader {
        font-weight: bold;text-align: center;vertical-align: middle;
    }
    .txtright {
        text-align: right !important;
    }
</style>
@endsection
@section('js')
<script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
<script type="text/javascript">	

var target = document.querySelector("#kt_app_body");
            
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading data...</div>',
});

$(document).ready(function() {
});

$("#tampilkan").click(function() {
	let data = {
	    '_token': '{{ csrf_token() }}', 
	    'bagian': $('#bagian').val(), 
	    'tahun': $('#tahun').val()
	};
	
	$.ajax({
	    url: "{{ route('monitoring.serapan.data') }}",
	    type: "POST",
	    data: data,
	    dataType: 'json',
	    beforeSend: function() {
	        blockUI.block();
	    },
	    complete: function() {
	        blockUI.release();
	    },
	    success: function(result) {
	        $('#box2').html(result.html);

	        box2();
	    },
	    error: function(result) {
	    }
	});
})

function box2() {

}
</script>
@endsection
