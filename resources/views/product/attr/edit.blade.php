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
                            属性编辑
                        </header>
                        <div class="panel-body">
                            <form role="form" id="form1" class="form-horizontal adminex-form" method="POST" action="{{ url('/product/property/'.$data['id']) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <meta name="_token" content="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" id="id" value="{{ $data['id'] }}">

                                <!--   class样式说明  has-success:成功 has-error:错误 has-warning:警告    -->
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">名称</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="name" name="name" class="form-control" value="{{ isset($data['name']) ? $data['name']:old('name') }}">
                                        @if ($errors->has('name'))
                                        <p class="help-block">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('input_name') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">表单名称</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="input_name" name="input_name" class="form-control" value="{{ isset($data['input_name']) ? $data['input_name']:old('input_name') }}">
                                        @if ($errors->has('input_name'))
                                        <p class="help-block">{{ $errors->first('input_name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">输入框类型</label>
                                    <div class="col-md-7">
                                        <label class="radio-inline">
                                            <input type="radio" name="input_box_type"
                                            @if($data['input_box_type'] === 1)
                                            checked="checked" 
                                            @endif
                                            value="1"> 文本
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="input_box_type"
                                            @if($data['input_box_type'] === 2)
                                            checked="checked" 
                                            @endif
                                            value="2"> 复选框
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="input_box_type"
                                            @if($data['input_box_type'] === 3)
                                            checked="checked" 
                                            @endif
                                            value="3"> 单选框
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="input_box_type"
                                            @if($data['input_box_type'] === 4)
                                            checked="checked" 
                                            @endif
                                            value="4"> 下拉框
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">输入值类型</label>
                                    <div class="col-md-7">
                                        <label class="radio-inline">
                                            <input type="radio" name="input_value_type"
                                            @if($data['input_value_type'] === 1)
                                            checked="checked" 
                                            @endif
                                            value="1"> 文本
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="input_value_type"
                                            @if($data['input_value_type'] === 2)
                                            checked="checked" 
                                            @endif
                                            value="2"> 数字
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="input_value_type"
                                            @if($data['input_value_type'] === 3)
                                            checked="checked" 
                                            @endif
                                            value="3"> 日期
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">状态</label>
                                    <div class="col-md-7">
                                        <label class="radio-inline">
                                            <input type="radio" name="status" 
                                            @if($data['status'] === 1)
                                            checked="checked" 
                                            @endif
                                            value="1"> 
                                            启用
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status"
                                            @if($data['status'] === 0)
                                            checked="checked" 
                                            @endif
                                            value="0"> 
                                            停用
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                                    <label class="col-lg-2 control-label">排序</label>
                                    <div class="col-lg-10">
                                        <input type="text" placeholder="" id="sort_order" name="sort_order" class="form-control" value="{{ isset($data['sort_order']) ? $data['sort_order']:old('sort_order') }}">
                                        @if ($errors->has('sort_order'))
                                        <p class="help-block">{{ $errors->first('sort_order') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button class="btn btn-primary" id="submit" type="submit">Submit</button>
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
<script type="text/javascript">

    var submit_status = false;

    $('#submit').click(function(){
        var id = $('#id').val();
        var status = $("input[name='status']:checked").val();
        var status_data = "{{ $data['status'] }}";

        if(status != status_data) {
            $.ajax({
                type: "post",
                url: "/product/property/check_status",
                data: {id : id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                async:false,
                dataType:'json',
                success: function (data) {
                    if( data.pro_count > 0 || data.pro_sub_count > 0 ) {
                        if(confirm('这个修改会影响'+data.pro_count+'个主商品信息和'+data.pro_sub_count+'个子商品信息，请确认是否修改?')){
                            submit_status = true;
                            $('#form1').submit();
                        }
                    } else {
                        alert('123123');
                        return;
                        submit_status = true;
                        $('#form1').submit();
                    }
                }
            });
        } else {
            submit_status = true;
            $('#form1').submit();
        }
    });

    $('#form1').submit(function(){
        return submit_status;
    });
</script>
</body>
</html>
