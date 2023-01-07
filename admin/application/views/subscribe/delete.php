                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body modal-5-body">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                    <h4 class="modal-title" >Are you sure want to delete ?</h4>
                    <!--<p>Are you sure that you want to permenently delete the selected item?</p>-->
                    <form method="post" action="<?= CUSTOM_BASE_URL . 'Subscriber/delete' ?>">
                        <input type="submit" name="delete" class="btn confirm-btn confirm-6-btn" value="Yes">
                        <input type="button" class="btn confirm-btn confirm-6-btn" value="No" data-dismiss="modal">
                        <input type="hidden" name="rowid" class="btn confirm-btn" value="<?php echo $_POST['rowid'] ?>">
                    </form>
                </div>