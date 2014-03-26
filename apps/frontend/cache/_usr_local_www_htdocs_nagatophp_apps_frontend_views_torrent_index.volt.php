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
				<tr>
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
						<strong>[标题][很长][很长][很长][很长][很长][很长][很长][很长][很长][很长][很长][很长]</strong>
						<span class="glyphicon glyphicon-download-alt pull-right"></span>
						<br />
						<span class="glyphicon glyphicon-star-empty pull-right"></span>
						<span class="label label-success">50%</span> <small class="text-muted">这里还有副标题，等等什么乱七八糟的的东西。。。</small>
					</td>
					<td>0</td>
					<td>时间</td>
					<td>100 MB</td>
					<td>10</td>
					<td>5</td>
					<td>30</td>
					<td>HBSpy</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

	</div>
	<pre><?php echo $this->getContent(); ?></pre>
</div>
