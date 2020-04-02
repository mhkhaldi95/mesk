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

                    @include('adminlte.master.messageserror')
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">


                        <table class="table table-hover" id="table">

                            <thead>

                            <tr>
                                <th>#</th>
                                <th>اسم الزبون</th>
                                <th>اسم المنتج </th>
                                <th>رقم الطلبية</th>
                                <th>الكمية </th>
                                <th>سعر البيع </th>
                                <th>الخصم</th>
                                <th> السعر الاجمالي </th>
                                <th> المبلغ المدفوع  </th>
                                <th> المبلغ المبتقي  </th> 
                                <th>كمية الزيت</th>
                                <th>نوع الزجاجة</th>
                                <th>تاريخ الشراء</th>

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
    var currentDate = new Date();

var date = currentDate.getDate();
var month = currentDate.getMonth(); //Be careful! January is 0 not 1
var year = currentDate.getFullYear();
if(date<10){
    date="0"+date;
}

    if(month<9)
    var dateString = year+"-0"+(month + 1) +"-"+date;
    else  var dateString = year+"-"+(month + 1) +"-"+date;
 $('#table').DataTable( {
    "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
    },
'pagingType':'full_numbers',
'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
processing: true,
serverSide: true,
ajax: '{!! route('datatables.show_sales') !!}',
columns: [
{ data: 'id', name: 'id' },
{ data: 'client_id', name: 'client_id' },
{ data: 'product_id', name: 'product_id' },
{ data: 'order_id', name: 'order_id' },
{ data: 'quantity', name: 'quantity' },
{ data: 'sale_price', name: 'sale_price' },
{ data: 'discount', name: 'discount' },
{ data: 'total_price', name: 'total_price' },
{ data: 'total_paid', name: 'total_paid' },
{ data: 'debt', name: 'debt' },
{ data: 'volume', name: 'volume' },
{ data: 'glass_id', name: 'glass_id' },
{ data: 'created_at', name: 'created_at' },



],
"oSearch": {
"sSearch":dateString
}

});
    });
   
 

    </script>
    <script>
        //addclient


        //updateclient


    </script>
    @endsection