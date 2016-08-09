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
                            <form role="form" class="form-horizontal adminex-form" method="POST" action="{{ url('/product/products') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <meta name="_token" content="{{ csrf_token() }}">
                                <!--   class样式说明  has-success:成功 has-error:错误 has-warning:警告    -->
                                <div class="form-group{{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                                    <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">供应商</label>
                                    <div class="col-lg-10">
                                        <select class="form-control m-bot15" name="supplier_id">
                                            <option>请选择供应商</option>
                                            @if(!empty($supplier_lists))
                                            @foreach($supplier_lists as $list)
                                            <option value="{{ $list['id'] }}" 
                                            >{{ $list['name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
                                    <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">品牌</label>
                                    <div class="col-lg-10">
                                        <select class="form-control m-bot15" name="brand_id">
                                            <option>请选择品牌</option>
                                            @if(!empty($brand_lists))
                                            @foreach($brand_lists as $list)
                                            <option value="{{ $list['id'] }}" 
                                            >{{ $list['name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                    <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">类型</label>
                                    <div class="col-lg-10">
                                        <select class="form-control m-bot15" name="category_id" id="category_id" onchange="create_form()">
                                            <option>请选择类型</option>
                                            @if(!empty($category_lists))
                                            @foreach($category_lists as $list)
                                            <option value="{{ $list['id'] }}" 
                                            >{{ $list['name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div id="form_test">
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">名称</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                        <p class="help-block">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('details') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">商品详情</label>
                                    <div class="col-lg-10">
                                        @include('UEditor::head')
                                        <!-- 加载编辑器的容器 -->
                                        <script id="container" name="details" type="text/plain">{{ old('details') }}</script>
                                        @if ($errors->has('details'))
                                        <p class="help-block">{{ $errors->first('details') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">商品描述</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="description" name="description" class="form-control" value="{{ old('description') }}">
                                        @if ($errors->has('description'))
                                        <p class="help-block">{{ $errors->first('description') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('seo_keywords') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">seo_keywords</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="seo_keywords" name="seo_keywords" class="form-control" value="{{ old('seo_keywords') }}">
                                        @if ($errors->has('seo_keywords'))
                                        <p class="help-block">{{ $errors->first('seo_keywords') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('seo_description') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">seo_description</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="seo_description" name="seo_description" class="form-control" value="{{ old('seo_description') }}">
                                        @if ($errors->has('seo_description'))
                                        <p class="help-block">{{ $errors->first('seo_description') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">label</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="label" name="label" class="form-control" value="{{ old('label') }}">
                                        @if ($errors->has('label'))
                                        <p class="help-block">{{ $errors->first('label') }}</p>
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

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
        ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.    
    });

    function create_form(){
       category_id = $('#category_id').val();

       $.ajax({
            type: "post",
            url: "/product/products/ajax_create_form",
            data: { category_id : category_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            dataType: "html",
            success: function (data) {
                console.log(data);
                $('#form_test').html(data);
            }
        });
    }
</script>

</body>
</html>
