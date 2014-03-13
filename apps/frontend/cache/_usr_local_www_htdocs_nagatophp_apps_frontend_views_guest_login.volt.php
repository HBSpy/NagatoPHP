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
					<?php echo $this->tag->form(array('login', 'class' => 'form', 'id' => 'loginform')); ?>
						<div class="form-group" id="div_username">
							<label class="control-label hide" for="username" id="label_username"></label>
							<?php echo $this->tag->textField(array('username', 'class' => 'form-control', 'placeholder' => '用户名', 'required' => 'required')); ?>
							<span class="glyphicon glyphicon-warning-sign form-control-feedback hide"></span>
						</div>
						<div class="form-group" id="div_passowrd">
							<label class="control-label hide" for="password" id="label_password"></label>
							<?php echo $this->tag->passwordField(array('password', 'class' => 'form-control', 'placeholder' => '密码', 'required' => 'required')); ?>
							<span class="glyphicon glyphicon-remove form-control-feedback hide"></span>
						</div>
						<div class="form-group">
							<div class="checkbox">
								<label>
									<?php echo $this->tag->checkField(array('remember')); ?> 免登录
								</label>
								<label class="pull-right">
									<p>忘记密码</p>
								</label>
							</div>
						</div>
						<br />
						<div class="form-group">
							<?php echo $this->tag->submitButton(array('登录', 'class' => 'btn btn-primary')); ?>
							<?php echo $this->tag->linkTo(array('reg', '注册', 'class' => 'btn btn-default pull-right')); ?>
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
			console.log(data);
			if(data.error == 'USER'){
				$('#div_username').addClass('has-warning has-feedback')
				$('#label_username').html('用户名不存在').next().focus().next().removeClass('hide');
			}
		});
		
		return false;
	});
</script>
