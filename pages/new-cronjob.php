<div id="new">
    <form role="form">
        <div class="col-md-6" style="text-align:right">
            <div class="col-md-6" style="text-align:left">
                <img src="img/new-cronjob.gif" />
            </div>
            <div class="col-md-6" style="text-align:left">
                <div class="form-group">
                    <h4>New job planning</h4>
                    <label for="add-minute">Minute (*)</label>
                    <input id="add-minute" class="form-control add-minute" type="text" placeholder="0-59 or *">
                    <label for="add-hour">Hour (*)</label>
                    <input id="add-hour" class="form-control add-hour" type="text" placeholder="0-23 or *">
                    <label for="add-daymonth">Day of Month (*)</label>
                    <input id="add-daymonth" class="form-control add-daymonth" type="text" placeholder="0-31 or *">
                    <label for="add-month">Month (*)</label>
                    <input id="add-month" class="form-control add-month" type="text" placeholder="0-12 or *">
                    <label for="add-dayweek">Day of Week (*)</label>
                    <input id="add-dayweek" class="form-control add-dayweek" type="text" placeholder="0-6 or *">
                </div>
            </div>
        </div>
        <div class="col-md-6" style="text-align:left;margin-left:0;">
            <div class="col-md-6" style="padding-left:0;">
                <label for="add-name"><h4>Cronjob Name (*)</h4></label>
                <input id="add-name" class="form-control add-name" type="text" placeholder="My new cronjob">
            </div>
            <div class="col-md-6" style="padding-right:0;">
                <label for="add-scripts"><h4>Existing Scripts</h4></label>
                <select id="add-scripts" class="form-control">
                    <option value=""></option>
                </select>
            </div>
            <label for="add-command" style="padding-top:.5em;">
                <h4>Command to Execute (*)</h4>
                <p>Enter either a valid CLI command to run on the system with the current users permissions, or reference an external script for execution.</p>
            </label>
            <textarea id="add-command" class="form-control add-command" style="width:100%;" rows="5" placeholder="/path/to/my/script.py"></textarea>
            <div class="col-md-6" style="padding-top:1em;padding-left:0;">
                <a id="save-btn" class="btn btn-large btn-success">Save New Cronjob</a>
                <br>
                <i style="font-size:8pt">(*): All field of this form are required</i>
            </div>
            <div class="col-md-6">
                <div class="col-md-1" style="padding-top:2em;padding-left:0;">
                    <input id="add-directly-enabled" class="add-directly-enabled" type="checkbox" />
                </div>
                <div class="col-md-10" style="padding-top:2em;padding-left:0;padding-right:0">
                    <label for="add-directly-enabled">Directly enable the cronjob</label>
                </div>
            </div>
        </div>
        <div class="clearfix" />
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        GetInstalledScripts();
        $('#add-scripts').bind('change', function(){
            $('.add-command').val($('#add-scripts option:selected').val());
        });
        $('#save-btn').bind('click', OnSaveNewButtonClick);
        $('.add-directly-enabled').bind('click', function(){
            if(typeof $('.add-directly-enabled').attr('checked') != 'undefined' ){
                $('.add-directly-enabled').removeAttr('checked');
            }else{
                $('.add-directly-enabled').attr('checked', 'checked');
            }
        });
    });
</script>
