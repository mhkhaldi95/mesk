@extends('adminlte.master.master')
@section('content')

        <section class="content-header">



            <h1>
                الطلبيات
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li><a href="{{route('dashboard.clients.index')}}"> الزبائن</a></li>

                <li class="active">   الطلبيات</li>
            </ol>
        </section>

    <div class="content">
        <div class="row">
            <div class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">الأصناف</h3>
                        @foreach($categories as $category)

                            <div class="form-group">
                                <input  class="form-control" data-toggle="collapse" href="#category{{$category->id}}"
                                     role="button" aria-expanded="false" aria-controls="category{{$category->id}}" value="{{$category->name}}" readonly>

                            </div>


                      <div class="col">
                                <div class="collapse multi-collapse" id="category{{$category->id}}">
                                    <div class="card card-body">
                                        <table class="table table-hover" id="add_order">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الاسم</th>
                                                    <th>مخزون الجملة</th>
                                                    <th>مخزون المفرق</th>
                                                    <th>الاعدادات</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($category->products as $index=>$product)
                                                <tr id="tr_{{$product->id}}">
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$product->name}}</td>
                                                    <td>{{$product->whole_stoke}}</td>
                                                    <td>{{$product->retail_stoke}}</td>
                                                    <td>
                                                            <a class="btn {{in_array($product->id,$order->products->pluck('id')->toArray())?'btn-default disabled':'btn-primary'}}  btn-sm add_order" data-name="{{$product->name}}" id="prodcut{{$product->id}}"   data-glasses="{{$categories[4]->products}}" data-id="{{$product->id}}" ><i class="fa fa-plus" aria-hidden="true"></i></a>

                                                    </td>


                                                </tr>
                                            @endforeach
                                           

                                            </tbody>
                                            <tfoot>
                                                      
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            @endforeach

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">الطلبيات</h3>

                    </div>
                    @include('adminlte.master.messageserror')
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

                            <div class="card card-body">
                                <form method="post"  action="{{route('dashboard.clients.orders.update',[$order->id,$client->id])}}">
                                    @csrf
                                <table class="table table-hover orders_table" id="table">
                                <thead>
                                <tr>
                                         <th>العطر</th>
                                        <th>الكمية</th>
                                        <th>سعر البيع</th>
                                        <th>مبلغ الخصم</th>
                                        <th>الدفع</th>
                                        <th>كمية الزيت</th>
                                        <th>نوع الزجاجة</th>
                                        <th style="padding-right: 37px;">الاعدادات</th>
                                    </tr>
                                </thead>
                                    <tbody>
                               
                                
                                   
                                    @foreach($order->products as $product)
                                    <tr>
          <input type="hidden" name="product_ids[]" value="{{$product->id}}">
        <td>{{$product->name}}</td>
        <td><input type="number" name="quantity[]" step="1.00"  style='width: 80%;height: 42px;'; class="quantity" data-id="{{$product->id}}" id="quantity{{$product->id}}"  value="{{$product->pivot->quantity}}"> </td>
        <td><input type="number" name="sale_price[]" step="1.00" style='width: 80%;height: 42px;'; class="sale_price" data-id="{{$product->id}}"  value="{{$product->pivot->sale_price}}"> </td>
        <td><input type="number" name="discount[]" step="0.50"  class="discount" style='width: 80%;height: 42px;';  value="{{$product->pivot->discount}}"> </td>
        <td><input type="number" name="paid[]" step="0.50" id="paid{{$product->id}}"  class="paid" style='width: 100%;height: 42px;';  value="{{($product->pivot->quantity*$product->pivot->sale_price)+$product->pivot->paid}}"> </td>
        <td><input type="number" name="volume[]" step="0.10"  class="volume" style='width: 80%;height: 42px;'  value="{{$product->pivot->volume}}"> </td>
        <td>
            <select class="form-control" name="glass_ids[]" style="width: 250%;height: 100%;" >
            @foreach($categories[4]->products as $glass)
            <option value="{{$glass->id}}"  >{{$glass->name}}</option>
            @endforeach
            </select>
        </td>
        
       
      
 
        <td><button data-id="{{$product->id}}" class="btn btn-danger btn-sm remove_order"style="margin-right: 60px;"><i class="fa fa-trash"></i> </button></td>
    </tr>
    @endforeach






                                    <!-- @foreach($order->products as $product)
                                    <tr>
                                   
                                <input type="hidden" name="product_ids[]" value="{{$product->id}}">
                                <td>{{$product->name}}</td>
                                <td><input type="number" name="quantity[]" step="0.50" data-price="{{$product->sale_price}}"  class="quantity" min="1"  value="{{$product->pivot->quantity}}"> </td>
                                <td  class="price" >{{number_format($product->sale_price*$product->pivot->quantity,2)}}</td>
                            </tr>
                            @endforeach -->

                                    </tbody>
                                    <tfoot>
                                                        <tr>
                                                        <th>المجموع</th>
                                                        <th class="total">{{$order->total_price}}</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                       
                                                        
                                                        
                                                        </tr>
                                                        <tr>
                                                        <th>الدين</th>
                                                        <th id="debt">{{-$total_debt}}</th>
                                                        <th>نوع الطلب</th>
                                                        
                                                        <th>
                                                        <label for="whole">جملة</label>
                                                        <input type="radio" id="whole"   name="order" value="whole"  {{$order->type_of_sale==1?'checked':''}}>
                                                        </th>
                                                        <th>
                                                        <label for="retail">مفرق</label>
                                                        <input type="radio" id="retail"   name="order" value="retail"  {{$order->type_of_sale==0?'checked':''}} >
                                                        </th>
                                                        </tr>
                                            </tfoot>
                                </table>
                                   
                                    <div>
                                        <input type="submit" class="btn btn-primary"  id="submit_order" style="align-content: center;width: 100%" value="تعديل">

                                    </div>
                                </form>



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

 var total_paidd = 0;
 $(document).ready(function() {
        $('.table_category').DataTable( {
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                },
            'pagingType':'full_numbers',
            'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
        });
        $('.table_old_category').DataTable( {
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                },
            'pagingType':'full_numbers',
            'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
        });
    });
    $(document).ready(function () {

$('.add_order').on("click",function(e){
    e.preventDefault();
    var name = $(this).data('name');
    var id = $(this).data('id');
    var glasses = $(this).data('glasses');
    var options="";
   
    for(var i=0 ; i<glasses.length;i++ ){
        options+='<option value="'+glasses[i].name+'"></option>';
    }

    var html =`
    <tr>
          <input type="hidden" name="product_ids[]" value="${id}">
        <td>${name}</td>
        <td><input type="number" name="quantity[]" step="1.00"  style='width: 80%;height: 42px;'; class="quantity" data-id="${id}" id="quantity${id}"  value="1"> </td>
        <td><input type="number" name="sale_price[]" step="1.00" style='width: 80%;height: 42px;'; class="sale_price" data-id="${id}" value="0" > </td>
        <td><input type="number" name="discount[]" step="0.50"  class="discount" style='width: 80%;height: 42px;';  value="0"> </td>
        <td><input type="number" name="paid[]" step="0.50" id="paid${id}"  class="paid" style='width: 100%;height: 42px;';  value="0"> </td>
        <td><input type="number" name="volume[]" step="0.10"  class="volume" style='width: 80%;height: 42px;';  value="0"> </td>
        <td> <input list="glass_names" class="glass_names form-control" style="width: 170%;height: 42px;"  name="glass_names[]" value="عروس">
        <datalist id="glass_names">

        ${options}
        </datalist>
        </td>
 
        <td><button data-id="${id}" class="btn btn-danger btn-sm remove_order"style="margin-right: 60px;"><i class="fa fa-trash"></i> </button></td>
    </tr>
    `;
    $(this).removeClass('btn-primary').addClass('disabled btn-default');

    $('.orders_table tbody').append(html);
    calculate_totalPrice()
});
// $(document).on('keyup change','.quantity',function (e) {
//     e.preventDefault();
//     var Quantity =parseFloat($(this).val());

//     var sale_price =$(this).data('price').replace(/,/g,'');
//     $(this).closest('tr').find('.price').html($.number((Quantity*sale_price),2));
//     calculate_totalPrice()
// });

$(document).on('keyup change','.discount',function (e) {
    e.preventDefault();
    // var dis =parseFloat($(this).val());
    // console.log(dis);

    calculate_totalPrice()
});
$(document).on('keyup change','.sale_price',function (e) {
    e.preventDefault();
    // var dis =parseFloat($(this).val());
    // console.log(dis);

    calculate_totalPrice()
});
$(document).on('keyup change','.paid',function (e) {
    e.preventDefault();
    var total_sale_price=0;
    var discounts = 0;
    var total_paidd=0;
    var id=0;
    var total_sale_priceArray=[];
    var discountsArray=[];
    var pa=0;
   

    // console.log($('#quantity'+$id).val());
    $('.orders_table .sale_price').each(function (index) {
        // $(this).closest('tr').find('');
        var  this_sale_price = parseFloat($(this).val().replace(/,/g,''));

         id =$(this).data('id');
         var this_quantity = parseFloat($('#quantity'+id).val().replace(/,/g,''));
        total_sale_price+=parseFloat(this_sale_price*this_quantity);
        total_sale_priceArray[id]=(this_sale_price*this_quantity);

    });

    $('.orders_table .discount').each(function (index) {
        discounts+=parseFloat($(this).val().replace(/,/g,''));
        discountsArray[id]=parseFloat($(this).val().replace(/,/g,''));

    });
    $('.orders_table .paid').each(function (index) {
        pa+=parseFloat($(this).val().replace(/,/g,''));
        //pa total_paid

    });

   

    var total = total_sale_price-discounts;
    var paids = (total-pa);
    
    // $('.total').html(total);1156850.5
    $('#debt').html(paids);//11,568,50.50
    
});

$(document).on('keyup change','.quantity',function (e) {
    e.preventDefault();
    
    calculate_totalPrice()
});
$(document).on("click",'.remove_order',function(e){
    e.preventDefault();
    var id =$(this).data('id');
    // $('.rowOrder'+id).remove();
    $(this).closest('tr').remove();
    $('#prodcut'+id).removeClass('disabled btn-default').addClass('btn-primary');
    calculate_totalPrice();
});
function calculate_totalPrice() {
    var total_sale_price=0;
    var discounts = 0;
    var total_paidd=0;
    var id=0;
    var total_sale_priceArray=[];
    var discountsArray=[];
    $('.orders_table .paid').each(function (index) {
    });

    // console.log($('#quantity'+$id).val());
    $('.orders_table .sale_price').each(function (index) {
        // $(this).closest('tr').find('');
        var  this_sale_price = parseFloat($(this).val().replace(/,/g,''));

         id =$(this).data('id');
         var this_quantity = parseFloat($('#quantity'+id).val().replace(/,/g,''));
        total_sale_price+=parseFloat(this_sale_price*this_quantity);
        total_sale_priceArray[id]=(this_sale_price*this_quantity);

    });

    $('.orders_table .discount').each(function (index) {
        discounts+=parseFloat($(this).val().replace(/,/g,''));
        discountsArray[id]=parseFloat($(this).val().replace(/,/g,''));

    });
   

    var total = total_sale_price-discounts;
    var paid = total_sale_priceArray[id]-discountsArray[id];
    total_paidd+=paid;
    // $('.total').html(total);1156850.5
    $('#paid'+id).val(paid);
    $('.total').html($.number(total,2));//11,568,50.50
    $('#debt').html($.number(total-total_paidd,2));//11,568,50.50
    // if(total>0){
    //     $('#submit_order').removeClass('disabled btn-default').addClass('btn-primary');
    // }else{
    //     $('#submit_order').removeClass('btn-primary').addClass('disabled btn-default');

    // }
}
});
        
    </script>
    @endsection














