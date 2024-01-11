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
					<div class="row">
						<div class="col-12">
							<div id="kt_docs_google_chart_column"></div>
						</div>
						<div class="col-6">
							<div id="kavling1"></div>
						</div>
						<div class="col-6">
							<div id="kavling2"></div>
						</div>
						<div class="col-6">
							<div id="kavling3"></div>
						</div>
						<div class="col-6">
							<div id="kavling4"></div>
						</div>
						<div class="col-6">
							<div id="kavling5"></div>
						</div>
						<div class="col-6">
							<div id="kavling6"></div>
						</div>
						<div class="col-6">
							<div id="kavling7"></div>
						</div>
					</div>
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
            generateChart(result, 'kt_docs_google_chart_column');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 1 }).done(function(result){
            generatePieChart(result, 'kavling1');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 2 }).done(function(result){
            generatePieChart(result, 'kavling2');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 3 }).done(function(result){
            generatePieChart(result, 'kavling3');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 4 }).done(function(result){
            generatePieChart(result, 'kavling4');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 5 }).done(function(result){
            generatePieChart(result, 'kavling5');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 6 }).done(function(result){
            generatePieChart(result, 'kavling6');
			div1.release();
        });
		$.get("{{ route('dashboard.kavling-per-cluster') }}", { cluster: 7 }).done(function(result){
            generatePieChart(result, 'kavling7');
			div1.release();
        });
	});

	function generateChart(data_, element){
		// GOOGLE CHARTS INIT
		google.load('visualization', '1', {
			packages: ['corechart', 'bar', 'line']
		});

		google.setOnLoadCallback(function () {
			var data = google.visualization.arrayToDataTable(data_.result);

			var view = new google.visualization.DataView(data);

			var options = {
				title: data_.title,
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

			var chart = new google.visualization.ColumnChart(document.getElementById(element));
			
			chart.draw(view, options);
		});
	}
	
	function generatePieChart(data_, element){
		// GOOGLE CHARTS INIT
		google.load('visualization', '1', {
			packages: ['corechart', 'bar', 'line']
		});

		google.setOnLoadCallback(function () {
			var data = google.visualization.arrayToDataTable(data_.result);

			var view = new google.visualization.DataView(data);

			var options = {
				title: data_.title,
				colors: ['#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#8b0a50']
			};

			var chart = new google.visualization.PieChart(document.getElementById(element));
			chart.draw(data, options);
		});
	}
</script>
@endsection