function OnRunJobClick(JobPos){
	$('#badge_' + JobPos).removeClass().addClass('badge alert-info').text('RUNNING');
	$('#run_' + JobPos).attr('disabled', 'disabled');

	$.post('server/hooks/run-job.php', {'JobPos':JobPos},
		function(Data){
			GetActiveCronjobs();
		}
	);
}

function OnEnableCronjobClick(JobID){
	$('#ajax-indicator').show();
	$.post('server/hooks/enable-cronjob.php', {'JobID':JobID},
		function(Data){
			if(!Data.Error){
				window.location.replace('all-cronjobs.php');
			}else{
				alert('An error occurred while enabling the cronjob !');
			}
			$('#ajax-indicator').hide();
		},
		'json'
	);
}

function GetJobToEdit(JobID){
	$.post('server/hooks/get-cronjob.php', {'JobID':JobID},
		function(Data){
			if(!Data.Error){
				$.each(Data.Item, function(Key, Val){
					$('.edit-jobid').val(Val.JOB_ID);
					$('.edit-minute').val(Val.JOB_MIN);
					$('.edit-hour').val(Val.JOB_HOUR);
					$('.edit-dayweek').val(Val.JOB_DOW);
					$('.edit-daymonth').val(Val.JOB_DOM);
					$('.edit-month').val(Val.JOB_MON);
					$('.edit-name').val(Val.JOB_NAME);
					$('.edit-command').val(Val.JOB_CMD);
				});
			}else{
				alert('An error occurred while retrieving the cronjob from the database !');
			}
		},
		'json'
	);
}

function OnSaveEditButtonClick(){
	var JobID = $('.edit-jobid').val();
	var Minute = $('.edit-minute').val();
	var Hour = $('.edit-hour').val();
	var DayWeek = $('.edit-dayweek').val();
	var DayMonth = $('.edit-daymonth').val();
	var Month = $('.edit-month').val();
	var Name = $('.edit-name').val();
	var Command = $('.edit-command').val();

	if(JobID == '' || Minute == '' || Hour == '' || DayWeek == '' || DayMonth == '' || Month == '' || Name == '' || Command == ''){
		alert('All fields of the form are required !');
	}else{
		if(Command != '*'){
			$.post('server/hooks/edit-cronjob.php', {'JobID':JobID, 'Minute':Minute, 'Hour':Hour, 'DayWeek':DayWeek, 'DayMonth':DayMonth, 'Month':Month, 'Name':Name, 'Command':Command},
				function(Data){
					if(!Data.Error){
						window.location.replace('all-cronjobs.php');
					}
				},
				'json'
			);
		}else{
			alert ('"*" is not a command !');
		}
	}
}

function OnSaveNewButtonClick(event){
	var Minute = $('.add-minute').val();
	var Hour = $('.add-hour').val();
	var DayWeek = $('.add-dayweek').val();
	var DayMonth = $('.add-daymonth').val();
	var Month = $('.add-month').val();
	var Name = $('.add-name').val();
	var Command = $('.add-command').val();
    var DirectlyEnabled = (typeof $('.add-directly-enabled').attr('checked') !== 'undefined' && $('.add-directly-enabled').attr('checked') !== false)?'Enable':'Disable';

	if(Minute == '' || Hour == '' || DayWeek == '' || DayMonth == '' || Month == '' || Name == '' || Command == ''){
		alert('All fields of the form are required !');
	}else{
		if(Command != '*'){
			$.post('server/hooks/add-new-cronjob.php', {'Minute':Minute, 'Hour':Hour, 'DayWeek':DayWeek, 'DayMonth':DayMonth, 'Month':Month, 'Name':Name, 'Command':Command, 'DirectlyEnabled':DirectlyEnabled},
				function(Data){
					if(Data.Inserted){
						window.location.replace('all-cronjobs.php');
					}else{
						alert('An error occurred during the creation process ...');
					}
				},
				'json'
			);
		}else{
			alert('"*" is not a command !');
		}
	}
}

