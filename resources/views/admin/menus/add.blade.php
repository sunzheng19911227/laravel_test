<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="form_validation.html#" type="image/png">

  <title>Form Validation</title>

  <!--common-->
  <link href="{{ asset('/assets/admin/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('/assets/admin/css/style-responsive.css') }}" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

    <section>
        <!-- left side start-->
        @include('layouts.admin_left')
        <!-- left side end-->

        <!-- main content start-->
        <div class="main-content" >

            <!-- header section start-->
            <div class="header-section">

                <!--toggle button start-->
                <a class="toggle-btn"><i class="fa fa-bars"></i></a>
                <!--toggle button end-->

                <!--search start-->
                <form class="searchform" action="index.html" method="post">
                    <input type="text" class="form-control" name="keyword" placeholder="Search here..." />
                </form>
                <!--search end-->

                <!--notification menu start -->
                @include('layouts.admin_header')
                <!--notification menu end -->

            </div>
            <!-- header section end-->

            <!-- page heading start-->
            <div class="page-heading">
                <h3>
                    Form Validation
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="form_validation.html#">Form</a>
                    </li>
                    <li class="active"> Form Validation </li>
                </ul>
            </div>
            <!-- page heading end-->

            <!--body wrapper start-->
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                菜单添加
                            </header>
                            <div class="panel-body">
                                <form role="form" class="form-horizontal adminex-form" method="POST" action="{{ url('/admin/menus') }}">
                                    {{ csrf_field() }}
                                    <!--   class样式说明  has-success:成功 has-error:错误 has-warning:警告    -->
                                    <div class="form-group{{ $errors->has('pid') ? ' has-error' : '' }}">
                                        <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">上级菜单</label>
                                        <div class="col-lg-10">
                                            <select class="form-control m-bot15" name="pid">
                                                <option value="0">顶级分类</option>
                                                @foreach($lists as $list)
                                                <option value="{{ $list['id'] }}">{{ $list['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-lg-2 control-label">菜单名称</label>
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                            <p class="help-block">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                        <label class="col-lg-2 control-label">权限认证标识</label>
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="" id="label" name="label" class="form-control" value="{{ old('label') }}">
                                            @if ($errors->has('label'))
                                            <p class="help-block">{{ $errors->first('label') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('route') ? ' has-error' : '' }}">
                                        <label class="col-lg-2 control-label">路由地址</label>
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="" id="route" name="route" class="form-control" value="{{ old('route') }}">
                                            @if ($errors->has('route'))
                                            <p class="help-block">{{ $errors->first('route') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        <label class="col-lg-2 control-label">说明</label>
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="" id="description" class="form-control" name="description" value="{{ old('description') }}">
                                            @if ($errors->has('description'))
                                            <p class="help-block">{{ $errors->first('description') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">是否显示</label>
                                        <div class="col-md-7">
                                            <label class="radio-inline">
                                                <input type="radio" name="is_display" checked="checked" value="1"> 
                                                显示
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_display" value="0"> 
                                                隐藏
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                                        <label class="col-lg-2 control-label">排序</label>
                                        <div class="col-lg-10">
                                            <input type="text" placeholder="" id="sort_order" class="form-control" name="sort_order" value="{{ old('sort_order') }}">
                                            @if ($errors->has('sort_order'))
                                            <p class="help-block">{{ $errors->first('sort_order') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
            <!--body wrapper end-->

            <!--footer section start-->
            <footer>
                2014 &copy; AdminEx by ThemeBucket
            </footer>
            <!--footer section end-->


        </div>
        <!-- main content end-->
    </section>

    <!-- Placed js at the end of the document so the pages load faster -->
    <script src="{{ asset('/assets/admin/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/jquery.nicescroll.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/assets/admin/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/validation-init.js') }}"></script>

    <!--common scripts for all pages-->
    <script src="{{ asset('/assets/admin/js/scripts.js') }}"></script>

</body>
</html>
