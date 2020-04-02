  <!-- ajax pagination -->
                        <table class="table table-hover" id="load">
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
                            @foreach($products as $index=>$product)
                                <tr id="tr_{{$product->id}}">
                                    <td>{{$index+1}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->sequenceNo}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->purchase_price}}</td>
                                    <td>{{$product->whole_stoke}}</td>
                                    <td>{{$product->retail_stoke}}</td>

                                    <td>
                                        @if(auth()->user()->hasPermission('delete_products'))
                                        <!-- <a href="{{route('dashboard.products.destroy',$product->id)}}" id="delete" class="btn btn-danger "> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a> -->

                                            <a data-value="{{$product->id}}" id="delete" class="btn btn-danger  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a>
                                        @else
                                            <a data-value="" id="delete" class="btn btn-danger disabled  remove-project"> <i class="fa fa-trash" aria-hidden="true"></i>حذف</a>

                                        @endif
                                        @if(auth()->user()->hasPermission('update_products'))
{{--                                            <a data-value="{{$product->id}}" class="btn btn-info editu" data-toggle="modal" data-target="#editproduct" href=""><i class="fa fa-edit" aria-hidden="true"></i></a>--}}
                                                <a href="{{route('dashboard.products.edit',[$product->id])}}" class="btn btn-info editu"  ><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>
                                        @else
                                                <a data-value="" class="btn btn-info editu disabled" data-toggle="modal" data-target="#editproduct" href=""><i class="fa fa-edit" aria-hidden="true"></i>تعديل</a>

                                        @endif

                                    </td>

                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"> 
                                    {{--<a href="#" data-toggle="modal" data-target="#addcategory" style="margin-right: 0px;" class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>--}}
                                    @if(auth()->user()->hasPermission('create_categories'))
                                            <a href="{{route('dashboard.products.create')}}" style="width: 40%;"  class="btn btn-primary"><i class="fa fa-plus"></i>اضافة</a>
                                        @else
                                            <a href="" style="width: 40%;" class="btn btn-primary disabled"><i class="fa fa-plus"></i>اضافة</a>

                                        @endif
                                    </th>
                                    <th colspan="4"></th>
                                </tr>
                            </tfoot>
                        </table>
                        {{!!$products->links()!!}}
                      