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
                            主商品列表
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table editable-table ">
                                <div class="clearfix">
                                    <div class="btn-group">
                                        <meta name="_token" content="{{ csrf_token() }}">
                                        @can('主商品列表-添加')
                                        <a href="{{ url('/product/products/create') }}"><button id="add—admin" class="btn btn-primary">
                                            添加主商品 <i class="fa fa-plus"></i>
                                        </button></a>
                                        @endcan
                                        @can('商品批处理')
                                        <a onclick="batch('delete')"><button id="add—admin" class="btn btn-primary">
                                            批量删除
                                        </button></a>
                                        <a onclick="batch('show')"><button id="add—admin" class="btn btn-primary">
                                            批量上架
                                        </button></a>
                                        <a onclick="batch('hide')"><button id="add—admin" class="btn btn-primary">
                                            批量下架
                                        </button></a>
                                        @endcan
                                    </div>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
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
                                </div>
                                <div class="col-lg-6">
                                    <form action="{{ url('product/products') }}" method="get">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="dataTables_filter" style="float:left;" id="editable-sample_filter">
                                        <label>Search:<input type="text" aria-controls="editable-sample" placeholder="商品名称" name='name' value="{{ $name }}" class="form-control medium">
                                        </label>
                                    </div>
                                    </form>
                                </div>
                                <table class="table table-striped table-hover table-bordered" id="editable-sample" style="margin-top:10px;">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="all" name="id"></th>
                                            <th>id</th>
                                            <th>商品名称</th>
                                            <th>添加时间</th>
                                            <th>下架状态</th>
                                            <th>查看子商品</th>
                                            <th>Show</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lists as $list)
                                        <tr class="lists">
                                            <td><input type="checkbox" name="ids" value="{{ $list['id'] }}"></td>
                                            <td>{{ $list['id'] }}</td>
                                            <td>{{ $list['name'] }}</td>
                                            <td>{{ $list['created_at'] }}</td>
                                            <td>{{ $list['status'] }}</td>
                                            <td><a href="{{ url('/product/product_sub/'.$list['id']) }}">查看子商品</a></td>
                                            <td><a href="{{ url('/product/products/'.$list['id']) }}">Show</a></td>
                                            <td><a href="{{ url('/product/products/'.$list['id'].'/edit') }}">Edit</a></td>
                                            <td><a data-toggle="modal" data-target="#modal-delete" href="javascript:;" onclick="setDeleteFromAction({{ $list['id']}} );">Delete</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $lists->appends(['name'=>$name])->render() !!}
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

<!--common scripts for all pages-->
<script src="{{ asset('/assets/admin/js/scripts.js') }}"></script>

<!-- END JAVASCRIPTS -->
<script>
    jQuery(document).ready(function() {
        EditableTable.init();
    });
    
    function setDeleteFromAction(id){
        $("#delete-form").attr("action", "/product/products/"+id);
    }

    $("#all").click(function(){
        if(this.checked){
            $(".lists :checkbox").attr("checked", true);   
        }else{    
            $(".lists :checkbox").attr("checked", false); 
        }    
    });

    function batch(type) {
        var ids = document.getElementsByName('ids');
        var arr = [];
        for(var i=0;i<ids.length;i++) {
            if(ids[i].checked == true) {
                arr.push(ids[i].value);
            }
        } 
        var vals = arr.join(',');   //转换为逗号隔开的字符串 

        if(vals != ''){
            // 批量删除
            $.ajax({
                type: "post",
                url: "/product/products/batch",
                data: {ids:vals,type:type},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    alert('处理完成');
                    location.href = "{{ url('product/products') }}";
                }
            });
        }
    }
</script>

</body>
</html>
