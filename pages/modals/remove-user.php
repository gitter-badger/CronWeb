<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Remove User</h4>
</div>
<div class="modal-body">
        <p>Are you sure you want to completely remove this user ?</p>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="RemoveBtn" data-loading-text="Removing...">Remove</button>
</div>

<?php if(isset($Dyn_UserID) && is_numeric($Dyn_UserID)): ?>
<script type="text/javascript">
        $(document).ready(function(){
                $('#RemoveBtn').bind('click', function(){
                        $(this).button('loading');
                        $.post('server/hooks/remove-user.php', {'UserID':<?php print($Dyn_UserID); ?>},
                                function(Data){
                                        if(!Data.Error){
                                                GetUsers();
                                                $('#RemoveModal').modal('hide');
                                        }else{
                                                alert('An error occurred while removing the user !');
                                        }
                                },
                                'json'
                        );
                });
        });
</script>
<?php endif; ?>

