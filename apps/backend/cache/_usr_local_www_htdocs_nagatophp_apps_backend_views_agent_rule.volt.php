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
<?php foreach ($agents as $agent) { ?>
<div class="panel panel-primary">
	<div class="panel-heading"><strong># <?php echo $agent->fid; ?> - <?php echo $agent->family; ?></strong>
		<span class="glyphicon glyphicon-remove pull-right remove" aid="<?php echo $agent->aid; ?>" style="cursor:pointer;"></span>
	</div>
	<table class="table table-condensed">
		<tr>
			<th>PEER_ID 表达式</th>
			<td><?php echo $agent->peer_id_pattern; ?></td>
		</tr>
		<tr>
			<th>命中统计</th>
			<td><?php echo $agent->hits; ?></td>
		</tr>
	</table>
</div>
<?php } ?>
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
		var aid = $(this).attr('aid');
		$.post('<?php echo $this->url->get('admin/agent/removefamily'); ?>/' + aid, null, function (data){
			if(data.success){
				window.location.reload();
			} else {
				alert(data.error);
			}
		});
	});
</script>
<?php echo $this->getContent(); ?>
