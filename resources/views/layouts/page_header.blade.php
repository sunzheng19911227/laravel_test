<!-- page heading start-->
<div class="page-heading">
    <h3>
        <?php $title = $breadcrumbs[0];
              echo $title->name;

        ?>
    </h3>
    <ul class="breadcrumb">
        <?php sort($breadcrumbs); ?>
        @foreach($breadcrumbs as $key=>$breadcrumb)
        @if($key == 0)
        <li>{{ $breadcrumb->name }}</li>
        @elseif(count($breadcrumbs) - 1 == $key)
        <li>{{ $breadcrumb->name }}</li>
        @else
        <li>
            <a href="{{ $breadcrumb->route }}">{{ $breadcrumb->name }}</a>
        </li>
        @endif
        @endforeach
        <!--<li>
            <a href="editable_table.html#">权限管理</a>
        </li>
        <li>
            <a href="editable_table.html#">Data Table</a>
        </li>
        <li class="active"> Editable Table </li>-->
    </ul>
</div>
<!-- page heading end-->