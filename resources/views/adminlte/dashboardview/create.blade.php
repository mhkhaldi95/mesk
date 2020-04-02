@extends('adminlte.master.master')
@section('content')

                @php
                     $create='اضافة';
                        $update ='تعديل';
                     @endphp
        <section class="content-header">

                <script>

                    // var n = noty({
                    //     text: 'NOTY - a jquery notification library!',
                    //     animation: {
                    //         open: {height: 'toggle'},
                    //         close: {height: 'toggle'},
                    //         easing: 'swing',
                    //         speed: 500 // opening & closing animation speed
                    //     }
                    // });

                </script>

            <h1>
                المشرفون
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li><a href="{{route('dashboard.users.index')}}">المشرفون</a></li>

                <li class="active">   {{isset($user)?$update:$create}}</li>
            </ol>
        </section>
        <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{isset($user)?$update:$create}}</h3>

                    </div>
                    @include('adminlte.master.messageserror')
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form role="form" id="ad" method="post" enctype="multipart/form-data" action="{{isset($user)?'/dashboard/users/update/'.$user->id:'/dashboard/users/create'}}">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم</label>
                                    <input type="text" class="form-control" id="name" value="{{isset($user)?$user->name:''}}"  name="name"  placeholder="@lang('pos.name')">
                                    <span class="text-danger" id="nameError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الايميل</label>
                                    <input type="email" class="form-control" name="email"  value="{{isset($user)?$user->email:''}}" id="email" placeholder="@lang('pos.email')">
                                    <span class="text-danger" id="emailError"></span>
                                </div>

                                <div class="form-group">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                            @if(isset($user))
                                                <img src="{{$user->image_path}}" alt="">
                                                @else <img src="{{asset('/uploads/image_user/default-png.png')}}" alt="">
                                                @endif
                                        </div>
                                        <div>
                                                                <span class="btn red btn-outline btn-file">
                                                                    <span class="fileinput-new btn btn-primary">اختر صورة  </span>
                                                                    <span class="fileinput-exists btn btn-primary" >تغيير الصورة  </span>
                                                                    <input type="file" name="image"> </span>
                                            <a href="javascript:;" class="btn red fileinput-exists btn btn-danger" data-dismiss="fileinput">@lang('pos.Remove')  </a>
                                        </div>
                                    </div>
                                </div>

                            

                                <div class="form-group">
                                    <label for="exampleInputPassword1">كلمة المرور</label>
                                    <input type="password" class="form-control" name="password"  id="password" placeholder="كلمة المرور">
                                    <span class="text-danger" id="passwordError"></span>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">تأكيد كلمة المرور</label>
                                    <input type="password" class="form-control" name="passwordc" id="passwordc" placeholder="تأكيد كلمة المرور">
                                    <span class="text-danger" id="passwordcError"></span>

                                </div>
                             
                                

                              


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">{{isset($user)?$update:$create}}</button>
                            </div>
                        </form>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>


   


@endsection