<div class="container">
	<div class="page-header">
		<h1>用户管理</h1>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<li><a href="{{ url('admin/user/group') }}">用户组</a></li>
				<li><a href="{{ url('admin/user/uploader') }}">发布组</a></li>
				<li><a href="{{ url('admin/user/ripper') }}">压制组</a></li>
				<li><a href="{{ url('admin/user/mod') }}">管理组</a></li>
			</ul>
		</div>
		<div class="col-md-10">
			{{ content() }}
		</div>
	</div>
</div>
