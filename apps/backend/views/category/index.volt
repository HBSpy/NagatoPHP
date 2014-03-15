<div class="container">
	<div class="page-header">
		<h1>分区管理 <button id="add" type="button" class="btn btn-success btn-lg pull-right">添加</button></h1>
	</div>
	<form class="form-inline well" id="form-category" style="display:none;">
		<div class="form-group">
			<label class="sr-only" for="title">名称</label>
			<input type="text" name="title" id="title" class="form-control" placeholder="名称" required="required" />
		</div>
		<div class="form-group">
			<label class="sr-only" for="name" id="label_name">标识</label>
			<input type="text" name="name" id="name" class="form-control" placeholder="标识" required="required" />
			<span class="glyphicon glyphicon-warning-sign form-control-feedback hide"></span>
		</div>
		<button type="submit" class="btn btn-default">提交</button>
	</form>
	{% for category in categorys %}
		{% if loop.index is odd %}
		<div class="row">
		{% endif %}
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><strong>{{ category.title }}</strong>
						<span class="glyphicon glyphicon-plus pull-right add-tag" style="cursor:pointer;" cid="{{ category.cid }}"></span>
					</div>
					<form class="form-inline well" id="form-tag-{{ category.cid }}" style="display:none;">
						<div class="form-group">
							<label class="sr-only" for="tag">TAG</label>
							<input type="text" name="tag" id="tag" class="form-control" placeholder="TAG" required="required" />
						</div>
						<div class="form-group">
							<label class="sr-only" for="title">名称</label>
							<input type="text" name="title" id="title" class="form-control" placeholder="名称" required="required" />
						</div>
						<div class="form-group">
							<label class="sr-only" for="item">标签项</label>
							<input type="text" name="item" id="item" class="form-control" placeholder="标签项，逗号分隔" />
							<span class="glyphicon glyphicon-warning-sign form-control-feedback hide"></span>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="search"> 搜索项
							</label>
						</div>
						<button type="submit" class="btn btn-default">提交</button>
					</form>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>TAG</th>
								<th>名称</th>
								<th>标签项</th>
								<th>搜索项</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							{% for key, ctag in category.tags %}
							<tr>
								<td>{{ key }}
								<td>{{ ctag.title }}</td>
								<td>{{ ctag.item }}</td>
								<td>{% if ctag.search %}是{% else %}否{% endif %}</td>
								<td><span class="glyphicon glyphicon-remove remove-tag" style="cursor:pointer;" cid="{{ category.cid }}" tag="{{ key }}"></span></td>
							</tr>
							{% endfor %}
						</tbody>
					</table>
				</div>
			</div>
		{% if loop.index is even %}
		</div>
		{% endif %}
	{% endfor %}
</div>
<script>
	$('#add').click(function (){
		$('#form-category').toggle('fast').submit(function (){
			$.post('{{ url('admin/category/add') }}', $(this).serialize(), function (data){
				if(!data.success){
					$('#label_name').html(data[0].error).removeClass('sr-only').addClass('control-label').next().focus().next().removeClass('hide').parent().addClass('has-warning has-feedback');
				} else {
					window.location.reload();
				}
			});
			return false;
		});
	});

	$('.add-tag').click(function (){
		var cid = $(this).attr('cid');
		$('#form-tag-' + cid).toggle('fast').submit(function (){
			$.post('{{ url('admin/category/addtag')}}/' + cid, $(this).serialize(), function (data){
				if(data){
					window.location.reload();
				}
			});
			return false;
		});
	});

	$('.remove-tag').click(function (){
		var cid = $(this).attr('cid');
		var tag = $(this).attr('tag');
		$.post('{{ url('admin/category/removetag')}}/' + cid, {removetag: tag}, function (data){
			if(data){
				window.location.reload();
			}
		});
	});
</script>
