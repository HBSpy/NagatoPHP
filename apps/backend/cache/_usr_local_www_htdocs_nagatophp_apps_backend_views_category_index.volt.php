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
		<button type="submit" class="btn btn-default pull-right">提交</button>
	</form>
	<?php $v4335135005438536631iterator = $categorys; $v4335135005438536631incr = 0; $v4335135005438536631loop = new stdClass(); $v4335135005438536631loop->length = count($v4335135005438536631iterator); $v4335135005438536631loop->index = 1; $v4335135005438536631loop->index0 = 1; $v4335135005438536631loop->revindex = $v4335135005438536631loop->length; $v4335135005438536631loop->revindex0 = $v4335135005438536631loop->length - 1; ?><?php foreach ($v4335135005438536631iterator as $category) { ?><?php $v4335135005438536631loop->first = ($v4335135005438536631incr == 0); $v4335135005438536631loop->index = $v4335135005438536631incr + 1; $v4335135005438536631loop->index0 = $v4335135005438536631incr; $v4335135005438536631loop->revindex = $v4335135005438536631loop->length - $v4335135005438536631incr; $v4335135005438536631loop->revindex0 = $v4335135005438536631loop->length - ($v4335135005438536631incr + 1); $v4335135005438536631loop->last = ($v4335135005438536631incr == ($v4335135005438536631loop->length - 1)); ?>
		<?php if (((($v4335135005438536631loop->index) % 2) != 0)) { ?>
		<div class="row">
		<?php } ?>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading"><strong><?php echo $category->title; ?></strong>
						<span class="glyphicon glyphicon-plus pull-right add-tag" style="cursor:pointer;" cid="<?php echo $category->cid; ?>"></span>
					</div>
					<div class="panel-body">
						<form class="form-inline" id="form-tag-<?php echo $category->cid; ?>" style="display:none;">
							<div class="form-group">
								<label class="sr-only" for="tag">TAG</label>
								<input type="text" name="tag" id="tag" class="form-control" placeholder="TAG" required="required" />
							</div>
							<div class="form-group">
								<label class="sr-only" for="item">标签项</label>
								<input type="text" name="item" id="item" class="form-control" placeholder="标签项，逗号分隔" required="required" />
								<span class="glyphicon glyphicon-warning-sign form-control-feedback hide"></span>
							</div>
							<button type="submit" class="btn btn-default pull-right">提交</button>
						</form>
					</div>
				</div>
			</div>
		<?php if (((($v4335135005438536631loop->index) % 2) == 0)) { ?>
		</div>
		<?php } ?>
	<?php $v4335135005438536631incr++; } ?>
</div>
<script>
	$('#add').click(function (){
		$('#form-category').toggle('fast').submit(function (){
			$.post('<?php echo $this->url->get('admin/category/add'); ?>', $(this).serialize(), function (data){
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
			$.post('<?php echo $this->url->get('admin/category/addtag'); ?>/' + cid, $(this).serialize(), function (data){
			});
			return false;
		});
	});
</script>