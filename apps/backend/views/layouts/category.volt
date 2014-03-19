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
				{% for category in categorys %}
				<li {{ dispatcher.getParam('category') == category.name ? 'class="active"' : '' }}><a href="{{ url('admin/category/') ~ category.name }}">{{ category.title }}</a></li>
				{% endfor %}
			</ul>
		</div>
		<div class="col-md-10">
			{{ content() }}
		</div>
	</div>
</div>
