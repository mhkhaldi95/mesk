@extends('adminlte.master.master')
@section('content')
    <section class="content-header">
        <h1>
            المصروفات
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active"> المصروفات</li>
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
                                <th>الكمية</th>
                                <th>الوصف </th>
                                <th>تاريخ الصرف </th>
                               

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
ajax: '{!! route('datatables.getExpense') !!}',
columns: [
{ data: 'id', name: 'id' },
{ data: 'amount', name: 'amount' },
{ data: 'description', name: 'description' },
{ data: 'created_at', name: 'created_at' },
]

    })});
    var row =` <tfoot>
                               <th colspan="2">
                                    <a style="width:50%;" href="{{route('dashboard.users.Expenses_create')}}"  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>
                                </th>
                               
                            </tfoot>`;
$('#table').append(row);
    </script>
  
    @endsection

 

    
 