<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Cronjob Command Details</h4>
</div>
<div class="modal-body">
    <div class="job-name"><strong>Name: </strong><pre style="white-space:pre-wrap;width:558px;"></pre></div>
    <div class="cmd-details"><strong>Command: </strong><pre style="white-space:pre-wrap;width:558px;"></pre></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<?php if(isset($Dyn_JobID) && is_numeric($Dyn_JobID)): ?>
<script type="text/javascript">
    $(document).ready(function(){
        $.post('server/hooks/get-cronjob-cmd-details.php', {'JobID':<?php print($Dyn_JobID); ?>},
            function(Data){
                if(!Data.Error){
                    $('.modal-body .job-name pre').append(Data.JobName);
                    $('.modal-body .cmd-details pre').append(Data.CmdDetails);
                }else{
                    alert('An error occurred while removing the cronjob !');
                }
            },
            'json'
        );
    });
</script>
<?php endif; ?>

