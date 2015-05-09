<div id="active">
    <h3>Active Cronjobs <span class="muted">Refresh every XXs</span><div id="ajax-indicator" class="pull-right"><img src="img/loader.gif" valign="middle" />&nbsp;Loading ...</div></h3>
    <p>
        <a href="modals/disable-all-cronjobs.php" data-toggle="modal" data-target="#DisableAllModal" class="btn btn-danger disable-all-btn">Disable All Jobs</a>
    </p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">Minute</th>
                <th width="5%">Hour</th>
                <th width="10%">Day of Month</th>
                <th width="5%">Month</th>
                <th width="10%">Day of Week</th>
                <th width="40%">Command</th>
                <th width="25%"></th>
            </tr>
        </thead>
        <tbody class="active-job-list"></tbody>
    </table>
    <div id="HistoryModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="HistoryModalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="ConfirmModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="ConfirmModalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="RunJobModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="RunJobModalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <div id="DisableAllModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="DisableAllModalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var RefreshTime = GetSetting("active_refresh_time");

        function GetActiveCronjobsAndDisplayTime(RefreshTime){
            GetActiveCronjobs();

            var RefreshDate = new Date();
            var Hours = RefreshDate.getHours() < 10 ? '0' + RefreshDate.getHours() : RefreshDate.getHours();
            var Minutes = RefreshDate.getMinutes() < 10 ? '0' + RefreshDate.getMinutes() : RefreshDate.getMinutes();
            var Seconds = RefreshDate.getSeconds() < 10 ? '0' + RefreshDate.getSeconds() : RefreshDate.getSeconds();
            var FormatedDate = Hours + ':' + Minutes + ':' + Seconds;

            $('#active span.muted').text('Refresh every ' + RefreshTime + 's (' + FormatedDate + ')');
        }

        setInterval(function(){ GetActiveCronjobsAndDisplayTime(RefreshTime); }, RefreshTime * 1000);
        GetActiveCronjobsAndDisplayTime(RefreshTime);
});
</script>
