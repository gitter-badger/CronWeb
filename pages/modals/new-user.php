<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">New User</h4>
</div>
<div class="modal-body" style="height:310px;">
    <div class="modal-body-scroll" style="overflow-y:auto;height:290px;">
        <form role="form">
            <div class="form-group">
                <h5 style="margin-bottom:0">
					<label for="role-select">Role</label>
				</h5>
                <select id="role-select" class="form-control">
                    <option value="0"></option>
                </select>
            </div>
            <div class="form-group">
				<h5 style="margin-bottom:0">
					<label for="username">User Name</label>
				</h5>
				<input type="text" id="username" class="form-control" maxlength="255" />
			</div>
			<div class="form-group">
				<h5 style="margin-bottom:0">
					<label for="login">Login</label>
				</h5>
				<input type="text" id="login" class="form-control" maxlength="100" />
			</div>
            <div class="form-inline">
                <div class="form-group" style="width:47%">
				    <h5 style="margin-bottom:0">
					   <label for="password">Password</label>
			 	    </h5>
				    <input type="password" id="password" class="form-control" style="width:100%" maxlength="50" />
                </div>
                <div class="form-group pull-right" style="width:47%">
				    <h5 style="margin-bottom:0">
					   <label for="password-confirm">Confirm Password</label>
			 	    </h5>
				    <input type="password" id="password-confirm" class="form-control" style="width:100%" maxlength="50" />
                </div>
			</div>
		</form>
    </div>
</div>
<div class="modal-footer">
    <span id="error-msg" class="alert-danger pull-left" style="background:none;margin-top:8px;"></span>
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success" id="NewUserCreationBtn" data-loading-text="Creating...">Create</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        GetRoles();
        
        $('#NewUserCreationBtn').bind('click', function(){
            if ($('#username').val().length > 0 && $('#login').val().length > 0 && $('#password').val().length > 0 && $('#password-confirm').val().length > 0 && $('#role-select').val() > 0 && $('#password').val() == $('#password-confirm').val()){
                var CreateBtn = $(this);
                CreateBtn.button('loading');
                $.ajax({
                    url: 'server/hooks/create-new-user.php',
                    method: 'POST',
            		dataType: 'json',
            		data:{
                        'Username':$('#username').val(),
                        'Login':$('#login').val(),
                        'Password':$('#password').val(),
                        'PasswordConfirm':$('#password-confirm').val(),
                        'Role':$('#role-select').val()
                    },
                    async: false,
                    cache: false,
                    timeout: 30000,
                    error: function(){
                        $('#error-msg').html(Data.ErrorMsg);
                    },
                    success: function(Data){
                        if(!Data.Error){
                            window.location.reload();
                        }else{
                            $('#error-msg').html(Data.ErrorMsg);
                        }
                    }
                });
            }else{
                $('#error-msg').html('Error while creating the new user. Check the form !');
            }
        });
    });
</script>