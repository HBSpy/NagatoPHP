<div class="container">
	<div class="page-header">
		<h1><?php echo $category['title']; ?> <small>发布规则</small></h1>
	</div>
	<form class="form-horizontal" role="form" id="uploadform" method="POST">
		<div class="form-group">
			<label for="sub" class="col-sm-2 control-label">二级分类</label>
			<div class="col-sm-10">
				<ul class="nav nav-pills">
					<?php foreach ($category['subs'] as $key => $sub) { ?>
					<li <?php echo ($key == $sid ? 'class="active"' : ''); ?>><a href="<?php echo $this->url->get('upload/' . $this->dispatcher->getParam('category')) . '/' . $key; ?>"><?php echo $sub['title']; ?></a>
					<?php } ?>
				</ul>
			</div>
		</div>
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
		<?php foreach ($category['subs'][$sid]['tags'] as $key => $ctag) { ?>
		<div class="form-group">
			<label for="<?php echo $key; ?>" class="col-sm-2 control-label"><?php echo $ctag['title']; ?></label>
			<div class="col-sm-2">
				<input type="text" class="form-control" id="<?php echo $key; ?>" name="<?php echo $key; ?>" placeholder="<?php echo $ctag['help']; ?>">
			</div>
			<div class="col-sm-8">
				<?php $v140872889712120016242iterator = $ctag['items']; $v140872889712120016242incr = 0; $v140872889712120016242loop = new stdClass(); $v140872889712120016242loop->length = count($v140872889712120016242iterator); $v140872889712120016242loop->index = 1; $v140872889712120016242loop->index0 = 1; $v140872889712120016242loop->revindex = $v140872889712120016242loop->length; $v140872889712120016242loop->revindex0 = $v140872889712120016242loop->length - 1; ?><?php foreach ($v140872889712120016242iterator as $item) { ?><?php $v140872889712120016242loop->first = ($v140872889712120016242incr == 0); $v140872889712120016242loop->index = $v140872889712120016242incr + 1; $v140872889712120016242loop->index0 = $v140872889712120016242incr; $v140872889712120016242loop->revindex = $v140872889712120016242loop->length - $v140872889712120016242incr; $v140872889712120016242loop->revindex0 = $v140872889712120016242loop->length - ($v140872889712120016242incr + 1); $v140872889712120016242loop->last = ($v140872889712120016242incr == ($v140872889712120016242loop->length - 1)); ?>
				<button class="btn btn-default item" type="button" tag="<?php echo $key; ?>"><?php echo $item; ?></button>
				<?php if ($v140872889712120016242loop->last) { ?>
				<button class="btn btn-default other" type="button" tag="<?php echo $key; ?>">其他</button>
				<?php } ?>
				<?php $v140872889712120016242incr++; } ?>
			</div>
		</div>
		<?php } ?>
		<div class="form-group">
			<label for="entitle" class="col-sm-2 control-label">简介</label>
			<div class="col-sm-8">
				<textarea class="form-control" name="intro" rows="6"></textarea>
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
</div>
<pre><?php echo $this->getContent(); ?></pre>
<?php echo $this->tag->javascriptInclude('js/jquery.form.js'); ?>
<script>
	$('.item').click(function (){
		var tag = $(this).attr('tag');
		$('#' + tag).prop('value', $(this).html());
	});

	$('.other').click(function (){
		var tag = $(this).attr('tag');
		$('#' + tag).prop('value', '').focus();
	});

	$(function (){
		$('#uploadform').ajaxForm(function (data){
			if(data.success){
				window.location.href = data.redirect;
			}
		});
	});
</script>
