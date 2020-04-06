@extends('adminlte.master.master')
@section('content')
    <!-- <section class="content-header">
        <h1>
            شركة عطور مسك الجنان
            <small>لوحة تحكم</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> الرئيسية</li>
        </ol>
    </section> -->
    <div class="content-wrapper" style="min-height: 926px;margin-right: 0px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            شركة عطور مسك الجنان
            <small>لوحة تحكم</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> الرئيسية</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$products_count}}</h3>

              <p>العطور</p>
            </div>
            <div class="icon">
            <img src="https://img.icons8.com/color/96/000000/perfume-bottle.png"/>
            </div>
            <a href="{{route('dashboard.products.index')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$categories_count}}</h3>

              <p>الأصناف</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{route('dashboard.categories.index')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
   
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$clients_count}}</h3>

              <p>الزبائن</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="{{route('dashboard.clients.index')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{count($Debtors)}}</h3>

              <p>المدينين</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="{{route('dashboard.clients.debts')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$sales_count}}</h3>

              <p>المبيعات</p>
            </div>
            <div class="icon" style="position: absolute;top: 5px;">

              <i class="iconify" data-icon="fa-solid:cart-plus" data-inline="false"></i>
            </div>
            <a href="{{route('dashboard.orders.show_sales_view')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{count( $best_sales)}}</h3>

              <p>أكثر المنتجات مبيعا</p>
            </div>
            <div class="icon">

              <i class="ion ion-pie-graph" ></i>
            </div>
            <a href="{{route('dashboard.products.Best_selling_products')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$expenses_count}}</h3>

              <p>المصروفات</p>
            </div>
            <div class="icon">
            <img src="https://img.icons8.com/wired/80/000000/cost.png"/>
            </div>
            <a href="{{route('dashboard.users.Expenses_view')}}" class="small-box-footer">معلومات أكثر <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
    <!-- /.box -->

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-th"></i>

              <h3 class="box-title">المبيعات</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart"
               style="height: 250px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
            
              
             
            </div>
            <!-- /.box-body -->
           <!-- /.box-footer -->
          </div>
          <!-- /.box -->

          <!-- Calendar -->
         <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>


@endsection
@section('js')
<script>
 var sum="المجموع";
var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: [
        @foreach($sales as $sale)
      {ym: "{{$sale->year}}-{{$sale->month}}", total: "{{$sale->total}}"},
      @endforeach
    ],
    xkey: 'ym',
    ykeys: ['total'],
    labels: [sum],
    lineColors: ['#efefef'],
    lineWidth: 2,
    hideHover: 'auto',
    gridTextColor: "#fff",
    gridStrokeWidth: 0.4,
    pointSize: 4,
    pointStrokeColors: ["#efefef"],
    gridLineColor: "#efefef",
    gridTextFamily: "Open Sans",
    gridTextSize: 10
  });
  </script>
@endsection