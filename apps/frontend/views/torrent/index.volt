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
		<form class="form-horizontal well" role="form">
			<div class="form-group">
				<label for="inputKey" class="col-sm-2 control-label">关键字</label>
				<div class="col-sm-3">
					<input type="text" name="key" class="form-control" id="inputKey">
				</div>
				<div class="col-sm-2">
					<select name="promotion" class="form-control">
						<option>优惠</option>
						<option>FREE</option>
						<option>2XFREE</option>
						<option>2X</option>
						<option>50%</option>
						<option>2X50%</option>
						<option>30%</option>
					</select>
				</div>
			</div>
		</form>
	</div>
	<div class="row well">
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
				<tr class="active">
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
						<strong>
							{% if torrent.zhtitle %}[{{ torrent.zhtitle }}]{% endif %}
							{% if torrent.entitle %}[{{ torrent.entitle }}]{% endif %}
							{% if torrent.tag1 %}[{{ torrent.tag1 }}]{% endif %}
							{% if torrent.tag2 %}[{{ torrent.tag2 }}]{% endif %}
							{% if torrent.tag3 %}[{{ torrent.tag3 }}]{% endif %}
							{% if torrent.tag4 %}[{{ torrent.tag4 }}]{% endif %}
						</strong>
						<span class="glyphicon glyphicon-download-alt pull-right"></span>
						<br />
						<span class="glyphicon glyphicon-star-empty pull-right"></span>
						{% if torrent.promotion != 'NORMAL' %}
						<span class="label label-success">{{ torrent.promotion }}</span>
						{% endif %}
						<small class="text-muted">{{ torrent.subtitle }}</small>
					</td>
					<td>0</td>
					<td>时间</td>
					<td>{{ tool.mksize(torrent.size) }}</td>
					<td>10</td>
					<td>5</td>
					<td>30</td>
					<td>HBSpy</td>
				</tr>
				{% endfor %}
			</tbody>
		</table>
	</div>
	<div class="row">
		{{ pagebar }}
	</div>
	<pre>{{ content() }}</pre>
</div>
