@extends('adminlte.master.master')

@section('content')

        <section class="content-header">



            <h1>
                الطلبيات

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li class="active">  الطلبيات من التجار </li>
            </ol>
        </section>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                        @include('adminlte.master.messageserror')
                            <div class="col">
                                    <div class="card card-body">
                                       
                                    @if($orders->count()>0)
                                  
                                    <table class="table table-hover " id="table_data_test">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>اسم التاجر</th>
                                                    <th>سعر الطلبية</th>
                                                    <th>المبلغ المدفوع </th>
                                                    <th>الباقي </th>
                                                    <th>تاريخ الطلبية </th>
{{--                                                    <th>الاعدادات</th>--}}

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($orders as $index=>$order)
                                                   
                                                    <tr>
                                                        <td>{{$index+1}}</td>
                                                        <td>{{$order->seller->name}}</td>
                                                        <td>{{number_format($order->total_price,2)}}</td>
                                                        <td>{{number_format($order->total_paid,2)}}</td>
                                                        <td>{{number_format($order->total_price-$order->total_paid,2)}}</td>
                                                        <td>{{$order->created_at}}</td>
{{--                                                        <td>--}}
                                                        
{{--                                                                <a href="/dashboard/clients/orders/edit/{{$order->clients->id}}/{{$order->id}}" class="btn btn-primary btn-sm"  ><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
{{--                                                                <a data-url="/dashboard/orders/order_products/" data-id="{{$order->id}}" data-method="get" class="btn btn-primary btn-sm show_products"  ><i class="fa fa-info" aria-hidden="true"></i></a>--}}
{{--                                                                <a href="{{route('dashboard.orders.delete',$order->id)}}" class="btn btn-danger btn-sm " ><i class="fa fa-trash" aria-hidden="true"></i></a>--}}

{{--                                                        </td>--}}


                                                    </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                    <th>المجموع</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>

                                                                                                     

                                                </tr>
                                            </tfoot>
                                        </table>



                                                    @else
                                                        <h4>لا يوجد طلبيات</h4>
                                                    @endif 

                                    </div>
                            </div>

                    </div>
                   
                  
                    
                   
                </div>
                <!-- /.box -->
            </div>

        </div>
    </div>



@endsection
@section('js')

    <script>

    $(document).ready(function() {
 $('#table_data_test').DataTable( {
         "language": {
                 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
             },
             'pagingType':'full_numbers',
         'lengthMenu':[[5,10,15,20,25,-1],[5,10,15,20,25,'الكل']],
         "footerCallback": function ( row, data, start, end, display ) {
             var api = this.api(), data;

             // Remove the formatting to get integer data for summation
             var intVal = function ( i ) {
                 return typeof i === 'string' ?
                     i.replace(/[\$,]/g, '')*1 :
                     typeof i === 'number' ?
                         i : 0;
             };

             // Total over all pages


             // Total over this page
             pageTotal_price = api
                 .column( 2, { page: 'current'} )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
                 total_price = api
                 .column( 2 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );

             // Total over this page
             pageTotal_paid = api
                 .column( 3, { page: 'current'} )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
                 total_paid = api
                 .column( 3 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
             pageTotal_debt = api
                 .column( 4, { page: 'current'} )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
                 total_debt = api
                 .column( 4 )
                 .data()
                 .reduce( function (a, b) {
                     return intVal(a) + intVal(b);
                 }, 0 );
             // Update footer

             $( api.column( 2 ).footer() ).html(
              total_price+"( "+pageTotal_price+" )"
              );
              $( api.column( 3 ).footer() ).html(
              total_paid+"( "+pageTotal_paid+" )"
              );
              $( api.column( 4 ).footer() ).html(
                 total_debt+"( "+pageTotal_debt+" )"
              );

         }
 } );
 } );




    </script>
    @endsection