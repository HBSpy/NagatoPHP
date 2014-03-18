<div class="container">
	<div class="page-header">
		<h1>{{ category['title'] }} <small>发布规则</small></h1>
	</div>
	<form class="form-horizontal" role="form" id="uploadform">
		<div class="form-group">
			<label for="torrent" class="col-sm-2 control-label">种子文件</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="torrent" name="torrent">
			</div>
		</div>
		<div class="form-group">
			<label for="zhtitle" class="col-sm-2 control-label">中文名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="zhtitle" name="zhtitle" placeholder="中文名、官方译名等，与英文名二者必有其一">
			</div>
		</div>
		<div class="form-group">
			<label for="entitle" class="col-sm-2 control-label">英文名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="entitle" name="entitle" placeholder="英文名、罗马音、0day名等，与中文名二者必有其一">
			</div>
		</div>
		<div class="form-group">
			<label for="subtitle" class="col-sm-2 control-label">副标题</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="subtitle" name="subtitle">
			</div>
		</div>
		{% for key, ctag in category['tags'] %}
		<div class="form-group">
			<label for="{{ key }}" class="col-sm-2 control-label">{{ ctag['title'] }}</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" id="{{ key }}" name="{{ key }}" placeholder="{{ ctag['help'] }}">
			</div>
			<div class="col-sm-8">
				{% for item in ctag['items'] %}
				<button class="btn btn-default item" type="button" tag="{{ key }}">{{ item }}</button>
				{% if loop.last %}
				<button class="btn btn-default other" type="button" tag="{{ key }}">其他</button>
				{% endif %}
				{% endfor %}
			</div>
		</div>
		{% endfor %}
		<div class="form-group">
			<label for="entitle" class="col-sm-2 control-label">简介</label>
			<div class="col-sm-8">
				<textarea class="form-control" rows="6"></textarea>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="anonymous"> 匿名
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">发布</button>
			</div>
		</div>
	</form>
	<pre>{{ content() }}</pre>
</div>
<script>
	$('.item').click(function (){
		var tag = $(this).attr('tag');
		$('#' + tag).attr('value', $(this).html());
	});

	$('.other').click(function (){
		var tag = $(this).attr('tag');
		$('#' + tag).attr('value', '').focus();
	});

	$('#uploadform').submit(function (){
		$.post(null, $(this).serialize(), function (data){
		});
		return false;
	});
</script>
