@extends('adminlte.master.master')

@section('content')
    <section class="content-header">
        <h1>
            الطلبيات السابفة
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li><a href="{{route('dashboard.sellers.index')}}"> التجار</a></li>
            <li class="active">  الطلبيات السابفة</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <h3>الطلبيات السابقة</h3>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">


                        <table class="table table-hover" id="table">

                            <thead>
                            <tr>
                                <th>#</th>

                                <th> سعر الطلبية</th>
                                <th> سداد </th>
                                <th> الدفعات </th>
                                <th>تاريخ الطلبية </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $index=>$order)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$order->total_price}}</td>
                                    <td><a href="/dashboard/sellers/orders/old_orders/debt/{{$seller->id}}/{{$order->id}}"><img src="{{asset('paid.png')}}" width="20px" height="20px"></a> </td>
                                    <td><a  data-id_seller="{{$seller->id}}" data-id_order="{{$order->id}}"   class="btn btn-info showPayments"  >عرض الدفعة</a>
                                    </td>
                                    <td>{{$order->created_at}}</td>
                                    <td>
                                        @if($order->isDelevery)
                                            <img src="{{asset('circleGreen.png')}}" width="30px" height="30px">
                                            @else
                                            <img src="{{asset('circlered.jpg')}}" width="30px" height="30px">

                                        @endif
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>

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
        $('#table').DataTable( {
                "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                    },
                    'pagingType':'full_numbers',
                'lengthMenu':[[5,10,15,20,25,-1],[5,10,15,20,25,'الكل']],

        } );
        } );
           $('.showPayments').click(function(){
               var id_seller=$(this).data('id_seller');
               var id_order=$(this).data('id_order');
               console.log(id_seller);
               $.ajax({
                   url: '/dashboard/sellers/showPayments/'+id_seller+'/'+id_order,
                   method:'get',
                   data:{body:'',_token:'{{csrf_token()}}'},


               }). success(function (response) {
                   console.log(response.payments_order)
                   var htmll=  `<table id="table" border=1>
        <thead>
            <tr >
                <th >رقم الدفعة</th>
                <th >مبلغ الدفعة</th>
                <th > التاريخ</th>


            </tr>
        </thead>
        <tbody>`;






                   var total_price =response.payments_order.total_price;
                   var total_paid = 0;
                   for(var i=0 ; i<response.payments.length ;i++) {
                       if(response.payments[i].paid<=0)
                           htmll+=
                               `<tr >
                                     <th >`+(i+1)+` </th><th >`+(total_price+response.payments[i].paid)+`</th>
                                    <th>`+response.payments[i].created_at+`</th>
                                </tr>`;

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
