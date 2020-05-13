@extends('adminlte.master.master')
@section('content')
    <section class="content-header">
        <h1>
            الزبائن
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active"> الزبائن</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                    <a href="{{route('dashboard.clients.create')}}" style="width: 11%;float: left;margin-left: 16%;"  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>

                    @include('adminlte.master.messageserror')
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">


                        <table class="table table-hover" id="table">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>العنوان</th>
                                <th>اضافة طلبية</th>
                                <th>المشتريات </th>
                                <th>الاعدادات</th>

                            </tr>
                            </thead>
                             
                           
                        </table>
                      
                          
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>



@endsection
@section('js')
    <script>
   
$(document).ready(function() {
 $('#table').DataTable( {
    "language": {
        "url": "{{asset('datatables-ar.json')}}"
    },
'pagingType':'full_numbers',
'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
processing: true,
serverSide: true,
ajax: '{!! route('datatables.clients') !!}',
columns: [
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'phone', name: 'phone' },
{ data: 'address', name: 'address' },
{ data: 'add', name: 'add' },
{ data: 'show', name: 'show' },
{ data: 'action', name: 'action' },



]

});
    });
   
    $(document).on("click",'.remove-project',function(){
            var id=$(this).data('value');

            swal({
                title: "@Lang('pos.sure')",
                text: "@lang('pos.Once deleted')",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        method:'POST',
                        url: "/dashboard/clients/delete/"+id,
                        data:{body:'',_token:'{{csrf_token()}}'},
                        success: function (response) {
                            var count = $('table tr').length;

                            $( "#tr_"+id).remove();
                           
                            if(count == 2){
                                location.reload();
                            }
                        }

                    })

                } 
            });
        });

    </script>
    <script>
        //addclient
    $('#addddddd').on('submit', function(event){

            event.preventDefault();
            $('#nameError').addClass('d-none');
            $('#emailError').addClass('d-none');
            $('#passwordError').addClass('d-none');
            $('#passwordcError').addClass('d-none');


            $.ajax({
                url: "{{route('dashboard.clients.create')}}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    var count = $('table tr').length;

                        var ro = '<tr id="tr_'+data.data.id+'">\n' +
                            '<td >'+count+'</td>\n' +
                            '<td>'+data.data.name+'</td>\n' +
                            '<td>'+data.data.email+'</td>\n' +
                            '\n' +
                            '<td>\n' +
                            '<a data-value="'+data.data.id+'" id="delete" class="btn btn-danger delete-post-link remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
                            '<a data-value="'+data.data.id+'" class="btn btn-info editu"  data-toggle="modal" data-target="#editclient" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
                            '</td>\n' +
                            '</tr>';

                        $('#addclient').modal("hide");
                        $('#table tbody').append
                        (ro);


                },
                error:function (data) {
                    var errors = data.responseJSON;
                    if($.isEmptyObject(errors) == false){
                        $.each(errors.errors,function (key,value) {
                            var ErrorID = '#'+key+'Error';
                            $(ErrorID).removeClass('d-none');
                            $(ErrorID).text(value);
                        })
                    }
                }
            })

    });

        //updateclient
    $(document).ready(function(){
            var id;

            $(document).on("click",'.editu',function (event) {
                x=event;
                target = $(x.target).parent().parent().parent();
                id=$(this).data('value');
            });


            $('#edit').on('submit', function(event){

                event.preventDefault();
                $('#nameeError').addClass('d-none');
                $('#emaileError').addClass('d-none');
                $('#passwordeError').addClass('d-none');
                $('#passwordceError').addClass('d-none');
                $.ajax({
                    url: "/dashboard/clients/edit/"+id,
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {

                        var count = $('table tr').length;

                            $('#editclient').modal("hide");
                            var row = '   <tr id="tr_'+data.data.id+'">\n' +
                                '                                    <td >'+count+'</td>\n' +
                                '                                    <td>'+data.data.name+'</td>\n' +
                                '                                    <td>'+data.data.email+'</td>\n' +
                                '\n' +
                                '                                   <td>\n' +
                                '<a data-value="'+data.data.id+'" id="delete" class="btn btn-danger delete-post-link remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
                                '<a data-value="'+data.data.id+'" class="btn btn-info editu" data-toggle="modal" data-target="#editclient" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
                                '</td>\n' +
                                '\n' +
                                '</tr>';
                        var ro = '<tr id="tr_'+data.data.id+'">\n' +
                            '<td >'+count+'</td>\n' +
                            '<td>'+data.data.name+'</td>\n' +
                            '<td>'+data.data.email+'</td>\n' +
                            '\n' +
                            '<td>\n' +
                            '<a data-value="'+data.data.id+'" id="delete" class="btn btn-danger delete-post-link remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
                            '<a data-value="'+data.data.id+'" class="btn btn-info editu" data-toggle="modal" data-target="#editclient" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
                            '</td>\n' +
                            '</tr>';
                            target.replaceWith(row);

                        },
                    error:function (data) {
                        var errorss = data.responseJSON;
                        if($.isEmptyObject(errorss) == false){
                            $.each(errorss.errors,function (key,value) {
                                var ErrorID = '#'+key+'Error';
                                $(ErrorID).removeClass('d-none');
                                $(ErrorID).text(value);
                            })
                        }
                    }

                })

            });

    });

    </script>
    @endsection