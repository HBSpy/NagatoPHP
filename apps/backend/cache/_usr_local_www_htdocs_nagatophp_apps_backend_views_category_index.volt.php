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
	<button type="submit" class="btn btn-default pull-right">提交</button>
</form>
<div class="panel panel-primary">
	<div class="panel-heading"><strong>分区</strong></div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>名称</th>
				<th>标识</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($categorys as $category) { ?>
			<tr>
				<td><?php echo $category->cid; ?></td>
				<td><?php echo $category->title; ?></td>
				<td><?php echo $category->name; ?></td>
				<td>
					<span class="glyphicon glyphicon-remove remove" cid="<?php echo $category->cid; ?>" style="cursor:pointer;"></span>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
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
