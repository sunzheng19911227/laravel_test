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
                            管理员添加
                        </header>
                        <div class="panel-body">
                            <form role="form" class="form-horizontal adminex-form" method="POST" action="{{ url('/admin/admins') }}">
                                {{ csrf_field() }}
                                <!--   class样式说明  has-success:成功 has-error:错误 has-warning:警告    -->
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">name</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                        <p class="help-block">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">email</label>
                                    <div class="col-lg-10">
                                        <input type="email" placeholder="" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                        <p class="help-block">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">password</label>
                                    <div class="col-lg-10">
                                        <input type="password" placeholder="" id="password" name="password" class="form-control">
                                        @if ($errors->has('password'))
                                        <p class="help-block">{{ $errors->first('password') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">Confirm Password</label>
                                    <div class="col-lg-10">
                                        <input type="password" placeholder="" id="password_confirmation" class="form-control" name="password_confirmation">
                                        @if ($errors->has('password_confirmation'))
                                        <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
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
