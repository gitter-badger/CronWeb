<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Remove Cronjob</h4>
</div>
<div class="modal-body">
        <p>Are you sure you want to completely remove this cronjob ?</p>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="RemoveBtn" data-loading-text="Removing...">Remove</button>
</div>

<?php if(isset($Dyn_JobID) && is_numeric($Dyn_JobID)): ?>
<script type="text/javascript">
        $(document).ready(function(){
                $('#RemoveBtn').bind('click', function(){
                        $(this).button('loading');
                        $.post('server/hooks/remove-cronjob.php', {'JobID':<?php print($Dyn_JobID); ?>},
                                function(Data){
                                        if(!Data.Error){
                                                GetAllCronjobs();
                                                $('#ConfirmModal').modal('hide');
                                        }else{
                                                alert('An error occurred while removing the cronjob !');
                                        }
                                },
                                'json'
                        );
                });
        });
</script>
<?php endif; ?>

