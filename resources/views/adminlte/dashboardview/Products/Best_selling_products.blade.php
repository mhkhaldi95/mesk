@extends('adminlte.master.master')
@section('content')
    <section class="content-header">
        <h1>
        أكثر المنتجات مبيعا
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active"> أكثر المنتجات مبيعا</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <div class="row">
                                
                               
                        </div>
                        @include('adminlte.master.messageserror')

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

                       
                        
                        <table class="table table-hover" id="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                 <th>الرقم التسلسلي</th>
                                <th>مخزون الجملة</th>
                                <th>مخزون المفرق</th>
                              

                            </tr>
                            </thead>
                            <tbody>
                                @foreach($best_sales as $index=>$product)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->sequenceNo}}</td>
                                    <td>{{$product->whole_stoke}}</td>
                                    <td>{{$product->retail_stoke}}</td>
                                </tr>
                                @endforeach
                             
                            </tbody>
                           
                            </table>
                            {{$best_sales->links()}}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>



@endsection



 