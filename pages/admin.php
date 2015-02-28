<div id="#admin">
	<h3>Admin<div id="ajax-indicator" class="pull-right"><img src="/img/loader.gif" valign="middle" />&nbsp;Loading ...</div></h3>
	<div role="tabpanel">
		<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
				<li role="presentation"><a href="#scripts" aria-controls="scripts" role="tab" data-toggle="tab">Scripts</a></li>
				<li role="presentation"><a href="#users" aria-controls="roles" role="tab" data-toggle="tab">Roles</a></li>
				<li role="presentation"><a href="#users" aria-controls="users" role="tab" data-toggle="tab">Users</a></li>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="settings">
				<div class="row">
					<div class="pull-right">
						<div class="col-md-6" style="padding-top:1em;padding-left:0;">
							<a id="save-btn" class="btn btn-large btn-success">Save Settings</a>
						</div>
					</div>
				</div>
				<form role="form">
					<div class="form-group">
						<h5 style="margin-bottom:0">
							<label for="active-refresh-time">Active CronJobs - Refresh page every</label>
						</h5>
						<input type="text" id="active-refresh-time" class="form-control" aria-describedby="active-refresh-time-help">
						<span id="active-refresh-time-help" class="help-block">Enter a number of seconds. The value should be numeric !</span>
					</div>
				</form>
				<div class="row">
					<div class="pull-right">
						<div class="col-md-6" style="padding-top:1em;padding-left:0;">
							<a id="save-btn" class="btn btn-large btn-success">Save Settings</a>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="scripts">
				<p>Under construction</p>
			</div>
			<div role="tabpanel" class="tab-pane" id="roles">
				<p>Under construction</p>
			</div>
			<div role="tabpanel" class="tab-pane" id="users">
				<p>Under construction</p>
			</div>
		</div>
	</div>
	<div id="ConfirmModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="ConfirmModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
	<div id="CmdDetailsModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="CmdDetailsModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
	<div id="RemoveAllModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="RemoveAllModalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		GetSettings();
	});
</script>