function GetInstalledScripts(){
	$.getJSON('server/hooks/get-installed-scripts.php', function(Data){
		if(!Data.Error){
			var Select = $("#add-scripts");
			$.each(Data.Scripts, function(){
				Select.append($("<option />").val(this.PATH).text(this.NAME));
			});
		}
	});
}

function GetActiveCronjobs(){
    $('#ajax-indicator').show();
	$.getJSON('server/hooks/get-enabled-cronjobs.php', function(Data){
		var Items = '';
		if(Data.NBItems != 0){
			$.each(Data.Items, function(Key, Val){
				Items += '<tr>';
				Command = '';
				$.each(Val.Job, function(X, Y){
					if(X < 5){
						Items += '<td>' + Y + '</td>';
					}else{
						Command += Y + ' ';
					}
				});
				Items += '<td>' + Command.substring(0, 61);
				if(Command.length > 60){
					Items += '...';
				}
				Items += '</td>';

				Items += '<td style="text-align:right">';
							
				var ISRUNNING = false;
				if(Val.LastState == 4){
					Items += '<span id="badge_' + Key + '" class="badge alert-info">RUNNING</span>&nbsp;';
					ISRUNNING = true;
				}else{
					if(Val.LastState == 0){
						Items += '<span id="badge_' + Key + '" class="badge alert-success">OK</span>&nbsp;';
					}else{
						if(Val.LastState == 1){
							Items += '<span id="badge_' + Key + '" class="badge alert-warning">WARN</span>&nbsp;';
						}else{
							if(Val.LastState == 2){
								Items += '<span id="badge_' + Key + '" class="badge alert-danger">CRIT</span>&nbsp;';
							}else{
								Items += '<span id="badge_' + Key + '" class="badge alert-info">UNKW</span>&nbsp;';
							}
						}
					}
				}

				if(!ISRUNNING){
					Items += '<a href="#" id="run_' + Key + '" class="btn btn-success btn-xs" data-placement="top" title="Run Job"><span class="glyphicon glyphicon-play" onclick="OnRunJobClick(' + Key + ')"></a>&nbsp;';
				}else{
					Items += '<a href="#" id="run_' + Key + '" class="btn btn-success btn-xs" data-placement="top" title="Run Job" disabled="disabled"><span class="glyphicon glyphicon-play" onclick="OnRunJobClick(' + Key + ')"></a>&nbsp;';
				}

				Items += '<div class="btn-group">';
				Items += '<a href="modals/get-history.php@JobPos=' + Key + '" data-toggle="modal" data-target="#HistoryModal" class="btn btn-info btn-xs" data-placement="top" title="View History"><span class="glyphicon glyphicon-th-list"></a>';
				Items += '<a href="modals/disable-cronjob.php@JobPos=' + Key + '" data-toggle="modal" data-target="#ConfirmModal" class="btn btn-warning btn-xs" data-placement="top" title="Disable Cronjob"><span class="glyphicon glyphicon-remove"></span></a>';
				Items += '</div></td>';
				Items += '</tr>';
			});
		}else{
			Items += '<tr>';
			Items += '<td colspan="7">No Active Cronjobs</td>';
			Items += '</tr>';
		}
		
		$('.active-job-list').html(Items);
		$('.btn-info, .btn-warning, .btn-success').tooltip();
		$('body').on('hidden.bs.modal', '.modal', function(){
			$(this).removeData('bs.modal');
		});

		$('#ajax-indicator').hide();
	});
}

