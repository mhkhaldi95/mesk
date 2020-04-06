@extends('adminlte.master.master')
@section('content')
@php
                     $create='اضافة';
                        $update ='تعديل';
                     @endphp
        <section class="content-header">



            <h1>
                العطور
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li class="active"><a > العطور</a></li>

                <li class="active">   {{isset($Product)?$update:$create}}</li>
            </ol>
        </section>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{isset($Product)?$update:$create}}</h3>

                    </div>
                    @include('adminlte.master.messageserror')
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form role="form" id="ad" method="post"  action="{{isset($Product)?'/dashboard/products/update/'.$Product->id:'/dashboard/products/store'}}" enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">
                                <div class="form-group">
                                  @php
                                      $index=0;
                                      if(isset($Product))
                                      $index = $Product->category_id;
                                  @endphp
                                    <label>الصنف</label>
                                    <select class="form-control" required name="category_id" >
                                        <option value="">الأصناف</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}"  {{$index==$category->id? 'selected':''}} {{$category->id==$index?'selected':''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                    <div class="form-group">
                                        <label for="name">الاسم</label>
                                       <input type="text" class="form-control"   name="name" id="name" required value="{{isset($Product)?$Product->name:''}}"  placeholder="الاسم">
                                    </div>
                                    <div class="form-group">
                                        <label for="sequenceNo">الرقم التسلسلي</label>
                                       <input type="number" class="form-control"  step="0.01"  name="sequenceNo" id="sequenceNo" required value="{{isset($Product)?$Product->sequenceNo:''}}"  placeholder="الرقم التسلسلي">
                                    </div>
                   
                                
                                <div class="form-group">
                                    <label for="price">سعر الشراء</label>
                                    <input type="number" class="form-control" step="0.01"    name="purchase_price" id="purchase_price" required value="{{isset($Product)?$Product->purchase_price:old('purchase_price')}}"  placeholder="سعر البيع">
                                </div>
                               
                                <div class="form-group">
                                    <label for="stoke">كمية الجملة</label>
                                    <input type="number" class="form-control"   name="whole_stoke" id="stoke" required value="{{isset($Product)?$Product->whole_stoke:old('whole_stoke')}}"  placeholder="الكمية">
                                </div>
                                <div class="form-group">
                                    <label for="stoke">كمية المفرق</label>
                                    <input type="number" class="form-control"   name="retail_stoke" id="stoke" required value="{{isset($Product)?$Product->retail_stoke:old('retail_stoke')}}"  placeholder="الكمية">
                                </div>
                            </div>


                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">{{isset($Product)?$update:$create}}</button>
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