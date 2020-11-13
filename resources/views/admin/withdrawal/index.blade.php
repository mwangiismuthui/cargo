@extends('admin.layout.main')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-table"></i> Withdrawal Requests
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="upload_fee_table" class="table table-bordered ">
                                <thead>

                                    <th> Client</th>
                                    <th> Client Email</th>
                                    <th> Amount</th>
                                    <th>Action</th>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>



                                    <th> Client</th>

                                    <th> Client Email</th>
                                    <th> Amount</th>
                                    <th>Action</th>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Row-->
    </div>
</div>



<!-- Modal -->
{{-- <div class="modal fade servicemodal" id="uploadfeeModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Add Upload Fees Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="upload_fee_form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title"> Upload Fees Amount</label>
                        <input type="text" class="form-control form-control-rounded" id="title"
                            placeholder="Enter Amount" name="amount">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary shadow-primary btn-round px-5"><i
                                class="icon-checkbox3"></i> Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div> --}}

<!-- Large Size Modal -->

<script>
    $(document).ready(function(){
    $(".alert").delay(5000).slideUp(300);
});
    var table = $('#upload_fee_table').DataTable({
        processing: true,
        serverSide: true,    
        ajax: "{{ route('allWithdrawalRequests')}}",
        columns:[
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'amount', name: 'amount'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs:[
       
        ]

        });

   function UploadFeedelete(fee_id) {
       console.log(fee_id);
    $.ajax({
           url:'/uploadFee/destroy/',
           method:'delete',
           data:{
               fee_id:fee_id,
                 _token: "{{ csrf_token() }}",
           },
           success:function(data){
               if (data.errors) {
                    Lobibox.notify("error", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.message,
                    });
                }
                if (data.success) {
                    Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-check-circle", //path to image
                        msg: data.message,
                     });

                     console.log(data.success);
                }
             $('#upload_fee_table').DataTable().ajax.reload();
           }

       });
    }



    $("#upload_fee_form").on("submit", function (event) {
        event.preventDefault();
        // console.log('aye');
        $.ajax({
            url: "/uploadFee/store",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (data) {
                console.log(data);
           if (data.errors) {
                    Lobibox.notify("error", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-times-circle",
                        msg: data.message,
                    });
                }
                if (data.success) {
                    Lobibox.notify("success", {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: "top right",
                        icon: "fa fa-check-circle", //path to image
                        msg: data.message,
                     });

                     console.log(data.success);
                }
                $('#uploadfeeModal').modal('hide');
                $('#upload_fee_table').DataTable().ajax.reload();
            },
            error: function () {
            Lobibox.notify("error", {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: "top right",
                icon: "fa fa-times-circle",
                msg: "Something went wrong",
            });
            console.log("error");
                                },
        });
    });
   
</script>


@endsection