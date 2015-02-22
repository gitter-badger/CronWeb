<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Disable All Cronjobs</h4>
</div>
<div class="modal-body">
        <p>Are you sure to completely clean the current crontab ?</p>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="DisableAllBtn" data-loading-text="Disabling...">Disable All</button>
</div>
<script type="text/javascript">
        $(document).ready(function(){
                $('#DisableAllBtn').bind('click', function(){
                        var DisBtn = $(this);
                        DisBtn.button('loading');
                        $.getJSON('/server/hooks/disable-all-cronjobs.php', function(Data){
                                if(Data.MySQL && Data.Crontab){
                                        GetActiveCronjobs();
                                        $('#DisableAllModal').modal('hide');
                                }else{
                                        DisBtn.button('reset');
                                        $('.modal-body').remove('p');
                                        if(!Data.MySQL){
                                                $('.modal-body').append('<p>An error occurred while disabling all cronjobs in the database !</p>');
                                        }
                                        if(!Data.Crontab){
                                                $('.modal-body').append('<p>An error occurred while disabling all cronjobs in the crontab !</p>');
                                        }
                                }
                        });
                });
        });
</script>
