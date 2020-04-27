<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Misk</b>Aljenan</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
{{--        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">--}}
{{--            <span class="sr-only">Toggle navigation</span>--}}
{{--        </a>--}}
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->


                </li><!-- /.messages-menu -->

                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i > <img src="{{asset('BOD.png')}}" width="20px" height="20px"></i>
                        <span class="label label-warning">{{count($clientsDOB)==0?'':count($clientsDOB)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">لديك {{count($clientsDOB)}}اشعار</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    @foreach($clientsDOB as $client)
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i>
                                        @if(is_array($client->phone))
                                            @foreach($client->phone as $index=>$phone)
                                                <span>{{$phone}}</span>{{$index==0?' - ':''}}
                                            @endforeach
                                            @else  <span>{{$client->phone}}</span>
                                        @endif
                                        {{$client->first_name}}
                                    </a>
                                        @endforeach
                                </li><!-- end notification -->
                            </ul>
                        </li>
{{--                        <li class="footer"><a href="#">View all</a></li>--}}
                    </ul>
                </li>
                <li class="dropdown notifications-menu" >
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i > <img src="{{asset('perfume.png')}}" width="20px" height="20px"></i>
                        <span class="label label-warning">{{count($products_whole_stoke)+count($products_retail_stoke)==0?'':count($products_whole_stoke)+count($products_retail_stoke)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">لديك {{count($products_whole_stoke)+count($products_retail_stoke)}}اشعار</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                <li><!-- start notification -->
                                    @foreach($products_retail_stoke as $product)
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> {{$product->name}}
                                            <span>&nbsp;&nbsp;مفرق :  {{$product->retail_stoke}} مليلتر </span>
                                        </a>
                                    @endforeach
                                    @foreach($products_whole_stoke as $product)
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> {{$product->name}}
                                            <span>&nbsp;&nbsp;جملة :  {{$product->whole_stoke}} مليلتر </span>
                                        </a>
                                    @endforeach

                                </li><!-- end notification -->
                            </ul>
                        </li>
                        {{--                        <li class="footer"><a href="#">View all</a></li>--}}
                    </ul>
                </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{auth()->user()->image_path}}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{auth()->user()->name}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{auth()->user()->image_path}}" class="img-circle" alt="User Image">
                            <p>
                                {{auth()->user()->name}} -  مدير شركة عطور مسك الجنان

                            </p>
                        </li>
                        <!-- Menu Body -->

                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="">
                                <a style="margin: 0px 37%;" class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->

            </ul>
        </div>
    </nav>
</header>