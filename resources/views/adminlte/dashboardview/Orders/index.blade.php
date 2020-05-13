@extends('adminlte.master.master')
@section('style')
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 70px;
            height: 70px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    @endsection
@section('content')

        <section class="content-header">



            <h1>
                الطلبيات

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li class="active"> الطلبيات</li>
            </ol>
        </section>

    <div class="content">
        <div class="row">
            <div class="col-md-8">
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
                                                    <th>الاسم</th>
                                                    <th>سعر الطلبية</th>
                                                    <th>المبلغ المدفوع </th>
                                                    <th>الباقي </th>
                                                    <th>تاريخ الطلبية </th>
                                                    <th>الاعدادات</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($orders as $index=>$order)
                                                   
                                                    <tr>
                                                        <td>{{$index+1}}</td>
                                                        <td>{{$order->clients->name}}</td>
                                                        <td>{{number_format($order->total_price,2)}}</td>
                                                        <td>{{number_format($order->total_paid,2)}}</td>
                                                        <td>{{number_format($order->total_price-$order->total_paid,2)}}</td>
                                                        <td>{{$order->created_at->toFormattedDateString()}}</td>
                                                        <td>
                                                        
                                                                <a href="/dashboard/clients/orders/edit/{{$order->clients->id}}/{{$order->id}}" class="btn btn-primary btn-sm"  ><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                                <a data-url="/dashboard/orders/order_products/" data-id="{{$order->id}}" data-method="get" class="btn btn-primary btn-sm show_products"  ><i class="fa fa-info" aria-hidden="true"></i></a>
                                                                <a href="{{route('dashboard.orders.delete',$order->id)}}" class="btn btn-danger btn-sm " ><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                        </td>


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
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">عرض الطلبيات</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive no-padding">
                            <div class="card card-body parent_show_order ">

                                <div class="load"></div>
                                <table class="table table-hover order_table_list" id="show_order">
                                   
                                    
                                    
                                </table>
                                <div class="print">
                                </div>
                                
                            </div>


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
$('#table_data_test').DataTable( {
        "language": {
            "url": "{{asset('datatables-ar.json')}}"
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
            total_price = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
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
           
                total_paid = api
                .column( 3 )
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
             total_price
             );
             $( api.column( 3 ).footer() ).html(
             total_paid
             );
             $( api.column( 4 ).footer() ).html(
                total_debt
             );
           
        }
} );
} );



    $(document).ready(function () {

        $(document).on('click','.show_products',function (e) {
            e.preventDefault();
            var loader =`<div class="loader"
            style="display: none;align-items: center"></div>
`;
            $('.load').empty();
            $('.load').append(loader);
            $('.loader').css('display','flex');

            var url =$(this).data('url');
            var method =$(this).data('method');
            var id =$(this).data('id');
           
        //             $('.order_table_list .tot').each(function (index) {
        // // $(this).closest('tr').find('');
        // total+=parseFloat($(this).html()); 

    // });
$.ajax({
                method:method,
                url: url+id,
                success: function (response) {
                 
                    $('.loader').css('display','none');
                   
                    var html=`<tbody> <tr>
                                                <th>الاسم</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
                                                <th >الاجمالي</th>

                               </tr>`;
                               
                               var discount=0;
                    for(var i=0; i<response.order.products.length;++i){
                        var name = response.order.products[i].name;
                        var  quantity = parseFloat(response.products[i].pivot.quantity);
                         var price_unit = parseFloat(response.products[i].pivot.sale_price);
                         var total_unit =quantity*price_unit ;
                         
                         discount+= parseFloat(response.products[i].pivot.discount);
                      

                        html +=`
            <tr>
                <td>${name}</td>
                <td>${quantity}</td>
                <td>${price_unit}</td>
                <td class="tot">${total_unit}</td>
            </tr>
            `;
           
                    }
                 var total_price =response.order.total_price; 
                  var total_paid =response.order.total_paid; 
                  var debt =response.order.total_price - response.order.paid; 
                    var total_after_discount = total_price-discount;
                   
                   
            

                    html+= `
                    
                    <tr>
                    <td colspan="1"><h4>الاجمالي</h4><td>
                    <td colspan="2">${$.number(total_price,2)}<td>
                    <td colspan="1"><td>
                    </tr>
                    <tr>
                    <td colspan="1"><h4>مبلغ الخصم</h4><td>
                    <td colspan="2">${$.number(discount,2)}<td>
                    <td colspan="1"><td>
                    </tr>
                    <tr>
                    <td colspan="1"><h4>المبلغ بعد الخصم</h4><td>
                    <td colspan="2">${$.number(total_price,2)-$.number(discount,2)}<td>
                    <td colspan="1"><td>

                    </tr>
                    <tr>
                    <td colspan="1"><h4>واصل</h4><td>
                    <td colspan="2">${$.number(total_paid,2)}<td>
                    <td colspan="1"><td>

                    </tr>
                    <tr>
                    <td colspan="1"><h4>الباقي</h4><td>
                    <td colspan="2">${$.number(total_price,2)-$.number(total_paid,2)}<td>
                    <td colspan="1"><td>

                    </tr>
                   
  
                   
                   
                    </tbody>
                    
                    
                    
                    `;

                   var print=` <td>
                    <input type="submit" style="width:100%" class="btn btn-primary"  id="print_order" style="align-content: center;width: 100%" value="طباعة">
                    <td>`;
                    $('#show_order').empty();
                    $('#show_order').append(html)
                    $('.print').empty();
                    $('.print').append(print)






                }

            })
        });
        $(document).on("click",'.remove_order',function(e){
            e.preventDefault();
            var id =$(this).data('id');
            // $('.rowOrder'+id).remove();
            $(this).closest('tr').remove();
            $('#prodcut'+id).removeClass('disabled btn-default').addClass('btn-primary');
            calculate_totalPrice();
        })
    });
    $(document).on("click",'#print_order',function(e){
            e.preventDefault();
            $('.order_table_list').printThis();
        })
        function calculate_totalPrice() {
            var total=0;
            $('.orders_table .price').each(function (index) {
                total+=parseFloat($(this).html().replace(/,/g,''));
            });

            // $('.total').html(total);1156850.5
            $('.total').html($.number(total,2));//11,568,50.50
            if(total>0){
                $('#submit_order').removeClass('disabled btn-default').addClass('btn-primary');
            }else{
                $('#submit_order').removeClass('btn-primary').addClass('disabled btn-default');

            }
        }
    </script>
    @endsection