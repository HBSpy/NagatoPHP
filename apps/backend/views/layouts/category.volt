<div class="container">
	<div class="page-header">
		<h1>分区管理 {% if currentCategory is defined %} - {{ currentCategory.title }} {% endif %}
			<button id="add" type="button" class="btn btn-success btn-lg pull-right">
				{% if currentCategory is defined %} 添加二级分类 {% else %} 添加分区 {% endif %}
			</button>
		</h1>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<li {{ dispatcher.getParam('category') ? '' : 'class="active"'}}><a href="{{ url('admin/category') }}">首页</a></li>
				{% for nav in navs %}
				<li {{ dispatcher.getParam('category') == nav.name ? 'class="active"' : '' }}><a href="{{ url('admin/category/') ~ nav.name }}">{{ nav.title }}</a></li>
				{% endfor %}
			</ul>
		</div>
		<div class="col-md-10">
			{{ content() }}
		</div>
	</div>
</div>
