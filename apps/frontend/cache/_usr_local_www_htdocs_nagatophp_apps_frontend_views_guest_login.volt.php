<div class="container">
	<div class="row">
	</div>
	<div class="row">
		<div class="col-md-9">
		</div>
		<div class="col-md-3">
			<div class="panel panel-primary">
				<div class="panel-heading">用户登录</div>
				<div class="panel-body">
					<form class="form" id="loginform">
						<div class="form-group" id="div_username">
							<label class="control-label hide" for="username" id="label_username"></label>
							<input type="text" name="username" id="username" class="form-control" placeholder="用户名" required="required" />
							<span class="glyphicon glyphicon-warning-sign form-control-feedback hide"></span>
						</div>
						<div class="form-group" id="div_passowrd">
							<label class="control-label hide" for="password" id="label_password"></label>
							<input type="password" name="password" id="password" class="form-control" placeholder="密码" required="required" />
							<span class="glyphicon glyphicon-remove form-control-feedback hide"></span>
						</div>
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" /> 免登录
								</label>
								<label class="pull-right">
									<p>忘记密码</p>
								</label>
							</div>
						</div>
						<br />
						<div class="form-group">
							<button type="submit" class="btn btn-primary">登录</button>
							<a href="#" class="btn btn-default pull-right">注册</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#loginform').submit(function (){
		$.post(null, $(this).serialize(), function (data){
			if(data.error == 'USER'){
				$('#div_username').addClass('has-warning has-feedback')
				$('#label_username').html('用户名不存在').removeClass('hide').next().focus().next().removeClass('hide');

				$('#div_passowrd').removeClass('has-error has-feedback');
				$('#label_password').addClass('hide').empty().next().next().addClass('hide');
			} else if(data.error == 'PWD'){
				$('#div_passowrd').addClass('has-error has-feedback')
				$('#label_password').html('密码错误').removeClass('hide').next().focus().next().removeClass('hide');

				$('#div_username').removeClass('has-warning has-feedback');
				$('#label_username').addClass('hide').empty().next().next().addClass('hide');
			} else {
				window.location.reload();
			}

		});
		
		return false;
	});
</script>
