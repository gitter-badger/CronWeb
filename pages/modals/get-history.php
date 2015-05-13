<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">History</h4>
</div>
<div class="modal-body" style="height:320px;">
    <div class="modal-body-scroll" style="overflow-y:auto;height:300px;"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>

<?php if(isset($Dyn_JobPos) && is_numeric($Dyn_JobPos)): ?>
<script type="text/javascript">
    $(document).ready(function(){
        $.post('server/hooks/get-history-cronjob.php', {'JobPos':<?php print($Dyn_JobPos); ?>}, function(Data){
            if(!Data.Error){
                if(Data.NBContents != 0){
                    var HTML = '';
                    $.each(Data.Contents, function(Key, Val){
                        if(Val.indexOf('0') == 0){
                            HTML += '<span class="badge alert-success">OK</span>&nbsp;' + Val + '<br />';
                        }else{
                            if(Val.indexOf('1') == 0){
                                HTML += '<span class="badge alert-warning">WARN</span>&nbsp;' + Val + '<br />';
                            }else{
                                HTML += '<span class="badge alert-danger">CRIT</span>&nbsp;' + Val + '<br />';
                            }
                        }
                    });
                    $('.modal-body-scroll').html(HTML);
                }else{
                    $('.modal-body').css('height', '100px');
                    $('.modal-body').remove('.modal-body-scroll');
                    $('.modal-body').html('<p>No history for this cronjob !</p>');
                }
            }else{
                $('.modal-body').css('height', '100px');
                $('.modal-body').remove('.modal-body-scroll');
                $('.modal-body').html('<p>Unable to load history for this job ...</p>');
            }
        },
        'json'
    );
});
</script>
<?php else: ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.modal-body').css('height', '100px');
        $('.modal-body').remove('.modal-body-scroll');
        $('.modal-body').html('<p>Unable to load history for this job ...</p>');
    });
</script>
<?php endif; ?>

