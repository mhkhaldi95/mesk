@extends('adminlte.master.master')
@section('content')
    <section class="content-header">
        <h1>
            الزبائن
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li><a href="{{route('dashboard.clients.index')}}"><i class="fa fa-dashboard"></i>  الزبائن</a></li>
            <li class="active"> المبيعات</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
            <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">الطلبيات السابقة</h3>
                      
        <div class="col">
           
                
                    <table class="table table-hover" id="table">
                        <thead>
                        <tr>
                                <th>#</th>
                                <th>اسم المنتج</th>
                                <th>الكمية</th>
                                <th>سعر البيع</th>
                                <th>الخصم</th>
                                <th>الاجمالي</th>
                                <th>المبلغ المدفوع</th>
                                <th>المبلغ المتبقي</th>
                                <th> نوع الزجاجة</th>
                                <th>تاريخ الشراء</th>
                                <th>الاعدادات</th>

                            </tr>
                        </thead>
                        <tbody>

                        @foreach($products_sales as $index=>$product_sale)
                            <tr id="tr_{{$product_sale->id}}">
                                <td>{{$index+1}}</td>
                                <td>{{$product_sale->product->name}}</td>
                                <td>{{$product_sale->quantity}}</td>
                                <td>{{$product_sale->sale_price}}</td>
                                <td>{{$product_sale->discount}}</td>
                                <td>{{(($product_sale->quantity*$product_sale->sale_price)-$product_sale->discount)}}</td>
                                <td>{{(($product_sale->quantity*$product_sale->sale_price)-$product_sale->discount)+$product_sale->payments()->sum('paid')}}</td>
                                <td>{{-$product_sale->payments()->sum('paid')}}</td>
                                <td>{{$glasses[$index]->name}}</td>
                                <td>{{$product_sale->created_at}}</td>

                                
                                    
                                    
                                </td>
                                <td>
                                <a  data-id_client="{{$product_sale->client_id}}" data-id_order="{{$product_sale->order_id}}" data-id_product="{{$product_sale->product_id}}"   class="btn btn-info showPayments"  >عرض الدفعة</a>

                                    <a  id="delete" class="btn btn-danger "> <i class="fa fa-trash" aria-hidden="true"></i>خذف</a>

                    {{--                                                <a data-value="" class="btn btn-info editu" data-toggle="modal" data-target="#editDebtor" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                            <a  class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>


                                </td>

                            </tr>
                        
                            @endforeach
                           

                </tbody>
                <tfoot>
               
                @php
                    $totaltext = "مجموع الدين = ";
                @endphp
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>المجموع</th>
                    <th ></th>
                    
                    <th></th>
                    <th></th>
                    <th ></th>
                    <th></th>
                    <th></th>
                    
                </tr>
                </tfoot>
               
            </table>

                                    
                               
                            </div>
                            
                 

                         
                    
                    </div>
                  
                                        <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

                    </div>
                    <!-- /.box-body -->
                </div>

                    <!-- /.box-header -->
                        
                          
                    
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
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                },
            'pagingType':'full_numbers',
            'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
           
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
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                total_paid = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                total_debt = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            // pageTotal = api
            //     .column( 7, { page: 'current'} )
            //     .data()
            //     .reduce( function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0 );
            // Update footer
            $( api.column( 5 ).footer() ).html(
             total 
            );
            $( api.column( 6 ).footer() ).html(
             total_paid 
            );
            $( api.column( 7 ).footer() ).html(
             total_debt 
            );
        }
        });
           
    
    });
    $('.showPayments').click(function(){
            var id_client=$(this).data('id_client');
            var id_order=$(this).data('id_order');
            var id_product=$(this).data('id_product');
            console.log(id_client);
                        $.ajax({
                        url: '/dashboard/clients/showPayments/'+id_client+'/'+id_order+'/'+id_product,
                        method:'get',
                        data:{body:'',_token:'{{csrf_token()}}'},
                       

                    }). success(function (response) {
                        console.log(response.product_sale)
                     var htmll=  `<table id="table" border=1>
        <thead>
            <tr >
                <th >رقم الدفعة</th>
                <th >مبلغ الدفعة</th>
                <th > التاريخ</th>
               
              
            </tr>
        </thead>
        <tbody>`;
     





                       var total_price =(response.product_sale.quantity*response.product_sale.sale_price)-response.product_sale.discount;
                        var total_paid = 0;
                        for(var i=0 ; i<response.payments.length ;i++) {
                            if(response.payments[i].paid<=0)
                            htmll+=`<tr ><th >`+(i+1)+` </th><th >`+(total_price+response.payments[i].paid)+`</th><th>`+response.payments[i].created_at+`</th></tr>`;

                            else htmll+=`<tr ><th >`+(i+1)+` </th><th >`+response.payments[i].paid+`</th><th>`+response.payments[i].created_at+`</th></tr>`;
                        
                            total_paid+=response.payments[i].paid;
                        }   
                        htmll+=`</tbody>
                        <tfoot>
                        <tr>
                            <td>المبلغ الاجمالي ${total_price}</td>
                           
                            <td>المبلغ المدفوع ${total_price + total_paid} </td>
                           
                            <td>الباقي ${total_paid} </td>
                            </tr>
                        </tfoot>
                        </table>`;


            swal( { customClass: 'swal-wide', html:htmll });
                        });
                });

               
          
       


    </script>
 
    @endsection