<div class="panel panel-primary">
	<div class="panel-heading"><strong>{{ dispatcher.getParam('name')|upper }} 配置</strong></div>
	<div class="panel-body">
		<form class="form-horizontal" id="form-config" role="form">
			{% for key, config in configs %}
			<div class="form-group">
				<label for="{{ key }}" class="col-sm-2 control-label">{{ config['title'] }}</label>
				<div class="col-sm-10">
					<input type="text" name="{{ key }}" class="form-control" id="{{ key }}" value="{{ config['value'] }}" />
				</div>
			</div>
			{% endfor %}
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
		$.post('{{ url('admin/config/' ~ dispatcher.getParam('name')) }}', $(this).serialize(), function(data){
			if(data){
				window.location.reload();
			}
		});
		return false;
	});
</script>
