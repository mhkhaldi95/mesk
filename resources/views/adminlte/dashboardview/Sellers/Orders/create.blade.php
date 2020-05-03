@extends('adminlte.master.master')

@section('content')

        <section class="content-header">



            <h1>
                الطلبيات
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li><a href="{{route('dashboard.sellers.index')}}"> التجار</a></li>

                <li class="active">   طلبيات التجار</li>
            </ol>
        </section>

    <div class="content">


        <div class="row">

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">الطلبيات</h3>
                        @include('adminlte.master.messageserror')

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">

                            <div class="card card-body">
                                <form method="post"  action="{{route('dashboard.sellers.orders.store',$seller->id)}}">
                                    @csrf
                                <table class="table table-hover orders_table" id="table">
                                    <thead>

                                    <tr>


                                        <th>مبلغ الطلبية </th>

                                        <th>الدفع</th>


                                    </tr>

                                    </thead>
                                    <tbody>

                                    <tr>


                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" min="1" required  name="total_price"   value="{{isset($seller)?$seller->total_price:old('total_price')}}"  placeholder="سعر الطلبية">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <input type="number" class="form-control" min="0" required  name="paid"   value=""  placeholder="الدفع">
                                            </div>
                                        </td>


                                    </tr>

                                    </tbody>


                                </table>

                                    
                                    <div>
                                        <input type="submit" class="btn btn-primary"  id="submit_order" style="align-content: center;width: 15%" value="أضف">

                                    </div>
                                </form>



                            </div>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            

                <!-- /.box -->
            </div>
        </div>
    </div>



@endsection
@section('js')
<script>

 $(document).ready(function() {



//----------------------------
//ajax pagination
        var seller_id =$('#seller_id').data('seller_id');
   $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        var page = $(this).attr('href').split('page=')[1];  
        fetch_data(page);
    });
    function  fetch_data(page) {
       
        $.ajax({
            url : '/dashboard/sellers/orders/create/fetch_data/'+seller_id+'?page='+page,
            success:function (data) {
            $('#old_orders').html(data);  
        },
        
        
    });
}



    });






        
    </script>
    @endsection
   