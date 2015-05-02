<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Remove All Cronjobs</h4>
</div>
<div class="modal-body">
        <p>Are you sure you want to completely remove all cronjobs ?</p>
        <p><strong>The currently enabled cronjobs will be removed too.</strong></p>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="RemoveAllBtn" data-loading-text="Removing...">Remove All</button>
</div>
<script type="text/javascript">
        $(document).ready(function(){
                $('#RemoveAllBtn').bind('click', function(){
                        var DisBtn = $(this);
                        DisBtn.button('loading');
                        $.getJSON('server/hooks/remove-all-cronjobs.php', function(Data){
                                if(!Data.Error){
                                        GetAllCronjobs();
                                        $('#RemoveAllModal').modal('hide');
                                }else{
                                        $('.modal-body').html('<p>An error occurred while removing the cronjob !</p>');
                                }
                        });
                });
        });
</script>
