<div id="#admin">
	<h3>Admin<div id="ajax-indicator" class="pull-right"><img src="img/loader.gif" valign="middle" />&nbsp;Loading ...</div></h3>
	<div role="tabpanel">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
			<li role="presentation"><a href="#scripts" aria-controls="scripts" role="tab" data-toggle="tab">Scripts</a></li>
			<!-- li role="presentation"><a href="#roles" aria-controls="roles" role="tab" data-toggle="tab">Roles</a></li -->
			<li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="settings">
				<div class="row">
					<div class="pull-right">
						<div class="col-md-6" style="padding-top:1em;padding-left:0;">
							<a id="save-btn-top" class="btn btn-large btn-success">Save Settings</a>
						</div>
					</div>
				</div>
				<form role="form">
					<div class="form-group">
						<h5 style="margin-bottom:0">
							<label for="active-refresh-time">Active CronJobs - Refresh page every</label>
						</h5>
						<input type="text" id="active-refresh-time" class="form-control" aria-describedby="active-refresh-time-help">
						<span id="active-refresh-time-help" class="help-block">Enter a number of seconds (1-99). The value should be numeric !</span>
					</div>
				</form>
				<div class="row">
					<div class="pull-right">
						<div class="col-md-6" style="padding-top:1em;padding-left:0;">
							<a id="save-btn-bot" class="btn btn-large btn-success">Save Settings</a>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="scripts">
				<table class="table table-striped">
			        <thead>
			            <tr>
			                <th width="25%">Name</th>
			                <th width="50%">Info</th>
			                <th width="25%"></th>
			            </tr>
			        </thead>
			        <tbody class="scripts-list"></tbody>
			    </table>
			</div>
			<!-- div role="tabpanel" class="tab-pane" id="roles">
				<p>Under construction</p>
			</div -->
			<div role="tabpanel" class="tab-pane" id="users">
				<div class="row">
					<div class="pull-right">
						<div class="col-md-6" style="padding-top:1em;padding-left:0;">
							<a href="modals/new-user.php" data-toggle="modal" data-target="#NewUserModal" class="btn btn-large btn-success">New User</a>
						</div>
					</div>
				</div>
				<table class="table table-striped">
			        <thead>
			            <tr>
			                <th width="20%">Login</th>
							<th width="20%">Name</th>
			                <th width="20%">Modification</th>
							<th width="20%">Role</th>
			                <th width="20%"></th>
			            </tr>
			        </thead>
			        <tbody class="users-list"></tbody>
			    </table>
			</div>
		</div>
	</div>
	<div id="NewUserModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="NewUserModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
	<div id="EditModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="EditModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
	<div id="RemoveModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="RemoveModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		// Javascript to enable link to tab
		var url = document.location.toString();
		if (url.match('#')){
    		$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
		}
		// Change hash for page-reload
		$('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function(e){
    		window.location.hash = e.target.hash;
		});
		
		// Settings tab
		GetSettings();
		$('#save-btn-top, #save-btn-bot').bind('click', function(){
			SaveSettings($('#active-refresh-time').val());
		});
		
		// Scripts tab
		GetScripts();
		
		// Users tab
		GetUsers();
	});
</script>