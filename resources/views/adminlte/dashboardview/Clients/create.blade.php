@extends('adminlte.master.master')
@section('content')
@php
                     $create='اضافة';
                        $update ='تعديل';
                     @endphp
    <section class="content-header">



        <h1>
            الزبائن
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li><a href="{{route('dashboard.clients.index')}}"> الزبائن</a></li>

            <li class="active">   {{isset($client)?$update:$create}}</li>
        </ol>
    </section>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{isset($client)?$update:$create}}</h3>

                    </div>
                @include('adminlte.master.messageserror')
                <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form role="form" id="ad" method="post"  action="{{isset($client)?'/dashboard/clients/update/'.$client->id:'/dashboard/clients/store'}}" enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="name">الاسم</label>
                                    <input type="text" class="form-control"   name="name" id="name"  value="{{isset($client)?$client->name:old('name')}}"  placeholder="الاسم">
                                </div>
                                <div class="form-group">
                                    <label for="phone1">رقم الهاتف الاول</label>
                                    <input type="text" class="form-control"   name="phone[]"   value="{{isset($client)?$client->phone[0]:''}}"  placeholder="رقم الهاتف الأول">
                                </div>
                                <div class="form-group">
                                    <label for="phone2">رقم الهاتف الثاني</label>
                                    <input type="text" class="form-control"   name="phone[]"   value="{{isset($client)?$client->phone[1]:''}}"  placeholder="رقم الهاتف الثاني">
                                </div>
                                <div class="form-group">
                                    <label for="address">العنوان</label>
                                    <textarea type="text" class="form-control"   name="address" id="address"    placeholder="العنوان">{{isset($client)?$client->address:''}}</textarea>
                                </div>
                            </div>


                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">  {{isset($client)?$update:$create}}</button>
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
@section('js')
    <script>
        CKEDITOR.config.language = '{{app()->getLocale()}}';
    </script>
@endsection