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
                     


                        <div class="col">
                                    <div class="card card-body">
                                        <table class="table table-hover table_products" id="add_order">
                                           
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
                                        

                                            </tbody>
                                          
                                        </table>
                                    </div>
                               
                        </div>
                       

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
                        @include('adminlte.master.messageserror')

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

                            <div class="card card-body">
                                <form method="post"  action="{{route('dashboard.clients.orders.store',$client->id)}}">
                                    @csrf
                                <table class="table table-hover orders_table" id="table">
                                    <tbody>

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

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th>المجموع</th>
                                        <th class="total">0</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                       
                                        
                                        </tr>
                                        <tr>
                                        <th>الدين</th>
                                        <th id="debt">0</th>
                                        <th>نوع الطلب</th>
                                        <th>
                                        <label for="whole">جملة</label>
                                           <input type="radio" id="whole" name="order" value="whole">
                                        </th>
                                       
                                        <th>
                                        <label for="retail">مفرق</label>
                                           <input type="radio" id="retail" checked="checked" name="order" value="retail">
                                        </th>
                                        </tr>
                                    </tfoot>

                                </table>
                                <input type="hidden" class="total" name="total">

                                    
                                    <div>
                                        <input type="submit" class="btn btn-default disabled"  id="submit_order" style="align-content: center;width: 100%" value="اضافة">

                                    </div>
                                </form>



                            </div>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">الطلبيات السابقة</h3>
                        <div id="old_orders">
                        @include('adminlte.dashboardview.Clients.Orders.load')
                        </div>
                          
                    
                    </div>
                  
                                        <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

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
        $('.table_products').DataTable( {
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                },
            'pagingType':'full_numbers',
            'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
            processing: true,
serverSide: true,
ajax: '{!! route('datatables.showProducts_order') !!}',
columns: [
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'whole_stoke', name: 'whole_stoke' },
{ data: 'retail_stoke', name: 'retail_stoke' },
{ data: 'action', name: 'action' },


]
});
        $('.table_old_category').DataTable( {
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
                },
            'pagingType':'full_numbers',
            'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
        });

//----------------------------
//ajax pagination
        var client_id =$('#client_id').data('client_id');  
   $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];  
        fetch_data(page);
    });
    function  fetch_data(page) {
       
        $.ajax({
            url : '/dashboard/clients/orders/create/fetch_data/'+client_id+'?page='+page,
            success:function (data) {
            $('#old_orders').html(data);  
        },
        
        
    });
}



    });
    $(document).ready(function () {

  $(document).on("click",'.add_product',function(e){
    e.preventDefault();
    var name = $(this).data('name');
    var id = $(this).data('value');
    var options = '<option value="'+0+'"></option>';
    $.ajax({
            method:'GET',
            url: "/dashboard/categories/index",
            data:{body:'',_token:'{{csrf_token()}}'},
            success: function (response) {
                for(var i=0 ; i<response.glasses.length;i++ ){
                     options += `<option value="${response.glasses[i].id}">${response.glasses[i].name}</option>`;
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
        <td>
            <select class="form-control" name="glass_ids[]" style="width: 250%;height: 100%;" >
                ${options}
            </select>
        </td>
        <td><button data-id="${id}" class="btn btn-danger btn-sm remove_order"style="margin-right: 60px;"><i class="fa fa-trash"></i> </button></td>
    </tr>
    `;
    $(this).removeClass('btn-primary').addClass('disabled btn-default');

    $('.orders_table tbody').append(html);
    calculate_totalPrice()
    
    }
    })
    
   
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
    $('#xyz').html($.number(total-total_paidd,2));//11,568,50.50
    if(total>0){
        $('#submit_order').removeClass('disabled btn-default').addClass('btn-primary');
    }else{
        $('#submit_order').removeClass('btn-primary').addClass('disabled btn-default');

    }
}
});
        
    </script>
    @endsection
   