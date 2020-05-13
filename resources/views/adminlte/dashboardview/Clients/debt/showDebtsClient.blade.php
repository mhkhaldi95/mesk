@extends('adminlte.master.master')
@section('content')
@include('adminlte.master.messageserror')
    <section class="content-header">
        <h1>
        المدين : {{$client->name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active">تفاصيل الدين</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
                        <h3 class="box-title"> ديون : {{$client->name}}<small>{{count($product_debts)}}</small></h3>
                        <div class="box-tools">
            
                        </div>  
                    </div>
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

                           
                            @foreach($product_debts as $index=>$product_debt)
                            <tr id="tr_{{$product_debt->id}}">
                                <td>{{$index+1}}</td>
                                <td>{{$products[$index]->name}}</td>
                                <td>{{$product_debt->quantity}}</td>
                                <td>{{$product_debt->sale_price}}</td>
                                <td>{{$product_debt->discount}}</td>
                                <td>{{(($product_debt->quantity*$product_debt->sale_price)-$product_debt->discount)}}</td>
                                <td>{{(($product_debt->quantity*$product_debt->sale_price)-$product_debt->discount)+$total_debts_unit[$index]}}</td>
                                <td>{{-$total_debts_unit[$index]}}</td>
                                <td>{{$glasses[$index]->name}}</td>
                                <td>{{$product_debt->created_at}}</td>

                                <!-- <td><input type="number" name="paid" step="0.50" id="paid{{$product_debt->id}}"  class="paid" style='width: 40%;height: 42px;'  value=""> </td>


                                <td> -->
                                    
                                    
                                </td>
                                <td>
                                
                                    <a href="" id="delete" class="btn btn-danger "> <i class="fa fa-trash" aria-hidden="true"></i>خذف</a>
                                        <!-- <a data-value="{{$product_debt->id}}" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>@lang('pos.delete')</a> -->

                    {{--                                                <a data-value="{{$product_debt->id}}" class="btn btn-info editu" data-toggle="modal" data-target="#editDebtor" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                            <a href="" class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>


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
                    <th colspan="5"></th>
                    
                </tr>
                </tfoot>
               
            </table>
                
                </div>
            </div>
        </div>
    </div>

                  
     <!-- /.box-header -->
 

           
                    
                   



@endsection
@section('js')
<script>
   $(document).ready(function() {
    $('#table').DataTable( {
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
            total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 7 ).footer() ).html(
             '   مجموع الصفحة الحالية  '+   pageTotal+'  شيكل   ' +' (  المجموع الكلي للدين'+ total +'   شيكل)'
            );
        }
    } );
} );
</script>
@endsection

            