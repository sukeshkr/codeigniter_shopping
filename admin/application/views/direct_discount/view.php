
    <table class="table table-striped table-bordered table-hover">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Products</h4>
        </div>
     <tbody>

        <?php foreach ($result as $row) { ?> 

     
       <tr>
            <td><?php echo $row['stock_name']; ?></td>
            <td><img src="<?= CUSTOM_BASE_URL.'uploads/product_multimage/'.$row['image'];?>" class="img-responsive" height=100 width=120 /></a>
        </tr>

    <?php } ?> 
       
</tbody>
</table>