<!-- @section('js')
    <script>
$(document).ready(function () {
$('.add_order').on("click",function(e){
    e.preventDefault();
    var name = $(this).data('name');
    var id = $(this).data('id');
    console.log(id);
    var glasses = $(this).data('glasses');
    var options="";
   
    for(var i=0 ; i<glasses.length;i++ ){
        options+='<option value="'+glasses[i].name+'"></option>';
    }

    var html =`
    <tr>
          <input type="hidden" name="product_ids[]" value="${id}">
        <td>${name}</td>
        <td><input type="number" name="quantity[]" step="1.00"  style='width: 80%;height: 42px;'; class="quantity" data-id="${id}" id="quantity${id}"  value="1"> </td>
        <td><input type="number" name="sale_price[]" step="1.00" style='width: 80%;height: 42px;'; class="sale_price" data-id="${id}"  value="0"> </td>
        <td><input type="number" name="discount[]" step="0.50"  class="discount" style='width: 80%;height: 42px;';  value="0"> </td>
        <td><input type="number" name="paid[]" step="0.50" id="paid${id}"  class="paid" style='width: 100%;height: 42px;';  value="0"> </td>
        <td><input type="number" name="volume[]" step="0.10"  class="volume" style='width: 80%;height: 42px;';  value="0"> </td>
        <td> <input list="glass_names" name="glass_names[]" class="glass_names form-control" style="width: 170%;height: 42px;"  >
        <datalist id="glass_names">

        ${options}
        </datalist>
        </td>
 
        <td><button data-id="${id}" class="btn btn-danger btn-sm remove_order"style="margin-right: 60px;"><i class="fa fa-trash"></i> </button></td>
    </tr>
    `;
    $(this).removeClass('btn-primary').addClass('disabled btn-default');

    $('.orders_table tbody').append(html);
    calculate_totalPrice()
});
$(document).on('keyup change','.discount',function (e) {
    e.preventDefault();
    // var dis =parseFloat($(this).val());
    // console.log(dis);

    calculate_totalPrice()
});
$(document).on('keyup change','.sale_price',function (e) {
    e.preventDefault();
    // var dis =parseFloat($(this).val());
    // console.log(dis);

    calculate_totalPrice()
});
$(document).on('keyup change','.quantity',function (e) {
    e.preventDefault();
    
    calculate_totalPrice()
});
$(document).on("click",'.remove_order',function(e){
    e.preventDefault();
    var id =$(this).data('id');
    // $('.rowOrder'+id).remove();
    $(this).closest('tr').remove();
    $('#prodcut'+id).removeClass('disabled btn-default').addClass('btn-primary');
    calculate_totalPrice();
});
function calculate_totalPrice() {
    var total_sale_price=0;
    var discounts = 0;
    var id=0;
    var total_sale_priceArray=[];
    var discountsArray=[];

    // console.log($('#quantity'+$id).val());
    $('.orders_table .sale_price').each(function (index) {
        // $(this).closest('tr').find('');
         id =$(this).data('id');

        total_sale_price+=parseFloat($(this).val()*$('#quantity'+id).val());
        total_sale_priceArray[id]=($(this).val()*$('#quantity'+id).val());

    });

    $('.orders_table .discount').each(function (index) {
        discounts+=parseFloat($(this).val());
        discountsArray[id]=$(this).val();
    });

    var total = total_sale_price-discounts;

    // $('.total').html(total);1156850.5
    $('#paid'+id).val($.number(total_sale_priceArray[id]-discountsArray[id],2));
    $('.total').html($.number(total,2));//11,568,50.50
    if(total>0){
        $('#submit_order').removeClass('disabled btn-default').addClass('btn-primary');
    }else{
        $('#submit_order').removeClass('btn-primary').addClass('disabled btn-default');

    }
}
});
       
   
      
    </script>
    @endsection -->