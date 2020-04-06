@extends('adminlte.master.master')
@section('content')

        <section class="content-header">



            <h1>
               المصروفات
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
                <li><a href="{{route('dashboard.users.Expenses_view')}}"> المصروفات</a></li>

                <li class="active">  اضافة</li>
            </ol>
        </section>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">اضافة</h3>

                    </div>
                    @include('adminlte.master.messageserror')
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form role="form" id="ad" method="post"  action="/dashboard/users/Expenses_Store" enctype="multipart/form-data">
                            @csrf

                            <div class="box-body">
                            <div class="form-group">
                                    <label for="amount">المبلغ</label>
                                    <input type="number" class="form-control"   name="amount" id="amount"  value="{{old('stoke')}}"  placeholder="المبلغ">
                                </div>
                                    <div class="form-group">
                                        <label for="description">الوصف</label>
                                        <textarea type="text" class="form-control"   name="description" id="description"   placeholder="الوصف">{{old('description')}}</textarea>
                                </div>
                             
                  
                                
                            </div>


                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">أضف</button>
                            </div>
                        </form>

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

        

    </script>
    @endsection