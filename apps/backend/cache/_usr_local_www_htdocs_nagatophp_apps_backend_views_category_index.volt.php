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
	<?php foreach ($categorys as $category) { ?>
		<div class="panel panel-primary">
			<div class="panel-heading"><strong><?php echo $category->title; ?></strong>
				<span class="glyphicon glyphicon-plus pull-right add-tag" style="cursor:pointer;" cid="<?php echo $category->cid; ?>"></span>
				<span class="glyphicon glyphicon-minus pull-right remove" style="cursor:pointer; margin-right:10px;" cid="<?php echo $category->cid; ?>"></span>
			</div>
			<form class="form-inline well" id="form-tag-<?php echo $category->cid; ?>" style="display:none;">
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
				<button type="submit" class="btn btn-default">提交</button>
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
					<?php foreach ($category->tags as $key => $ctag) { ?>
					<tr>
						<td><?php echo $key; ?>
						<td><?php echo $ctag->title; ?></td>
						<td><?php echo $ctag->item; ?></td>
						<td><?php echo $ctag->help; ?></td>
						<td><?php if ($ctag->search) { ?>是<?php } else { ?>否<?php } ?></td>
						<td>
							<span class="glyphicon glyphicon-remove remove-tag" style="cursor:pointer;" cid="<?php echo $category->cid; ?>" tag="<?php echo $key; ?>"></span>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
</div>
<script>
	$('#add').click(function (){
		$('#form-category').toggle('fast').submit(function (){
			$.post('<?php echo $this->url->get('admin/category/add'); ?>', $(this).serialize(), function (data){
				if(data.success){
					window.location.reload();
				} else {
					$('#label_name').html(data[0].error).removeClass('sr-only').addClass('control-label').next().focus().next().removeClass('hide').parent().addClass('has-warning has-feedback');
				}
			});
			return false;
		});
	});

	$('.add-tag').click(function (){
		var cid = $(this).attr('cid');
		$('#form-tag-' + cid).toggle('fast').submit(function (){
			$.post('<?php echo $this->url->get('admin/category/addtag'); ?>/' + cid, $(this).serialize(), function (data){
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
		var cid = $(this).attr('cid');
		var tag = $(this).attr('tag');
		$.post('<?php echo $this->url->get('admin/category/removetag'); ?>/' + cid, {removetag: tag}, function (data){
			if(data.success){
				window.location.reload();
			} else {
				alert(data.error);
			}
		});
	});

	$('.remove').click(function (){
		var cid = $(this).attr('cid');
		$.post('<?php echo $this->url->get('admin/category/remove'); ?>/' + cid, null, function (data){
			if(data.success){
				window.location.reload();
			} else {
				alert(data.error);
			}
		});
	});
</script>
