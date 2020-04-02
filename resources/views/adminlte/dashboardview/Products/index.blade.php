@extends('adminlte.master.master')
@section('content')
    <section class="content-header">
        <h1>
            العطور
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active"> العطور</li>
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
                                <th>الصنف</th>
                                <th>سعر الشراء</th>
                                <th>مخزون الجملة</th>
                                <th>مخزون المفرق</th>
                                <th>الاعدادات</th>

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
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
'lengthMenu':[[6,10,20,30,40,-1],[6,10,20,30,40,'الكل']],
processing: true,
serverSide: true,
ajax: '{!! route('datatables.products') !!}',
columns: [
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'sequenceNo', name: 'sequenceNo' },
{ data: 'category_id', name: 'category_id' },
{ data: 'purchase_price', name: 'purchase_price' },
{ data: 'whole_stoke', name: 'whole_stoke' },
{ data: 'retail_stoke', name: 'retail_stoke' },
{ data: 'action', name: 'action' },


]

});
var row =` <tfoot>
                               <th colspan="4">
                                    <a style="width:50%;" href="{{route('dashboard.products.create')}}"  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>
                                    <!-- <a href="#" data-toggle="modal"  data-target="#addcategory" style="margin-right: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a> -->
                                </th>
                               
                            </tfoot>`;
$('#table').append(row);

 
//ajax pagination
   // $('body').on('click', '.pagination a', function(e) {
    //     e.preventDefault();

    //     var page = $(this).attr('href').split('page=')[1];  
    //     fetch_data(page);
    // });
//     function  fetch_data(page) {
//         console.log(page);
//         $.ajax({
//             url : '/dashboard/products/index/fetch_data?page='+page,
//             success:function (data) {
//             $('#products').html(data);  
//         },
        
        
//     });
// }
    });






       //live_search
    // live_search();
    // function live_search(query = ''){
    //     $.ajax({
    //         url : ''dashboard.products.live_search.action,
    //         method:'GET',
    //         data:{query:query},
    //         dataType:'json',
    //         success:function (data) {
    //         $('tbody').html(data.table_data);  
    //     },
    // })
    // }
    // $(document).on('keyup', '#live_search', function() {
    //     var query = $(this).val();
    //     console.log(query);
    //     live_search(query);
    // });
</script>
    <script>
        $(document).on("click",'.remove-project',function(){
            var id=$(this).data('value');

            swal({
                title: "@Lang('pos.sure')",
                text: "@lang('pos.Once deleted')",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {

                    $.ajax({
                        method:'POST',
                        url: "/dashboard/products/delete/"+id,
                        data:{body:'',_token:'{{csrf_token()}}'},
                        success: function (response) {
                            var count = $('table tr').length;

                            $( "#tr_"+id).remove();
                           
                            if(count == 2){
                                location.reload();
                            }
                        }

                    })

                } 
            });
        });

    </script>
  
    @endsection


 