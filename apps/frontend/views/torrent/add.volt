<div class="container">
	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label for="torrent" class="col-sm-2 control-label">种子文件</label>
			<div class="col-sm-10">
				<input type="file" class="form-control" id="torrent">
			</div>
		</div>
		<div class="form-group">
			<label for="title" class="col-sm-2 control-label">名称</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" id="inputPassword3" placeholder="Password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox"> Remember me
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Sign in</button>
			</div>
		</div>
	</form>
</div>

<pre>{{ content() }}</pre>
