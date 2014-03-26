<div class="container">
	<!-- Search Box -->
	<div class="row well">
		<ul class="list-inline">
		{% for key, category in categorys %}
			{% if key is type('string') %}
			<li><a href="{{ url('torrent/' ~ key) }}">{{ category['title'] }}</a></li>
			{% endif %}
		{% endfor %}
		</ul>
	</div>
	<div class="row">
		{% if subs is defined %}
			<dl class="dl-horizontal">
				{% if subs|length != 1 %}
				<dt>二级分类</dt>
				<dd>
					<ul class="list-inline">
						{% for sid, sub in subs %}
						<li><a href="{{ url('torrent/' ~ dispatcher.getParam('category') ~ '/' ~ sid) }}">{{ sub['title'] }}</a></li>
						{% endfor %}
					</ul>
				</dd>
				{% endif %}
				{% for tag in tags %}
				{% if tag['search'] %}
				<dt>{{ tag['title'] }}</dt>
				<dd>
					<ul class="list-inline">
					{% for item in tag['items'] %}
						<li>{{ item }}</li>
					{% endfor %}
					</ul>
				</dd>
				{% endif %}
				{% endfor %}
			</dl>
		{% endif %}
	</div>

	<!-- Torrent List -->
	<div class="row">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th><span class="glyphicon glyphicon-tags"></span></th>
					<th><span class="glyphicon glyphicon-th"></span></th>
					<th><span class="glyphicon glyphicon-comment"></span></th>
					<th><span class="glyphicon glyphicon-time"></span></th>
					<th><span class="glyphicon glyphicon-hdd"></span></th>
					<th><span class="glyphicon glyphicon-upload"></span></th>
					<th><span class="glyphicon glyphicon-download"></span></th>
					<th><span class="glyphicon glyphicon-ok-circle"></span></th>
					<th><span class="glyphicon glyphicon-user"></span></th>
				</tr>
			</thead>
			<tbody>
				{% for torrent in torrents %}
				<tr>
					<td>分类</td>
					<td>
						<strong>[标题][很长][很长][很长][很长][很长][很长][很长][很长][很长][很长][很长][很长]</strong>
						<span class="glyphicon glyphicon-download-alt pull-right"></span>
						<br />
						<span class="glyphicon glyphicon-star-empty pull-right"></span>
						<span class="label label-success">50%</span> <small class="text-muted">这里还有副标题，等等什么乱七八糟的的东西。。。</small>
					</td>
					<td>0</td>
					<td>时间</td>
					<td>100 MB</td>
					<td>10</td>
					<td>5</td>
					<td>30</td>
					<td>HBSpy</td>
				</tr>
				{% endfor %}
			</tbody>
		</table>

	</div>
	<pre>{{ content() }}</pre>
</div>
