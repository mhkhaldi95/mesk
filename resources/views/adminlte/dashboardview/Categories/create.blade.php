@extends('adminlte.master.master')
@section('content')
@php
                     $create='اضافة';
                        $update ='تعديل';
                     @endphp
        <section class="content-header">



            <h1>
                الأصناف
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li><a href="{{route('dashboard.categories.index')}}"> الأصناف</a></li>

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
                        <form role="form" id="ad" method="post"  action="{{isset($category)?'/dashboard/categories/update/'.$category->id:'/dashboard/categories/create'}}">
                            @csrf
                            <div class="box-body">
         
                                    <div class="form-group">
                                        <label for="name">اسم الصنف</label>
                                        <input type="text" class="form-control"   name="name" id="name" required value="{{isset($category)?$category->name:''}}"  placeholder="اسم الصنف">
                                    </div>
                              

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">{{isset($category)?$update:$create}}</button>
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