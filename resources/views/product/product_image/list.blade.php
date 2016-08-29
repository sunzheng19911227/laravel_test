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

	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/webuploader/webuploader.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/assets/webuploader/upload.css') }}">

	

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  <style>
	#uploader .filelist div.file-panel span {
		width: 24px;
		height: 24px;
		display: inline;
		float: right;
		text-indent: -9999px;
		overflow: hidden;
		background: url({{ asset('/assets/webuploader/images/icons.png') }} ) no-repeat;
		margin: 5px 1px 1px;
		cursor: pointer;
	}
  </style>
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
								商品图片
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
											<input type="hidden" id="product_id" name="product_id" value="{{ $product_id }}">
											<a onclick="uploadImages();"><button id="add—admin" class="btn btn-primary">
												添加图片 <i class="fa fa-plus"></i>
											</button></a>
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
									<div style="margin-top:10px; float:left; width:100%">
										@foreach($images as $img)
											<div style="float:left; margin-right:20px;"><img src="{{ '/images/'.$img['image_url'] }}" onclick="RemoveImage({{ $img['id'] }})" width="300" height="300"></div>
										@endforeach
									</div>
									<div style="float:left; width:100%">
									{!! $images->render() !!}
									</div>

									<!-- Modal -->
									<div class="modal fade" id="myUploadModal" tabindex="9999" role="dialog" aria-labelledby="myModalLabel"
									aria-hidden="true">
									<div class="modal-dialog" >
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"
												aria-hidden="true">&times;</button>
												<h4 class="modal-title">上传新图片</h4>
											</div>
											<div class="modal-body row" id="uploadViews">
									<!--------执行上传----->
									<div class="col-sm-12">
										<section class="panel">
											<div class="page-container">
												<div id="uploader" class="wu-example">
													<div class="queueList">
														<div id="dndArea" class="placeholder">
															<div id="filePicker"></div>
															<p>或将照片拖到这里上传</p>
														</div>
													</div>
													<div class="statusBar" style="display:none;">
														<div class="progress">
															<span class="text">0%</span>
															<span class="percentage"></span>
														</div><div class="info"></div>
														<div class="btns">
															<div id="filePicker2"></div><div class="uploadBtn">开始上传</div>
														</div>
													</div>
												</div>
											</div>
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- modal -->
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

<script src="{{ asset('/assets/webuploader/upload.js') }}"></script>
<script src="{{ asset('/assets/admin/js/jquery.isotope.js') }}"></script>
<script src="{{ asset('/assets/admin/js/jquery.noty.packaged.min.js') }}"></script>
<script src="{{ asset('/assets/webuploader/webuploader.min.js') }}"></script>
<!-- END JAVASCRIPTS -->
<script>
	function uploadImages(){
		$("#myUploadModal").modal('show');
	}

	function imgClick(url, path) {
		var urlStr = url.split("/");
		$(".modal_img_name").val(urlStr[7]);
		$(".modal_img_src").attr("src", url);
		$(".modal_img_link").html(url);
		$(".modal_img_path").attr("title", path);
		$("#myModal").modal("show");
	}

	function RemoveImage(id) {
		if( confirm('请确认是否删除?') ) {
			$.ajax({
				type: "delete",
				url: "/product/product_image/"+id,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				},
				success: function (data) {
					alert('删除完成');
					product_id = $('#product_id').val();
					location.href = '/product/product_image/'+product_id;
				}
			});
		}
	}
	
	$(function () {
		var $container = $('#gallery');
		$container.isotope({
			itemSelector: '.item',
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		});
		// filter items when filter link is clicked
		$('#filters a').click(function () {
			var selector = $(this).attr('data-filter');
			$container.isotope({filter: selector});
			return false;
		});
		});
	</script>

</body>
</html>
