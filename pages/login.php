<div id="home">
    <div class="jumbotron" style="padding:15px 60px;">
        <h3>Please, login!</h3>
        <form role="form" style="width:300px;margin:30px auto 0;">
			<div class="form-group">
				<input type="text" id="user_login" class="form-control" placeholder="User Login" />
			</div>
			<div class="form-group">
				<input type="password" id="user_password" class="form-control" placeholder="User Password" />
			</div>
			<div class="form-group" style="padding-top:1.5em;">
				<div id="error-msg" class="alert alert-danger" role="alert" style="position:absolute;width:300px;display:none;z-index:99999;">OR</div>
				<a id="sign-in-btn" class="btn btn-primary" role="button" data-loading-text="Connection..." style="padding:9px 24px;">Sign in</a>
			</div>
		</form>
    </div>
    <hr />
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#sign-in-btn').bind('click', function(){
			if($('#user_login').val().length > 0 && $('#user_password').val().length){
				var ConnectBtn = $(this);
                ConnectBtn.button('loading');
				$.ajax({
                    url: 'server/hooks/user-login.php',
                    method: 'POST',
            		dataType: 'json',
            		data:{
                        'Login':$('#user_login').val(),
                        'Password':$('#user_password').val()
                    },
                    async: false,
                    cache: false,
                    timeout: 30000,
                    error: function(xhr, status, error){
                        $('#error-msg').show();
                        $('#error-msg').text(xhr.responseText);
                        
                        ConnectBtn.button('reset');
                        
                        var iDInterval = setInterval(function(){ $('#error-msg').hide(); clearInterval(iDInterval); }, 3000);
                    },
                    success: function(Data){
                        if(!Data.Error){
                            document.location.href = 'home.php';
                        }else{
                            $('#error-msg').show();
                            $('#error-msg').text(Data.ErrorMsg);
                            
                            ConnectBtn.button('reset');
                            
                            var iDInterval = setInterval(function(){ $('#error-msg').hide(); clearInterval(iDInterval); }, 3000);
                        }
                    }
                });
			}else{
				$('#error-msg').show();
				$('#error-msg').text('Please fill all the fields of the login form !');
                
                ConnectBtn.button('reset');
                
                var iDInterval = setInterval(function(){ $('#error-msg').hide(); clearInterval(iDInterval); }, 3000);
			}
		});
	});
</script>
