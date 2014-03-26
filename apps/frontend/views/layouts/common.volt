<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
<div class="container-fluid">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{ url.getBaseUri() }}">NagatoPHP</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">HBSpy <b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li><a href="#">Separated link</a></li>
			</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">发布 <b class="caret"></b></a>
			<ul class="dropdown-menu">
				{% for key, category in categorys %}
				{% if key is type('string') %}
				<li><a href="{{ url('upload/' ~ key) }}">{{ category['title'] }}</a></li>
				{% endif %}
				{% endfor %}
			</ul>
			</li>
		</ul>
		<form class="navbar-form" role="search" style="display:inline-table;" action="{{ url('torrent') }}">
			<div class="form-group">
				<div class="input-group">
					<input type="text" name="key" id="key" class="form-control" placeholder="热门：父爱如山" />
					<span class="input-group-btn">
						<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
			</div>
		</form>
	</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

{{ flash.output() }}

{{ content() }}
