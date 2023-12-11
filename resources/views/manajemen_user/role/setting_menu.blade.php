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
                    <h3 class="card-title">Setting Menu {{ $role->name }}</h3>
                </div>

                <div class="card-body">
                    <div class="card-body py-3">
                        <input type="text" name="_token" hidden="" value="{{csrf_token()}}">
                        <input type="text" name="id" hidden="" value="{{ $id }}" id="role_id">
                        <div id="kt_docs_jstree_basic"></div>
                    </div>
                    <div class="card-footer" >
                        <button class="btn btn-primary mr-2" id="updateBtn">Update</button>
                        <a href="{{ URL::previous() }}" class="btn btn-secondary">Cancel</a>
                        <a href="{{ route('manajemen-user.role.setting-menu.delete', ['id' =>  $id]) }}" 
                            onClick="return confirm('Are you sure ?')"  class="btn btn-secondary">Remove All Menus</a>
                    </div>
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
<link href="{{ asset('assets/plugins/custom/jstree/jstree.bundle.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{asset('assets/plugins/custom/jstree/jstree.bundle.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $.ajax({
            type: "POST",
            url: "{{ route('manajemen-user.role.setting-menu.tree-data') }}",
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}",
            },
            data: {
                id : $('#role_id').val(),
            },
            success: function(result) {
                $('#kt_docs_jstree_basic').jstree({ 
                    "core" : result, 
                    "plugins": ["types","checkbox"]
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    
        $('#updateBtn').on("click", function(e) { 
    
            var selectedElmsIds = $('#kt_docs_jstree_basic').jstree("get_selected");
            var selectedElmsIds = [];
            var selectedElms = $('#kt_docs_jstree_basic').jstree("get_selected", true);
            $.each(selectedElms, function() {
                selectedElmsIds.push(this.li_attr.val_id);
            });
    
            swal({
                title: "Apakah anda yakin ?",
                text: "Semua menu terpilih akan diperbarui/ditambahkan",
                icon: "success",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('manajemen-user.role.setting-menu.update') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        },
                        data: {
                            data: selectedElmsIds,
                            role_id : $('#role_id').val(),
                        },
                        success: function(result) {
                            // swal("Menu Successfully Update");
                            flasher.success("Data telah berhasil ditambahkan!");
                            setTimeout(function() { 
                                window.location=window.location;
                            },1000);
                            console.log(result);
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                } else {
                    swal("Update Canceled", {
                        icon: "success",
                    }); 
                }
            });
        });
    });

</script>
@endsection
