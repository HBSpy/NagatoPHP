<form class="form-inline well" id="subform" style="display:none;">
	<div class="form-group">
		<label class="sr-only" for="title">名称</label>
		<input type="text" name="title" id="title" class="form-control" placeholder="名称" required="required" />
	</div>
	<div class="checkbox">
		<label>
			<input type="checkbox" name="default"> 设为默认
		</label>
	</div>
	<button type="submit" class="btn btn-default pull-right">提交</button>
</form>
{% for sid, sub in subs %}
<div class="panel panel-primary">
	<div class="panel-heading"><strong>{{ sub['title'] }}</strong> 
		{% if sid == currentCategory.default %}
		<strong>[默认]</strong>
		{% else %}
		<span class="set-default" sid="{{ sid }}" style="cursor:pointer;">[设为默认]</span>
		{% endif %}
		<span class="glyphicon glyphicon-plus pull-right add-tag" style="cursor:pointer;" sid="{{ sid }}"></span>
		<span class="glyphicon glyphicon-minus pull-right remove" style="cursor:pointer; margin-right:10px;" sid="{{ sid }}"></span>
	</div>
	<form class="form-inline well" id="form-tag-{{ sid }}" style="display:none;">
		<div class="form-group">
			<label class="sr-only" for="tag">TAG</label>
			<input type="text" name="tag" id="tag" class="form-control" placeholder="TAG1, TAG2 ..." required="required" />
		</div>
		<div class="form-group">
			<label class="sr-only" for="title">名称</label>
			<input type="text" name="title" id="title" class="form-control" placeholder="名称" required="required" />
		</div>
		<div class="form-group">
			<label class="sr-only" for="item">标签项</label>
			<input type="text" name="item" id="item" class="form-control" placeholder="标签项，逗号分隔" />
		</div>
		<div class="form-group">
			<label class="sr-only" for="help">帮助信息</label>
			<input type="text" name="help" id="help" class="form-control" placeholder="帮助信息" />
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="search"> 搜索项
			</label>
		</div>
		<button type="submit" class="btn btn-default pull-right">提交</button>
	</form>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>TAG</th>
				<th>名称</th>
				<th>标签项</th>
				<th>帮助信息</th>
				<th>搜索项</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			{% for key, tag in sub['tags'] %}
			<tr>
				<td>{{ key }}</td>
				<td>{{ tag['title'] }}</td>
				<td>{{ tag['item'] }}</td>
				<td>{{ tag['help'] }}</td>
				<td>{{ tag['search'] ? '是' : '否' }}</td>
				<td>
					<span class="glyphicon glyphicon-remove remove-tag" style="cursor:pointer;" sid="{{ sid }}" tag="{{ key }}"></span>
				</td>
			</tr>
			{% endfor %}
		</tbody>
	</table>
</div>
{% endfor %}
<script>
	$('#add').click(function (){
		$('#subform').toggle('fast').submit(function (){
			$.post('{{ url('admin/category/addsub') }}/' + {{ currentCategory.cid }}, $(this).serialize(), function (data){
				if(data.success){
					window.location.reload();
				} else {
					alert(data.error);
				}
			});
			return false;
		});
	});

	$('.remove').click(function (){
		var sid = $(this).attr('sid');
		$.post('{{ url('admin/category/removesub')}}/' + sid, null, function (data){
			if(data.success){
				window.location.reload();
			} else {
				alert(data.error);
			}
		});
	});

	$('.set-default').click(function (){
		var sid = $(this).attr('sid');
		$.post('{{ url('admin/category/setdefault')}}/' + {{ currentCategory.cid }}, {sid: sid}, function (data){
			if(data.success){
				window.location.reload();
			} else {
				alert(data.error);
			}
		});
	});

	$('.add-tag').click(function (){
		var sid = $(this).attr('sid');
		$('#form-tag-' + sid).toggle('fast').submit(function (){
			$.post('{{ url('admin/category/addtag')}}/' + sid, $(this).serialize(), function (data){
				if(data.success){
					window.location.reload();
				} else {
					alert(data.error);
				}
			});
			return false;
		});
	});

	$('.remove-tag').click(function (){
		var sid = $(this).attr('sid');
		var tag = $(this).attr('tag');
		$.post('{{ url('admin/category/removetag')}}/' + sid, {removetag: tag}, function (data){
			if(data.success){
				window.location.reload();
			} else {
				alert(data.error);
			}
		});
	});
</script>
