<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{auth()->user()->image_path}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{auth()->user()->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> نشط</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
           @if(auth()->user()->hasPermission('read_users'))
            <li class="header"><a href="{{route('dashboard.users.index')}}" ><i class="fa fa-th"></i>المسؤول</a></li>
            @endif
               @if(auth()->user()->hasPermission('read_clients'))
                   <li class="header"><a href="{{route('dashboard.clients.index')}}" ><i class="fa fa-th"></i>الزبون</a></li>
               @endif

                   <li class="header"><a href="{{route('dashboard.sellers.index')}}" ><i class="fa fa-th"></i>التجار</a></li>

            @if(auth()->user()->hasPermission('read_categories'))
                <li class="header"><a href="{{route('dashboard.categories.index')}}" ><i class="fa fa-th"></i>الأصناف</a></li>
            @endif

            @if(auth()->user()->hasPermission('read_products'))
                <li class="header"><a href="{{route('dashboard.products.index')}}" ><i class="fa fa-th"></i>العطور</a></li>
            @endif
            @if(auth()->user()->hasPermission('read_orders'))
                <li class="header"><a href="{{route('dashboard.orders.index')}}" ><i class="fa fa-th"></i>الطلبات</a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>