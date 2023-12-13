<div class="modal fade" id="modal_member" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="modal_member_header">
                <!--begin::Modal title-->
                <h2>Tambah Detail Member</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Form-->
            <!--begin::Modal body-->
            <div class="modal-body px-lg-10">
                <!--begin::Scroll-->
                {{-- <div class="scroll-y me-n7 pe-7" id="modal_member_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#modal_member_header" data-kt-scroll-wrappers="#modal_member_scroll" data-kt-scroll-offset="300px">
                    
                </div> --}}
                <!--end::Scroll-->
                <input type="hidden" id="modal_for" value="add">
                <div class="row">
                    <div class="form-group col-lg-6">
                        <label class="form-label">Member</label>
                        {!! Form::select('modal_member', $member, null, ['class'=>'form-control form-select-modal-solid modal-select2', 'data-control'=>'select2', 'id'=>'modal_member'], $opt_member) !!}
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label">Satuan</label>
                        {!! Form::text('modal_satuan', "", ['class'=>'form-control modal-text', 'id'=>'modal_satuan', 'readonly']) !!}
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label">Harga Satuan</label>
                        {!! Form::text('modal_hargasatuan', "", ['class'=>'form-control currency modal-text', 'id'=>'modal_hargasatuan', 'readonly']) !!}
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label">Volume</label>
                        {!! Form::text('modal_volume', "", ['class'=>'form-control currency modal-text', 'id'=>'modal_volume']) !!}
                    </div>
                </div>
            </div>
            <!--end::Modal body-->

            <!--begin::Modal footer-->
            <div class="modal-footer flex-right">
                <button type="button" id="modal_member_submit" class="btn btn-primary">
                    <span class="indicator-label" id="modal_member_btn">Tambah</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.form-select-modal-solid').select2({
            dropdownParent: $("#modal_member")
        });
    });
    $('#modal_member_submit').on('click', function(e){
        e.preventDefault();
        var data_ = modalMemberData();
        // kd_jmember
        var table_row = "<td><input name=\"member_id[]\" class=\"member_id\" type=\"hidden\" value=\"" + data_.member + "\">" + data_.member_teks + "</td>" + 
            "<td><input name=\"satuan[]\" class=\"satuan\" type=\"hidden\" value=\"" + data_.satuan + "\">" + data_.satuan + "</td>" + 
            "<td><input name=\"hargasatuan[]\" class=\"hargasatuan\" type=\"hidden\" value=\"" + data_.hargasatuan + "\">" + data_.hargasatuan + "</td>" + 
            "<td><input name=\"volume[]\" class=\"volume\" type=\"hidden\" value=\"" + data_.volume + "\">" + data_.volume + "</td>" + 
            "<td><input name=\"total[]\" class=\"total\" type=\"hidden\" value=\"" + data_.total + "\">" + data_.total + "</td>" + 
            "<td><button class=\"btn btn-danger btn-sm delete_member me-1 mb-1\" style=\"padding: 5px 6px;\"><span class=\"bi bi-trash\"></span></button><button class=\"btn btn-warning btn-sm edit_member\" style=\"padding: 5px 6px;\"><span class=\"bi bi-pencil-square\"></span></button></td>";
        
        if($("#modal_for").val() == "add"){
            $("#tbody-member").append(
                "<tr>" + table_row + "</tr>"
            );
        }else{
            $(".editing").html(table_row);
            $(".editing").removeClass("editing");
        }
        // calculateTotal();
        $('#modal_member').modal('toggle');
    });

    function modalMemberData(){
        var member = $("#modal_member").val();
        var satuan = $("#modal_satuan").val();
        var hargasatuan = $("#modal_hargasatuan").val();
        var volume = $("#modal_volume").val();
        var member_teks = $("#modal_member option:selected").text();

        var harsat = parseFloat(hargasatuan.replace('.', '').replace(',', '.'));
        var vol = parseFloat(volume.replace('.', '').replace(',', '.'));
        // var jumlah = harsat.replace(/[^0-9\.]/g,'') * vol_btg.replace(/[^0-9\.]/g,'');
        
        return {
            member: member,
            member_teks: member_teks,
            satuan: satuan,
            hargasatuan: hargasatuan,
            volume: volume,
            total: (harsat * vol).toFixed(2),
        };
    }
</script>