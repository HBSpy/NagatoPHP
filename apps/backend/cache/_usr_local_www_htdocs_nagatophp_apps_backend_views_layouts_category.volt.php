<div class="container">
	<div class="page-header">
		<h1>分区管理 <?php if (isset($currentCategory)) { ?> - <?php echo $currentCategory->title; ?> <?php } ?>
			<button id="add" type="button" class="btn btn-success btn-lg pull-right">
				<?php if (isset($currentCategory)) { ?> 添加二级分类 <?php } else { ?> 添加分区 <?php } ?>
			</button>
		</h1>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<li <?php echo ($this->dispatcher->getParam('category') ? '' : 'class="active"'); ?>><a href="<?php echo $this->url->get('admin/category'); ?>">首页</a></li>
				<?php foreach ($navs as $nav) { ?>
				<li <?php echo ($this->dispatcher->getParam('category') == $nav->name ? 'class="active"' : ''); ?>><a href="<?php echo $this->url->get('admin/category/') . $nav->name; ?>"><?php echo $nav->title; ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<div class="col-md-10">
			<?php echo $this->getContent(); ?>
		</div>
	</div>
</div>