function GetAllCronjobs(){
	$('#ajax-indicator').show();
	$.getJSON('server/hooks/get-all-cronjobs.php', function(Data){
		var Items = '';
		if(Data.NBItems != 0){
			$.each(Data.Items, function(Key, Val){
				Items += '<tr>';
				Items += '<td>' + Val.JOB_MIN + '</td>';
				Items += '<td>' + Val.JOB_HOUR + '</td>';
				Items += '<td>' + Val.JOB_DOM + '</td>';
				Items += '<td>' + Val.JOB_MON + '</td>';
				Items += '<td>' + Val.JOB_DOW + '</td>';

				Items += '<td>' + Val.JOB_CMD.substring(0, 61);
				if(Val.JOB_CMD.length > 60){
					Items += '...';
				}
				Items += '</td>';

				Items += '<td style="text-align:right"><div class="btn-group">';

				if(Val.JOB_IS_ENABLED == 0){
					Items += '<a href="modals/cronjob-cmd-details.php@JobID=' + Val.JOB_ID + '" data-toggle="modal" data-target="#CmdDetailsModal" class="btn btn-info btn-xs" data-placement="top" title="Command details"><span class="glyphicon glyphicon-search"></a>';
					Items += '<a href="#" class="btn btn-success btn-xs" data-placement="top" title="Enable Cronjob" onclick="OnEnableCronjobClick(' + Val.JOB_ID + ')"><span class="glyphicon glyphicon-ok"></a>';
					Items += '<a href="edit-cronjob.php@JobID=' + Val.JOB_ID + '" class="btn btn-primary btn-xs" data-placement="top" title="Edit Cronjob"><span class="glyphicon glyphicon-pencil"></a>';
					Items += '<a href="modals/remove-cronjob.php@JobID=' + Val.JOB_ID + '" data-toggle="modal" data-target="#ConfirmModal" class="btn btn-warning btn-xs" data-placement="top" title="Remove Cronjob"><span class="glyphicon glyphicon-remove"></a>';
				}else{
					Items += '<i style="font-size:8pt">Cronjob is enabled</i>';
				}
				Items += '</div></td>';
				Items += '</tr>';
			});
		}else{
			Items += '<tr>';
			Items += '<td colspan="7">No Cronjobs in the database</td>';
			Items += '</tr>';
		}

		$('.active-job-list').html(Items);
		$('.btn-success, .btn-primary, .btn-warning, .btn-info').tooltip();
		$('body').on('hidden.bs.modal', '.modal', function(){
			$(this).removeData('bs.modal');
		});

		$('#ajax-indicator').hide();
	});
}

function GetSettings(){
	$('#ajax-indicator').show();
	
	$.getJSON('server/hooks/admin-get-settings.php', function(Data){
		if(!Data.Error){
			$('#active-refresh-time').val(Data.active_refresh_time);
			
			$('#ajax-indicator').hide();
		}else{
			alert('An error occurred while retrieving settings. Please check your database !');
		}
	});
}

function GetSetting(SettingKey){
	var SettingValue;
	
	$.ajax({
        url: 'server/hooks/admin-get-setting.php',
        method: 'POST',
		dataType: 'json',
		data:{'SettingKey':SettingKey},
        async: false,
        cache: false,
        timeout: 30000,
        error: function(){
            alert('An error occurred while retrieving setting value (' + SettingKey + ') !');
        },
        success: function(Data){
            if(!Data.Error){
				SettingValue = Data.SettingValue;
			}else{
				alert('An error occurred while retrieving setting value (' + SettingKey + ') !');
			}
        }
    });
	
	return SettingValue;
}

function SaveSettings(ActiveRefreshTime){
	$('#ajax-indicator').show();
	$.ajax({
        url: 'server/hooks/admin-save-settings.php',
        method: 'POST',
		dataType: 'json',
		data:{'ActiveRefreshTime':ActiveRefreshTime},
        async: false,
        cache: false,
        timeout: 30000,
        error: function(){
            alert('An error occurred while saving settings !');
        },
        success: function(Data){
            if(Data.Error){
				alert('An error occurred while saving settings !');
			}
        }
    });
	$('#ajax-indicator').hide();
}

