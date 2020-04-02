@extends('adminlte.master.master')
@section('content')
                    @php
                     $create='اضافة';
                        $update ='تعديل';
                     @endphp
    <section class="content-header">
        <h1>
            الأصناف
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active"> الأصناف</li>
        </ol>
    </section>
    <div class="content">
    @if(session('success'))
        <script>
            new Noty({
                type:'success',
                layout:'center',
                text:'تمت الاضافة بنجاح',
                timeout:2000,
                killer:true
            }).show();
        </script>
    @endif
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">

                    <div class="box-header">
{{--                     هان بجيب العدد على حسب الباجينيشن   {{count($categories)}}--}}
                        <h3 class="box-title"> الأصناف<small>{{count($categories)}}</small></h3>

                        <div class="box-tools">
                            <form method="get" action="{{route('dashboard.categories.index')}}">

                                <div class="input-group input-group-sm hidden-xs" style="width: 250px;">

                                    <!-- <input type="text" name="search" class="form-control pull-right" placeholder="بحث" value="{{request()->search}}"> -->

                                    <div class="input-group-btn">

                                        <!-- <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button> -->
{{--                                        <a href="#" data-toggle="modal" data-target="#addcategory" style="margin-right: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>--}}
                                    <!-- @if(auth()->user()->hasPermission('create_categories')) -->
                                            <!-- <a href="{{route('dashboard.categories.createview')}}"  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a> -->
                                        <!-- @else -->
                                            <!-- <a href=""  class="btn btn-primary disabled"><i class="fa fa-plus"></i>اضافة</a> -->

                                        <!-- @endif -->
                                    </div>

                                </div>

                                <div class="input-group input-group-sm hidden-xs" style="width: 250px; display:inline-block;">




                                </div>

                            </form>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                    <div class="error"></div>
                    @include('adminlte.master.messageserror')

                        @if(count($categories)>0)
                        <table class="table table-hover category_data_table" id="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>عدد العطور التي تنتمي له</th>
                                    <th>الاعدادات</th>

                                </tr>
                            </thead>
                            <tbody>

                           
                                    @foreach($categories as $index=>$category)
                                        <tr id="tr_{{$category->id}}">
                                            <td>{{$index+1}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->products->count()}}</td>
                                            <td>
                                                @if(auth()->user()->hasPermission('delete_categories'))
                                                
                                                <!-- <a href="{{route('dashboard.categories.destroy',$category->id)}}" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a> -->
                                            <a data-value="{{$category->id}}" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a>
                                                @else
                                                    <a data-value="" id="delete" class="btn btn-danger disabled  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a>

                                                @endif
                                                @if(auth()->user()->hasPermission('update_categories'))
        {{--                                                <a data-value="{{$category->id}}" class="btn btn-info editu" data-toggle="modal" data-target="#editcategory" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                                        <a href="{{route('dashboard.categories.edit',[$category->id])}}" class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>
                                                @else
                                                        <a data-value="" class="btn btn-info editu disabled" data-toggle="modal" data-target="#editcategory" href=""><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>

                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach


                            </tbody>
                            <tfoot>
                               <th colspan="4">
                                    <a style="width:20%;" href="{{route('dashboard.categories.createview')}}"  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>
                                    <!-- <a href="#" data-toggle="modal"  data-target="#addcategory" style="margin-right: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a> -->
                                </th>
                               
                            </tfoot>
                        </table>
                           
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>

<!-- modal -->
<!--<div class="modal fade"  id="addcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                
                    <h3 class="modal-title">{{$create}}</h3>

                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                                    <form role="form" id="Add_category" method="post" action="javascript:void(0)" >
                                        @csrf
                                        <div class="box-body">
                    
                                                <div class="form-group">
                                                    <label for="name">اسم الصنف</label>
                                                    <input type="text" class="form-control"   name="name" id="name" required   placeholder="اسم الصنف">
                                                </div>
                                        

                                        </div>

                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">اضافة</button>
                                        </div>
                                    </form>
                </div>
                
                </div>
            </div>
    </div>
    <div class="modal fade"  id="addcategorye" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                            <form role="form" id="EditCategort" method="post"  action="{{isset($category)?'/dashboard/categories/update/'.$category->id:'/dashboard/categories/create'}}">
                                @csrf
                                <div class="box-body">
            
                                        <div class="form-group">
                                            <label for="name">اسم الصنف</label>
                                            <input type="text" class="form-control"   name="name" id="name" required value="{{isset($category)?$category->name:''}}"  placeholder="اسم الصنف">
                                        </div>
                                

                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">اضافة</button>
                                </div>
                            </form>
        </div>
        
        </div>
    </div>
    </div> -->
@endsection
@section('js')
<script>
   $(document).ready(function() {
    $('.category_data_table').DataTable( {
        "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Arabic.json"
            },
        'pagingType':'full_numbers',
        'lengthMenu':[[10,20,30,40,-1],[10,20,30,40,'الكل']],
    });
    });
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
                        url: "/dashboard/categories/delete/"+id,
                        data:{body:'',_token:'{{csrf_token()}}'},
                        success: function (response) {
                            var count = $('table tr').length;

                            $( "#tr_"+id).remove();
                            // swal("@lang('pos.Poof deleted')", {
                            //     icon: "success",
                            // });
                            if(count == 2){
                                location.reload();
                            }
                        }

                    })

                } else {
                    swal("@lang('pos.file is safe')");
                }
    });
  
});
</script>
<script>
        //addcategory
        $('#Add_category111').submit(function(e){
            e.preventDefault(); // avoid to execute the actual submit of the form.

            
                var form = $(this);
            $.ajax({
                    method:"POST",
                    url: "{{route('dashboard.categories.create')}}",
                    data: form.serialize(), // serializes the form's elements.
                    success:function(data)
                    {
                        var count = $('table tr').length;
                       var rowCategory = `
                       
                       <tr id="${data.data.id}">
                                            <td>${count}</td>
                                            <td>${data.data.name}</td>
                                            <td>0</td>
                                            <td><a href="" class="btn btn-info"  >عرض</a></td>
                                            <td>
                                                
                                            <a data-value="" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a>
                                            <a href="" class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>
                                               

                                            </td>

                                        </tr>`;
                             $('#addcategory').modal("hide");
                            $('#table tbody').append(rowCategory);
                        }
                        
                   
                }).fail(function() {
                alert( "error" );
                })
           
        });
      

        //updatecategory
        // $(document).ready(function(){
        //     var id;

        //     $(document).on("click",'.editu',function (event) {
        //         x=event;
        //         target = $(x.target).parent().parent().parent();
        //         id=$(this).data('value');
        //     });


        //     $('#edit').on('submit', function(event){

        //         event.preventDefault();
        //         $('#nameeError').addClass('d-none');
        //         $('#emaileError').addClass('d-none');
        //         $('#passwordeError').addClass('d-none');
        //         $('#passwordceError').addClass('d-none');
        //         $.ajax({
        //             url: "/dashboard/categories/edit/"+id,
        //             method:"POST",
        //             data:new FormData(this),
        //             dataType:'JSON',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             success:function(data)
        //             {

        //                 var count = $('table tr').length;

        //                     $('#editcategory').modal("hide");
        //                     var row = '   <tr id="tr_'+data.data.id+'">\n' +
        //                         '                                    <td >'+count+'</td>\n' +
        //                         '                                    <td>'+data.data.name+'</td>\n' +
        //                         '                                    <td>'+data.data.email+'</td>\n' +
        //                         '\n' +
        //                         '                                   <td>\n' +
        //                         '<a data-value="'+data.data.id+'" id="delete" class="btn btn-danger delete-post-link remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
        //                         '<a data-value="'+data.data.id+'" class="btn btn-info editu" data-toggle="modal" data-target="#editcategory" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
        //                         '</td>\n' +
        //                         '\n' +
        //                         '</tr>';
        //                 var ro = '<tr id="tr_'+data.data.id+'">\n' +
        //                     '<td >'+count+'</td>\n' +
        //                     '<td>'+data.data.name+'</td>\n' +
        //                     '<td>'+data.data.email+'</td>\n' +
        //                     '\n' +
        //                     '<td>\n' +
        //                     '<a data-value="'+data.data.id+'" id="delete" class="btn btn-danger delete-post-link remove-project"> <i class="fa fa-trash" aria-hidden="true"></i></a>\n' +
        //                     '<a data-value="'+data.data.id+'" class="btn btn-info editu" data-toggle="modal" data-target="#editcategory" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>\n' +
        //                     '</td>\n' +
        //                     '</tr>';
        //                     target.replaceWith(row);

        //                 },
        //             error:function (data) {
        //                 var errorss = data.responseJSON;
        //                 if($.isEmptyObject(errorss) == false){
        //                     $.each(errorss.errors,function (key,value) {
        //                         var ErrorID = '#'+key+'Error';
        //                         $(ErrorID).removeClass('d-none');
        //                         $(ErrorID).text(value);
        //                     })
        //                 }
        //             }

        //         })

        //     });

        // });

</script>
    @endsection