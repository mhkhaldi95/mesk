@extends('adminlte.master.master')
@section('content')
@include('adminlte.master.messageserror')
    <section class="content-header">
        <h1>
            المدينين
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i>  الرئيسية</a></li>
            <li><a href="{{route('dashboard.sellers.index')}}"> التجار</a></li>

            <li class="active"> دفع فاتورة</li>
        </ol>
    </section>
    <div class="content">
        <div class="row">
       
            <div class="col-md-12">
                <div class="box box-primary">
                

                    <div class="box-header">
                        <h3 class="box-title"> دفع فاتورة</h3>
                        <div class="box-tools">
                        </div>
                    </div>

                    <table class="table table-hover" id="table">
                        <thead></thead>
                        <tbody>

                            <tr>

                                <th>الدين</th>
                                <th>سداد الدين</th>
                                <th>الاعدادات</th>

                            </tr>

                            <tr id="tr_{{$seller->id}}">
                            <form method="POST" action="{{route('dashboard.sellers.edit_debt',[$seller->id,$order->id])}}">
                                @csrf
                                <td><input type="number" readonly name="debt" step="0.50"   class="debt" style='width: 60%;height: 42px;'   value="{{$debt[0]->total_payments}}"> </td>
                                <td><input type="number" name="refund" step="0.50" min="0" data-debt="{{$debt[0]->total_payments}}" required  class="refund" style='width: 60%;height: 42px;'  value="0"> </td>
                                <td>
                                    <button type="submit"  class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>سداد</button>
                                 </td>
                                </form>
                            </tr>



               
                </tbody>
                        <tfoot></tfoot>
               
            </table>

                </div>
            </div>
          
        </div>
    </div>


@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('keyup change','.refund',function (e) {
                e.preventDefault();
                var debt =$(this).data('debt');
                var value =parseFloat($(this).val());

                if(value >(-debt)){
                    $('.refund').val(-debt);
                }

            });
        });
    </script>
@endsection

