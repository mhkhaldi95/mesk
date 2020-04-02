@extends('adminlte.master.master')
@section('content')
<section class="content-header">
        <h1>
            المشرفون
        </h1>
        <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>

            <li class="active"> المشرفون</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
{{--                     هان بجيب العدد على حسب الباجينيشن   {{count($users)}}--}}
                        <h3 class="box-title"> المشرفون<small>{{$users->total()}}</small></h3>

                        <div class="box-tools">
                            <form method="get" action="">

                                <div class="input-group input-group-sm hidden-xs" style="width: 250px;">

                                    <input type="text" name="search" class="form-control pull-right" placeholder="بحث" value="{{request()->search}}">

                                    <div class="input-group-btn">

                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
{{--                                        <a href="#" data-toggle="modal" data-target="#adduser" style="margin-right: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>--}}
                                    @if(auth()->user()->hasPermission('create_users'))
                                            <!-- <a href=""  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a> -->
                                        @else
                                            <a href=""  class="btn btn-primary disabled"><i class="fa fa-plus"></i>اضافة</a>

                                        @endif
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        @if(count($users)>0)
                        <table class="table table-hover" id="table">
                            <tbody>

                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الايميل</th>
                                <th>الصورة</th>
                                <th>الاعدادات</th>

                            </tr>
                            @foreach($users as $index=>$user)
                                <tr id="tr_{{$user->id}}">
                                    <td>{{$index+1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                   <td><img style="width: 100px" class="img-thumbnail" src="{{asset('/uploads/image_user/'.$user->image)}}" alt=""> </td>
                                    <!-- <td><img style="width: 100px" class="img-thumbnail" src="{{$user->image_path}}" alt=""> </td> -->

                                    <td>
                                        @if(auth()->user()->hasPermission('delete_users'))
                                        <a data-value="{{$user->id}}"  id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>

                                            <!-- <a  href="/dashboard/users/destroy/{{$user->id}}" id="delete" class="btn btn-danger "> <i class="fa fa-trash" aria-hidden="true"></i></a> -->
                                        @else
                                            <a data-value="" id="delete" class="btn btn-danger disabled  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>

                                        @endif
                                        @if(auth()->user()->hasPermission('update_users'))
{{--                                                <a data-value="{{$user->id}}" class="btn btn-info editu" data-toggle="modal" data-target="#edituser" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                                <a href="/dashboard/users/edit/{{$user->id}}" class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i></a>
                                        @else
                                                <a data-value="" class="btn btn-info editu disabled" data-toggle="modal" data-target="#edituser" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>

                                        @endif

                                    </td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                            {{$users->appends(request()->query())->links()}}
                        @else
                            <h2>لا يوجد اي مشرف</h2>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>

    <div class="modal fade"  id="adduser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">اضافة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body mx-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">اضافة</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="ad" method="post" action="javascript:void(0)">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم</label>
                                    <input type="text" class="form-control" id="name" name="name"  placeholder="@lang('pos.name')">
                                    <span class="text-danger" id="nameError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الايميل</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="@lang('pos.email')">
                                    <span class="text-danger" id="emailError"></span>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">كلمة المرور</label>
                                    <input type="password" class="form-control" name="password"  id="password" placeholder="@lang('pos.password')">
                                    <span class="text-danger" id="passwordError"></span>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" name="passwordc" id="passwordc" placeholder="@lang('pos.passwordc')">
                                    <span class="text-danger" id="passwordcError"></span>

                                </div>
                                <h2 class="page-header">@lang('pos.permissions')</h2>
                                <div class="col-md-12">
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#users" data-toggle="tab" aria-expanded="true">المشرفون</a></li>

                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="users">
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="create_users"> اضافة
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="update_users"> تعديل
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="delete_users"> حذف
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="permissions[]" value="read_users">عرض
                                                </label>
                                                <span class="text-danger" id="checkboxe"></span>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">اضافة</button>
{{--                                <button type="button" class="btn btn-primary" onclick="storeData();">اضافة</button>--}}
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <div class="modal fade"  id="edituser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">@lang('pos.edit')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body mx-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('pos.edit')</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="edit" method="post" action="javascript:void(0)">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('pos.name')</label>
                                    <input type="text" class="form-control namee" required id="namee" name="namee"  placeholder="@lang('pos.name')">
                                    <span class="text-danger" id="nameeError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">@lang('pos.email')</label>
                                    <input type="email" class="form-control emaile" required name="emaile" id="emaile" placeholder="@lang('pos.email')">
                                    <span class="text-danger" id="emaileError"></span>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('pos.password')</label>
                                    <input type="password" class="form-control" required name="passworde"  id="passworde" placeholder="@lang('pos.password')">
                                    <span class="text-danger" id="passwordeError"></span>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">@lang('pos.passwordc')</label>
                                    <input type="password" class="form-control" required name="passwordce" id="passwordce" placeholder="@lang('pos.passwordc')">
                                    <span class="text-danger" id="passwordceError"></span>

                                </div>
                                <h2 class="page-header">@lang('pos.permissions')</h2>
                                <div class="col-md-12">
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#users" data-toggle="tab" aria-expanded="true">@lang('pos.users')</a></li>

                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="users">
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="user_create"> @lang('pos.create')
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="user_update"> @lang('pos.update')
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="user_delete"> @lang('pos.delete')
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="user_read"> @lang('pos.read')
                                                </label>
                                                <span class="text-danger" id="checkboxe"></span>
                                            </div>
                                            <!-- /.tab-pane -->
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('pos.edit')</button>
                                {{--                                <button type="button" class="btn btn-primary" onclick="storeData();">@lang('pos.add')</button>--}}
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>


@endsection
@section('js')
    <script>
        $(document).on("click",'.remove-project',function(){
            var id=$(this).data('value');
            swal({
                title: "تأكيد",
                text: "سوف يتم حذف المستخدم",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        method:'POST',
                        url: "/dashboard/users/destroy/"+id,
                        data:{body:'',_token:'{{csrf_token()}}'},
                        success: function (response) {
                            var count = $('table tr').length;

                            $( "#tr_"+id).remove();
                            swal("تم الحذف بنجاح", {
                                icon: "success",
                            });
                            if(count == 2){
                                location.reload();
                            }
                        }

                    })

                } else {
                    swal("@lang('تم الالغاء')");
                }
            });
        });
      

    </script>

    </script>
    <script>
        //adduser
        $('#ad').on('submit', function(event){

            event.preventDefault();
            $('#nameError').addClass('d-none');
            $('#emailError').addClass('d-none');
            $('#passwordError').addClass('d-none');
            $('#passwordcError').addClass('d-none');


            $.ajax({
                // url: "",
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
                            '<a data-value="'+data.data.id+'" class="btn btn-info editu"  data-toggle="modal" data-target="#edituser" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
                            '</td>\n' +
                            '</tr>';

                        $('#adduser').modal("hide");
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

        //updateuser
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
                    url: "/dashboard/users/edit/"+id,
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {

                        var count = $('table tr').length;

                            $('#edituser').modal("hide");
                            var row = '   <tr id="tr_'+data.data.id+'">\n' +
                                '                                    <td >'+count+'</td>\n' +
                                '                                    <td>'+data.data.name+'</td>\n' +
                                '                                    <td>'+data.data.email+'</td>\n' +
                                '\n' +
                                '                                   <td>\n' +
                                '<a data-value="'+data.data.id+'" id="delete" class="btn btn-danger delete-post-link remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
                                '<a data-value="'+data.data.id+'" class="btn btn-info editu" data-toggle="modal" data-target="#edituser" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
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
                            '<a data-value="'+data.data.id+'" class="btn btn-info editu" data-toggle="modal" data-target="#edituser" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
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