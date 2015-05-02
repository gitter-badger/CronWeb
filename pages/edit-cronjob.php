<div id="edit">
        <form role="form">
                <div class="col-md-6" style="text-align:right">
                        <div class="col-md-6" style="text-align:left">
                                <img src="img/new-cronjob.gif" />
                        </div>
                        <div class="col-md-6" style="text-align:left">
                                <div class="form-group">
                                        <h4>Job planning</h4>
                                        <label>Minute (*)</label>
                                        <input class="form-control edit-minute" type="text" placeholder="0-59 or *">
                                        <label>Hour (*)</label>
                                        <input class="form-control edit-hour" type="text" placeholder="0-23 or *">
                                        <label>Day of Month (*)</label>
                                        <input class="form-control edit-daymonth" type="text" placeholder="0-31 or *">
                                        <label>Month (*)</label>
                                        <input class="form-control edit-month" type="text" placeholder="0-12 or *">
                                        <label>Day of Week (*)</label>
                                        <input class="form-control edit-dayweek" type="text" placeholder="0-6 or *">
                                </div>
                        </div>
                </div>
                <div class="col-md-6" style="text-align:left;margin-left:0;">
                        <label for="edit-name">
                                <h4>Cronjob Name (*)</h4>
                        </label>
                        <input class="form-control edit-jobid" type="hidden" />
                        <input class="form-control edit-name" id="edit-name" type="text" placeholder="My new cronjob">
                        <label for="edit-command">
                                <h4>Command to Execute (*)</h4>
                                <p>Enter either a valid CLI command to run on the system with the current users permissions, or reference a external script for execution.</p>
                        </label>
                        <textarea class="form-control edit-command" id="edit-command" style="width:100%;" rows="5" placeholder="/path/to/my/script.py"></textarea>
                        <div class="row" style="padding-top:1em;">
                                <div class="col-md-8">
                                        <a id="save-edit-btn" class="btn btn-large btn-success">Save Modifications</a>
                                        <br>
                                        <i style="font-size:8pt">(*): All field of this form are required</i>
                                </div>
                        </div>
                </div>
                <div class="clearfix" />
        </form>
</div>
<script type="text/javascript">
        $(document).ready(function(){
                $('#save-edit-btn').bind('click', OnSaveEditButtonClick);
                <?php if(is_numeric($Dyn_JobID)): ?>
                GetJobToEdit(<?php print($Dyn_JobID); ?>);
                <?php endif; ?>
        });
</script>
