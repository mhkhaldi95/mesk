@extends('adminlte.master.master')
@section('content')
@include('adminlte.master.messageserror')
    <section class="content-header">
        <h1>
            المدينين
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li class="active"> المدينين</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
       
            <div class="col-md-12">
                <div class="box box-primary">
                

                    <div class="box-header">
                        <h3 class="box-title"> المدينين<small>{{count($Debtors)}}</small></h3>
                        <div class="box-tools">
                            <form method="get" action="{{route('dashboard.clients.debts')}}" >

                                <div class="input-group input-group-sm hidden-xs" style="width: 250px;">

                                        <input type="text" name="search" class="form-control pull-right" placeholder="بحث" value="{{request()->search}}">

                                            <div class="input-group-btn">

                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        
                       
                                            </div>

                                </div>

                                <div class="input-group input-group-sm hidden-xs" style="width: 250px; display:inline-block;">
                                </div>

                            </form>
                        </div>  
                    </div>
                    @if(count($Debtors)>0)
                    <table class="table table-hover" id="table">
                        <tbody>

                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>رقم الهاتف</th>
                                <th>العنوان</th>
                                <th>الدين</th>
                                <th>سداد الدين</th>
                                <th>الاعدادات</th>

                            </tr>
                @foreach($Debtors as $index=>$Debtor)
                            <tr id="tr_{{$Debtor->id}}">
                            <form method="get" action="{{route('dashboard.clients.editDebts',$Debtor->id)}}">
                                <td>{{$index+1}}</td>
                                <td>{{$Debtor->name}}</td>
                                <td>{{is_array($Debtor->phone)?implode('-', array_filter($Debtor->phone)):$Debtor->phone}}</td>
                                <td>{{$Debtor->address}}</td>
                                <td><input type="number" readonly name="debt" step="0.50" id="debt{{$Debtor->id}}"  class="debt" style='width: 60%;height: 42px;'  value="{{$client_debts[$index]}}"> </td>
                                <td><input type="number" name="refund" step="0.50" min="0"   class="refund" style='width: 60%;height: 42px;'  value="0"> </td>


                                <td>
                                    
                                <a href="{{route('dashboard.clients.showDebts',$Debtor->id)}}" class="btn btn-info btn-sm"  ><i class="fa fa" aria-hidden="true"></i> عرض التفاصيل</a>
                                    
                                </td>
                                <td>
                                
                                    <a href="" id="delete" class="btn btn-danger "> <i class="fa fa-trash" aria-hidden="true"></i>خذف</a>
                                        <!-- <a data-value="{{$Debtor->id}}" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>@lang('pos.delete')</a> -->

                    {{--                                                <a data-value="{{$Debtor->id}}" class="btn btn-info editu" data-toggle="modal" data-target="#editDebtor" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                            <button type="submit"  class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</button>


                                </td>
                                </form>
                            </tr>
                @endforeach
                @php
                    $totaltext = "مجموع الدين الكلي = ";
                @endphp
                <tr>
                    <th></th>
                    <th></th>
                    
                    <th></th>
                    <th></th>
                    <td colspan="3" style='width: 30%'> {{$totaltext}} <b>{{-$total_debts}} </b>  شيكل</td>
                    <td></th>
                    
                    <td></td>
                </tr>
               
                </tbody>
               
            </table>
            @else
                            <h2>لا يوجد مدينين</h2>
             @endif
                </div>
            </div>
          
        </div>
    </div>

                  
     <!-- /.box-header -->
 

           
                    
                   



@endsection

