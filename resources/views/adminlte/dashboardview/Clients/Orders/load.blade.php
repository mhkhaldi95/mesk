                    <div data-client_id="{{$client->id}}" id="client_id"></div>
                    @foreach($orders as $order)
                            <div class="form-group">
                                <a class="form-control" data-toggle="collapse" href="#{{$order->created_at->format('d-m-Y-s')}}" role="button" aria-expanded="false" aria-controls="order_old{{$order->id}}"  readonly="">{{$order->created_at->format('Y-m-d h:i:s')}}</a>

                            </div>


                      <div class="col">
                                <div class="collapse multi-collapse" id="{{$order->created_at->format('d-m-Y-s')}}">
                                    <div class="card card-body">
                                        <table class="table table-hover " >
                                       
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>الكمية</th>
                                                <th> سعر البيع</th>
                                               
                                                <th>تاريخ الطلبية </th>
                                            </tr>
                                            </thead>
                                          
                                            <tbody>
                                          
                                          
                                            @foreach($order->products as $index=>$product)

                                                    <tr id="tr_{{$index+1}}">
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$product->name}}</td>
                                                    <td>{{number_format($product->pivot->quantity,2)}}</td>
                                                    <td>{{number_format(($product->pivot->quantity*$product->pivot->sale_price)-$product->pivot->discount,2)}}</td>
                                                    <td>{{$order->created_at->toFormattedDateString()}}</td>


                                                </tr>
                                             
                                                @endforeach
                                               
                                                
                                            

                                            </tbody>
                                          
                                            <tfoot>
                                            <tr>
                                                <th> المبلغ الاجمالي</th>
                                                <th class="total" >{{$order->total_price}}</th>
                                            </tr>  
                                             
                                            </tfoot>
                                        </table>
                                        

                                    </div>
                                </div>
                            </div>
                            
                 

                            @endforeach
                            {!! $orders->links() !!}