<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Disable Cronjob</h4>
</div>
<div class="modal-body">
        <p>Are you sure you want to disable this cronjob ?</p>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="DisableBtn" data-loading-text="Disabling...">Disable</button>
</div>

<?php if(isset($_GET['JobPos']) && is_numeric($_GET['JobPos'])): ?>
<script type="text/javascript">
        $(document).ready(function(){
                $('#DisableBtn').bind('click', function(){
                        $(this).button('loading');
                        $.post('/server/hooks/disable-cronjob.php', {'JobPos':<?php print($_GET['JobPos']); ?>},
                                function(Data){
                                        if(!Data.Error){
                                                GetActiveCronjobs();
                                                $('#ConfirmModal').modal('hide');
                                        }else{
                                                alert('An error occurred while disabling the cronjob !');
                                        }
                                },
                                'json'
                        );
                });
        });
</script>
<?php endif; ?>

