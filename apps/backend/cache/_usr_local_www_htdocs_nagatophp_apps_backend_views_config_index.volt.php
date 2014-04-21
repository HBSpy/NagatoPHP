<div class="panel panel-primary">
	<div class="panel-heading"><strong><?php echo Phalcon\Text::upper($this->dispatcher->getParam('name')); ?> 配置</strong></div>
	<div class="panel-body">
		<form class="form-horizontal" id="form-config" role="form">
			<?php foreach ($configs as $key => $config) { ?>
			<div class="form-group">
				<label for="<?php echo $key; ?>" class="col-sm-2 control-label"><?php echo $config['title']; ?></label>
				<div class="col-sm-10">
					<input type="text" name="<?php echo $key; ?>" class="form-control" id="<?php echo $key; ?>" value="<?php echo $config['value']; ?>" />
				</div>
			</div>
			<?php } ?>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">保存</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$('#form-config').submit(function (){
		$.post('<?php echo $this->url->get('admin/config/' . $this->dispatcher->getParam('name')); ?>', $(this).serialize(), function(data){
			if(data){
				window.location.reload();
			}
		});
		return false;
	});
</script>