function GetScripts(){
	$('#ajax-indicator').show();
	
	$.getJSON('server/hooks/admin-get-scripts.php', function(Data){
		if(!Data.Error){
			var Items = '';
			if(Data.NBItems != 0){
				$.each(Data.Items, function(Key, Val){
					Items += '<tr>';
					Items += '<td>' + Val.NAME + '</td>';
					Items += '<td><i>' + Val.INFO + '</i></td>';

					Items += '<td style="text-align:right"><div class="btn-group">';
	
					Items += '</div></td>';
					Items += '</tr>';
				});
			}else{
				Items += '<tr>';
				Items += '<td colspan="3">No scripts on the server</td>';
				Items += '</tr>';
			}
	
			$('.scripts-list').html(Items);
			$('#ajax-indicator').hide();
		}else{
			alert('An error occurred while retrieving scripts !');
		}
	});
}

function GetUsers(){
	$('#ajax-indicator').show();
	
	$.getJSON('server/hooks/admin-get-users.php', function(Data){
		if(!Data.Error){
			var Items = '';
			if(Data.NBItems != 0){
				$.each(Data.Items, function(Key, Val){
					Items += '<tr>';
					Items += '<td>' + Val.USER_LOGIN + '</td>';
					Items += '<td>' + Val.USER_NAME + '</td>';
					
					var LastModificationDate = new Date(Val.USER_MODIFICATION_DATE * 1000);
					var LMDDate = LastModificationDate.getDate() > 9 ? LastModificationDate.getDate() : '0' + LastModificationDate.getDate();
					var LMDMonth = LastModificationDate.getMonth() >= 9 ? (LastModificationDate.getMonth() + 1) : '0' + (LastModificationDate.getMonth() + 1);
					Items += '<td>' + LMDMonth + '/' + LMDDate + '/' + LastModificationDate.getFullYear() + '</td>';
					
					Items += '<td>' + Val.ROLE_NAME + '</td>';
					Items += '<td style="text-align:right"><div class="btn-group">';
	
					Items += '<a href="modals/edit-user.php@UserID=' + Val.USER_ID + '" data-toggle="modal" data-target="#EditModal" class="btn btn-primary btn-xs" data-placement="top" title="Edit User"><span class="glyphicon glyphicon-pencil"></a>';
					Items += '<a href="modals/remove-user.php@UserID=' + Val.USER_ID + '" data-toggle="modal" data-target="#RemoveModal" class="btn btn-warning btn-xs" data-placement="top" title="Remove User"><span class="glyphicon glyphicon-remove"></a>';
					
					Items += '</div></td>';
					Items += '</tr>';
				});
			}else{
				Items += '<tr>';
				Items += '<td colspan="5">No user in the database</td>';
				Items += '</tr>';
			}
	
			$('.users-list').html(Items);
			$('.btn-primary, .btn-warning').tooltip();
			$('body').on('hidden.bs.modal', '.modal', function(){
				window.location.reload();
			});

			$('#ajax-indicator').hide();
		}else{
			alert('An error occurred while retrieving users !');
		}
	});
}

function GetUser(UserID){
	$.ajax({
        url: 'server/hooks/admin-get-user.php',
        method: 'POST',
		dataType: 'json',
		data:{'UserID':UserID},
        async: false,
        cache: false,
        timeout: 30000,
        error: function(){
            alert('An error occurred while retrieving user (' + UserID + ') !');
        },
        success: function(Data){
            if(!Data.Error){
				$('#username').val(Data.Item.USER_NAME);
				$('#login').val(Data.Item.USER_LOGIN);
				$('#role-select').val(Data.Item.USER_ROLE);
			}else{
				alert('An error occurred while retrieving user (' + UserID + ') !');
			}
        }
    });
}

function GetRoles(){
	$.getJSON('server/hooks/admin-get-roles.php', function(Data){
		if(!Data.Error){
			var Select = $("#role-select");
			$.each(Data.Items, function(){
				Select.append($("<option />").val(this.ROLE_ID).text(this.ROLE_NAME));
			});
		}
	});
}