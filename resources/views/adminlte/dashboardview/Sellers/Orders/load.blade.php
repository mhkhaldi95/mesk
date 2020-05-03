                    <div data-seller_id="{{$seller->id}}" id="seller_id"></div>


                      <div class="col">
                                    <div class="card card-body">
                                        <table class="table table-hover " >
                                       
                                            <thead>
                                            <tr>
                                                <th>#</th>

                                                <th> سعر الطلبية</th>
                                               
                                                <th>تاريخ الطلبية </th>
                                            </tr>
                                            </thead>
                                          
                                            <tbody>
                                            @foreach($orders as $index=>$order)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$order->total_price}}</td>
                                                <td>{{$order->created_at}}</td>
                                            </tr>

                                            @endforeach
                                               
                                                
                                            

                                            </tbody>
                                          

                                        </table>
                                        

                                    </div>

                            </div>
                            
                 


                            {!! $orders->links() !!}