<!-- left side start-->
<div class="left-side sticky-left-side">

    <!--logo and iconic logo start-->
    <div class="logo">
        <a href="index.html"><img src="{{ asset('/assets/admin/images/logo.png') }}" alt=""></a>
    </div>

    <div class="logo-icon text-center">
        <a href="index.html"><img src="{{ asset('/assets/admin/images/logo_icon.png') }}" alt=""></a>
    </div>
    <!--logo and iconic logo end-->


    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                <img alt="" src="images/photos/user-avatar.png" class="media-object">
                <div class="media-body">
                    <h4><a href="editable_table.html#">John Doe</a></h4>
                    <span>"Hello There..."</span>
                </div>
            </div>

            <h5 class="left-nav-title">Account Information</h5>
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li><a href="editable_table.html#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                <li><a href="editable_table.html#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                <li><a href="editable_table.html#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>
        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked custom-nav">
            <li class="menu-list nav-active"><a href="#"><i class="fa fa-home"></i> <span>后台管理</span></a>
                <ul class="sub-menu-list">
                    <li><a href="{{ url('admin') }}">首页</a></li>
                </ul>
            </li>
            @foreach($menus as $menu)
            <li class="menu-list"><a href="#"><i class="fa"></i> <span>{{ $menu['label'] }}</span></a>
                @if(isset($menu['menus']))
                <ul class="sub-menu-list">
                    @foreach($menu['menus'] as $m)
                    <li><a href="{{ $m['route'] }}">{{ $m['label'] }}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach

        </ul>
        <!--sidebar nav end-->
    </div>
</div>
<!-- left side end-->