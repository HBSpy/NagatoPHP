<div class="container">
	<!-- Search Box -->
	<div class="row well">
		<ul class="list-inline">
		<?php foreach ($categorys as $key => $category) { ?>
			<?php if (gettype($key) === ('string')) { ?>
			<li><a href="<?php echo $this->url->get('torrent/' . $key); ?>"><?php echo $category['title']; ?></a></li>
			<?php } ?>
		<?php } ?>
		</ul>
	</div>
	<div class="row">
		<form class="form-horizontal well" role="form">
			<div class="form-group">
				<label for="inputKey" class="col-sm-2 control-label">关键字</label>
				<div class="col-sm-3">
					<input type="text" name="key" class="form-control" id="inputKey">
				</div>
				<div class="col-sm-2">
					<select name="promotion" class="form-control">
						<option>优惠</option>
						<option>FREE</option>
						<option>2XFREE</option>
						<option>2X</option>
						<option>50%</option>
						<option>2X50%</option>
						<option>30%</option>
					</select>
				</div>
			</div>
		</form>
	</div>
	<div class="row well">
		<?php if (isset($subs)) { ?>
			<dl class="dl-horizontal">
				<?php if ($this->length($subs) != 1) { ?>
				<dt>二级分类</dt>
				<dd>
					<ul class="list-inline">
						<?php foreach ($subs as $sid => $sub) { ?>
						<li><a href="<?php echo $this->url->get('torrent/' . $this->dispatcher->getParam('category') . '/' . $sid); ?>"><?php echo $sub['title']; ?></a></li>
						<?php } ?>
					</ul>
				</dd>
				<?php } ?>
				<?php foreach ($tags as $tag) { ?>
				<?php if ($tag['search']) { ?>
				<dt><?php echo $tag['title']; ?></dt>
				<dd>
					<ul class="list-inline">
					<?php foreach ($tag['items'] as $item) { ?>
						<li><?php echo $item; ?></li>
					<?php } ?>
					</ul>
				</dd>
				<?php } ?>
				<?php } ?>
			</dl>
		<?php } ?>
	</div>

	<!-- Torrent List -->
	<div class="row">
		<table class="table table-bordered">
			<thead>
				<tr class="active">
					<th><span class="glyphicon glyphicon-tags"></span></th>
					<th><span class="glyphicon glyphicon-th"></span></th>
					<th><span class="glyphicon glyphicon-comment"></span></th>
					<th><span class="glyphicon glyphicon-time"></span></th>
					<th><span class="glyphicon glyphicon-hdd"></span></th>
					<th><span class="glyphicon glyphicon-upload"></span></th>
					<th><span class="glyphicon glyphicon-download"></span></th>
					<th><span class="glyphicon glyphicon-ok-circle"></span></th>
					<th><span class="glyphicon glyphicon-user"></span></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($torrents as $torrent) { ?>
				<tr>
					<td>分类</td>
					<td>
						<strong>
							<?php if ($torrent->zhtitle) { ?>[<?php echo $torrent->zhtitle; ?>]<?php } ?>
							<?php if ($torrent->entitle) { ?>[<?php echo $torrent->entitle; ?>]<?php } ?>
							<?php if ($torrent->tag1) { ?>[<?php echo $torrent->tag1; ?>]<?php } ?>
							<?php if ($torrent->tag2) { ?>[<?php echo $torrent->tag2; ?>]<?php } ?>
							<?php if ($torrent->tag3) { ?>[<?php echo $torrent->tag3; ?>]<?php } ?>
							<?php if ($torrent->tag4) { ?>[<?php echo $torrent->tag4; ?>]<?php } ?>
						</strong>
						<span class="glyphicon glyphicon-download-alt pull-right"></span>
						<br />
						<span class="glyphicon glyphicon-star-empty pull-right"></span>
						<?php if ($torrent->promotion != 'NORMAL') { ?>
						<span class="label label-success"><?php echo $torrent->promotion; ?></span>
						<?php } ?>
						<small class="text-muted"><?php echo $torrent->subtitle; ?></small>
					</td>
					<td>0</td>
					<td>时间</td>
					<td><?php echo $this->tool->mksize($torrent->size); ?></td>
					<td>10</td>
					<td>5</td>
					<td>30</td>
					<td>HBSpy</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="row">
		<?php echo $pagebar; ?>
	</div>
	<pre><?php echo $this->getContent(); ?></pre>
</div>
