<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	
</head>
<body>

<?php
$homepage = DB::table('adminhomepagesettings')->where('user',Auth::user()->id)->where('status','Enabled')->get();
$retailstatus = DB::table('adminhomepagesettings')->where('user',Auth::user()->id)->where('sector','Retail')->value('status');
$wholesalestatus = DB::table('adminhomepagesettings')->where('user',Auth::user()->id)->where('sector','Wholesale')->value('status')
?>
@if($homepage->isEmpty())
Please enable your homepage settings under <a href="admin-homepage-settings" class="text-primary">Settings / Homepage <br><br></a> 
@else


@if($retailstatus == "Enabled")
<!-- Retail first row-->
<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-shopping-cart f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Live sales </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-history     f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Yesterday's Sales </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-thumbs-down f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Today's losses </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>



<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-warning f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Yesterday's losses </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>

</div>
<!--/ Retail first row-->


<!-- Retail second row-->
<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-area-chart f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Sales (this month) </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-line-chart f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Sales (last month)</h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-truck f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Supplies (This month) </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>



<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-archive f-30 text-c-pink"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Supplies (last month) </h6>
<h4 class="m-b-0">@convert(0)</h4>
</div>
</div>
</div>
</div>
</div>

</div>
<!--/ Retail second row-->
@endif












@if($wholesalestatus == "Enabled")
<!-- Wholesale first row-->
<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-shopping-cart f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Live sales </h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-history     f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Yesterday's Sales </h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-thumbs-down f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Today's loss </h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>



<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-warning f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Yesterday's loss </h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>

</div>
<!--/ Wholesale first row-->


<!-- Wholesale second row-->
<div class="row">
<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-area-chart f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Sales (this month) </h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-line-chart f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Sales (last month)</h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>


<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-truck f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Supplies (This month) </h6>
<h4 class="m-b-0">@convert(5984)</h4>
</div>
</div>
</div>
</div>
</div>



<div class="col-xl-3 col-md-6">
<div class="card">
<div class="card-block">
<div class="row align-items-center m-l-0">
<div class="col-auto">
<i class="fa fa-archive f-30 text-info"></i>
</div>
<div class="col-auto">
<h6 class="text-muted m-b-10">Supplies (last month) </h6>
<h4 class="m-b-0">@convert(598400000)</h4>
</div>
</div>
</div>
</div>
</div>

</div>
<!--/ Wholesale second row-->

@endif

@endif



<div class="card">
    <div class="card-header">
        <div class="card-header-left">
            <h5>Quick Actions</h5>
        </div>
    </div>
    <div class="card-block" style="overflow-x: auto; white-space: nowrap;">
        <a href="#" class="btn btn-warning btn-round mb-10">Change prices</a>
        <a href="#" class="btn btn-secondary btn-round mb-10" >View supplies</a>
		<a href="#" class="btn btn-danger btn-round mb-10">View product logs</a>
		<a href="#" class="btn btn-inverse btn-round mb-10">Distribute products</a>
        <a href="#" class="btn btn-success btn-round mb-10">Add baseproducts</a>
		<a href="#" class="btn btn-info btn-round mb-10">Approve transactions</a>
        <a href="#" class="btn btn-primary btn-round mb-10">Add branch</a>
        <a href="#" class="btn btn-info btn-round mb-10">Add employee</a>
        <a href="#" class="btn btn-success btn-round mb-10">Add user</a>
        <a href="#" class="btn btn-warning btn-round mb-10">Add supplier</a>
        <a href="#" class="btn btn-secondary btn-round mb-10">Add category</a>
    </div>
</div>


</body>
</html>