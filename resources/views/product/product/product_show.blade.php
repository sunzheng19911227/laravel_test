<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="editable_table.html#" type="image/png">

  <title>Editable Table</title>

  <!--data table-->
  <link rel="stylesheet" href="{{ asset('/assets/admin/js/data-tables/DT_bootstrap.css') }}" />

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
            @include('layouts.page_header')
            <!-- page heading end-->

            <!--body wrapper start-->
            <div class="wrapper">
               <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            查看商品详情
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table editable-table ">
                                <div class="clearfix">
                                    <div class="btn-group">
                                    </div>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="editable_table.html#">Print</a></li>
                                            <li><a href="editable_table.html#">Save as PDF</a></li>
                                            <li><a href="editable_table.html#">Export to Excel</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="space15">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success" style="margin-top:5px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>
                                                <i class="fa fa-check-circle fa-lg fa-fw"></i> Success. 
                                            </strong>
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::has('warning'))
                                        <div class="alert alert-warning" style="margin-top:5px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>
                                                <i class="fa fa-warning fa-lg fa-fw"></i> wanring. 
                                            </strong>
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                    <meta name="_token" content="{{ csrf_token() }}">
                                    <div>
                                        <div id="pro_image" style="float:left; display:none;" >
                                            <img id="image" src="{{ asset('/assets/admin/images/404-error.png') }}" alt="">
                                        </div>
                                        <div style="float:right; width:60%;">
                                            <h4>基本信息</h4>
                                            <div>商品名称:<span>{{ $data['product']['name'] }}</span></div>
                                            <div id="productNo" style="display:none;">NO:<span id="product_No">123123123</span></div>
                                            <div>商品类型:<span>{{ $data['product']['category'] }}</span></div>
                                            <div>供货商:<span>{{ $data['product']['supplier'] }}</span></div>
                                            <div>品牌:<span>{{ $data['product']['brand'] }}</span></div>
                                            <h4>销售属性</h4>
                                            <div id="form_test"></div>
                                            <div id="pro_sub_price" style="display:none;">
                                                <h4>商品价格</h4>
                                                <div>市场价:<span id="price">1300</span>元</div>
                                                <div>销售价:<span id="sale_price">1300</span>元</div>
                                            </div>
                                        </div>
                                        <div style="float:left; width:80%;">
                                            <h4>商品属性</h4>
                                            @foreach($data['attrs'] as $key=>$attr)
                                            <div>{{ $attr['name'] }} | {{ $attr['value'] }}</div>
                                            @endforeach
                                        </div>
                                        <div style="float:left; width:80%;">
                                            <h4>详细信息</h4>
                                            <div>{{ $data['product']['details'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

{{-- 确认删除 --}}
<div class="modal fade" id="modal-delete" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">Please Confirm</h4>
            </div>
            <div class="modal-body">
                <p class="lead">
                    <i class="fa fa-question-circle fa-lg"></i>
                    是否删除数据?
                </p>
            </div>
            <div class="modal-footer">
                <form method="POST" id="delete-form" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-times-circle"></i> Yes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="{{ asset('/assets/admin/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('/assets/admin/js/jquery-ui-1.9.2.custom.min.js') }}"></script>
<script src="{{ asset('/assets/admin/js/jquery-migrate-1.2.1.min.js') }}"></script>
<script src="{{ asset('/assets/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/admin/js/modernizr.min.js') }}"></script>
<script src="{{ asset('/assets/admin/js/jquery.nicescroll.js') }}"></script>

<!--data table-->
<script type="text/javascript" src="{{ asset('/assets/admin/js/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/admin/js/data-tables/DT_bootstrap.js') }}"></script>

<!--common scripts for all pages-->
<script src="{{ asset('/assets/admin/js/scripts.js') }}"></script>

<!--script for editable table-->
<script src="{{ asset('/assets/admin/js/editable-table.js') }}"></script>

<!-- END JAVASCRIPTS -->
<script>
    jQuery(document).ready(function() {
        var product_id = '<?php echo $data['product']['id']?>';
        var product_sub_id = '<?php echo $data['product_sub_id'] ?>';
        console.log(product_sub_id);
        ajax_option_checked(product_id, product_sub_id);
        if(product_sub_id != '')
            ajax_pro_sub(product_sub_id);
    });
    
    //  拉取已经选中的选项值
    function ajax_option_checked(product_id, product_sub_id) {
        $.ajax({
            type: "post",
            url: "/product/products/ajax_option_checked",
            data: {product_id : product_id, product_sub_id : product_sub_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            dataType: "html",
            success: function (data) {
                $('#form_test').html(data);
            }
        });
    }

    // 获取子商品信息
    function ajax_pro_sub(product_sub_id){
        $.ajax({
            type: "post",
            url: "/product/product_sub/ajax_pro_sub",
            data: {product_sub_id : product_sub_id},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                //  商品编号
                $('#productNo').show();
                $('#product_No').html(data.productNo);
                // 商品价格
                $('#pro_sub_price').show();
                $('#price').html(data.price);
                $('#sale_price').html(data.sale_price);
                // 商品图片
                if(data.image != ''){
                    $('#pro_image').show();
                    $("#image").attr('src','/images/'+data.image);
                }
            }
        });
    }
</script>

</body>
</html>
