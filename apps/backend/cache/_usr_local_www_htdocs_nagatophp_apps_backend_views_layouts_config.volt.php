<div class="container">
	<div class="page-header">
		<h1>配置管理 <?php if (isset($currentCategory)) { ?> - <?php echo $currentCategory->title; ?> <?php } ?>
		</h1>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<?php foreach ($navs as $nav) { ?>
				<li <?php echo ($this->dispatcher->getParam('name') == $nav['name'] ? 'class="active"' : ''); ?>><a href="<?php echo $this->url->get('admin/config/') . $nav['name']; ?>"><?php echo $nav['title']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
		<div class="col-md-10">
			<?php echo $this->getContent(); ?>
		</div>
	</div>
</div>
