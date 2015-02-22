<div id="#all">
        <h3>All created Cronjobs<div id="ajax-indicator" class="pull-right"><img src="/img/loader.gif" valign="middle" />&nbsp;Loading ...</div></h3>
        <p>
                <a href="/new-cronjob.php" class="btn btn-success">New Cronjob</a>&nbsp;
                <a href="/pages/remove-all-cronjobs.php" data-toggle="modal" data-target="#RemoveAllModal" class="btn btn-danger">Remove All Cronjobs</a>
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
                GetAllCronjobs();
        });
</script>
