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
            <div class="page-heading">
                <h3>
                    属性组列表
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="editable_table.html#">属性组列表</a>
                    </li>
                    <li>
                        <a href="editable_table.html#">Data Table</a>
                    </li>
                    <li class="active"> Editable Table </li>
                </ul>
            </div>
            <!-- page heading end-->

            <!--body wrapper start-->
            <div class="wrapper">
               <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            属性组列表
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="adv-table editable-table ">
                                <div class="clearfix">
                                    <div class="btn-group">
                                        <a href="{{ url('/product/attr/create') }}"><button id="add—admin" class="btn btn-primary">
                                            添加属性组 <i class="fa fa-plus"></i>
                                        </button></a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ url('/product/attr_value/create') }}"><button id="add—admin" class="btn btn-primary">
                                            添加属性 <i class="fa fa-plus"></i>
                                        </button></a>
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
                                </div>
                                <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>属性组名称</th>
                                            <th>Status</th>
                                            <th>查看属性</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lists as $list)
                                        <tr class="">
                                            <td>{{ $list['id'] }}</td>
                                            <td>{{ $list['name'] }}</td>
                                            <td class="center">{{ $list['status'] }}</td>
                                            <td><a href="{{ url('/product/attr_value/'.$list['id']) }}">Show</a></td>
                                            <td><a href="{{ url('/product/attr/'.$list['id'].'/edit') }}">Edit</a></td>
                                            <td><a data-toggle="modal" data-target="#modal-delete" href="javascript:;" onclick="setDeleteFromAction({{ $list['id']}} );">Delete</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
        EditableTable.init();
    });
    
    function setDeleteFromAction(id){
        $("#delete-form").attr("action", "/product/attr/"+id);
    }
</script>

</body>
</html>
