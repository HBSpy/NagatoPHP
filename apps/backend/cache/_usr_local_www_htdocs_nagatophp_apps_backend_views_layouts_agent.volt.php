<div class="container">
	<div class="page-header">
		<h1>客户端管理</button>
		</h1>
	</div> 
	<div class="row">
		<div class="col-md-2">
			<ul class="nav nav-pills nav-stacked">
				<li><a href="<?php echo $this->url->get('admin/agent/family'); ?>">家族规则</a></li>
				<li><a href="<?php echo $this->url->get('admin/agent/exception'); ?>">例外规则</a></li>
			</ul>
		</div>
		<div class="col-md-10">
			<?php echo $this->getContent(); ?>
		</div>
	</div>
</div>
