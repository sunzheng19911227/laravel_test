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
                            商品添加
                        </header>
                        <div class="panel-body">
                            <form role="form" class="form-horizontal adminex-form" method="POST" action="{{ url('/product/product_sub/'.$data['id']) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="{{ $data['id'] }}">
                                <!--   class样式说明  has-success:成功 has-error:错误 has-warning:警告    -->
                                <div class="form-group{{ $errors->has('productNo') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">商品编号</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="productNo" name="productNo" class="form-control" value="{{ isset($data['productNo'])?$data['productNo']:old('productNo') }}">
                                        @if ($errors->has('productNo'))
                                        <p class="help-block">{{ $errors->first('productNo') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">商品原价</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="price" name="price" class="form-control" value="{{ isset($data['price'])?$data['price']:old('price') }}">
                                        @if ($errors->has('price'))
                                        <p class="help-block">{{ $errors->first('price') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('sale_price') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">推荐价格</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="sale_price" name="sale_price" class="form-control" value="{{ isset($data['sale_price'])?$data['sale_price']:old('sale_price') }}">
                                        @if ($errors->has('sale_price'))
                                        <p class="help-block">{{ $errors->first('sale_price') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('review') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">审核状态</label>
                                    <div class="col-md-7">
                                        <label class="radio-inline">
                                            <input type="radio" name="review"
                                            @if($data['review'] === 1)
                                            checked="checked" 
                                            @endif
                                            value="1"> 
                                            通过
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="review" 
                                            @if($data['review'] === 0)
                                            checked="checked" 
                                            @endif
                                            value="0"> 
                                            不通过
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('is_show') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">上架状态</label>
                                    <div class="col-md-7">
                                        <label class="radio-inline">
                                            <input type="radio" name="is_show" 
                                            @if($data['is_show'] === 1)
                                            checked="checked" 
                                            @endif
                                            value="1"> 
                                            上架
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="is_show" 
                                            @if($data['is_show'] === 0)
                                            checked="checked" 
                                            @endif
                                            value="0"> 
                                            下架
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">排序</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="sort_order" name="sort_order" class="form-control" value="{{ isset($data['sort_order'])?$data['sort_order']:old('sort_order') }}">
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