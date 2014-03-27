<div class="container">
	<div class="page-header">
		<h1>配置管理 {% if currentCategory is defined %} - {{ currentCategory.title }} {% endif %}
		</h1>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				{% for nav in navs %}
				<li {{ dispatcher.getParam('name') == nav['name'] ? 'class="active"' : '' }}><a href="{{ url('admin/config/') ~ nav['name'] }}">{{ nav['title'] }}</a></li>
				{% endfor %}
			</ul>
		</div>
		<div class="col-md-10">
			{{ content() }}
		</div>
	</div>
</div>
