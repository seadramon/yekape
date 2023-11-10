@extends('layout')
@section('content')
<!--begin::Content container-->
<div id="kt_content_container" class="container-xxl">
    <!--begin::Row-->
    <div class="row g-5 g-xl-8">
        <!--begin::Col-->
        <div class="col-12 mb-md-5 mb-xl-10">
            <div class="card shadow-sm" id="div1">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                    {{-- <div class="card-toolbar">
                        <a href="{{route('karyawan.create')}}" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Tambah Data</a>
                    </div> --}}
                </div>
                <div class="card-body py-5">
					<div id="kt_docs_google_chart_column"></div>
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
<script src="//www.google.com/jsapi"></script>
<script type="text/javascript">
	var target = document.querySelector("#div1");
	var div1 = new KTBlockUI(target);
	$(document).ready(function () {
		div1.block();
		$.get("{{ route('dashboard.spr-monthly') }}", { }).done(function(result){
            generateChart(result);
			div1.release();
        });
	});

	function generateChart(data_){
		// GOOGLE CHARTS INIT
		google.load('visualization', '1', {
			packages: ['corechart', 'bar', 'line']
		});

		google.setOnLoadCallback(function () {
			var data = google.visualization.arrayToDataTable(data_);

			var view = new google.visualization.DataView(data);

			var options = {
				title: "Data Spr Per bulan di Tahun 2023",
				focusTarget: 'category',
				height: 400,
				hAxis: {
					title: 'Bulan',
					// format: 'h:mm a',
					// viewWindow: {
					// 	min: [7, 30, 0],
					// 	max: [17, 30, 0]
					// },
				},
				vAxis: {
					title: 'Total'
				},
				colors: ['#6e4ff5', '#fe3995']
			};

			var chart = new google.visualization.ColumnChart(document.getElementById('kt_docs_google_chart_column'));
			
			chart.draw(view, options);
		});
	}
</script>
@endsection