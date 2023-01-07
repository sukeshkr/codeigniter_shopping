<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
                <div class="modal-body">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    <h4 class="modal-title" >Are you sure want to delete ?</h4>
                    <!--<p>Are you sure that you want to permenently delete the selected item?</p>-->
                     <form method="post" action="<?= CUSTOM_BASE_URL . 'User/delete' ?>">
                        <input type="submit" class="btn confirm-btn" name=delete value="Yes">
                        <input type="button" class="btn confirm-btn" value="No" data-dismiss="modal">
                        <input name="id" type="hidden" value="<?php echo $_POST['rowid'] ?>">
                      
                    </form>
                </div>