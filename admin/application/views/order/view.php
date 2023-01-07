<?php foreach ($result as $row) { ?> 

    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">User : <?php echo $row['user_name']; ?></h4>
        </div>
        <tr>
            <td><b>Total payable Rate</b></td>
            <td><?php echo $row['total_amt']; ?></td>
        </tr>
         <tr>
            <td><b>Store</b></td>
            <td><?php echo $row['store']; ?></td>
        </tr>
        <tr>
            <td><b>Payment Type</b></td>
            <td>COD</td>
        </tr>
        <tr>
            <td> <b>Delivery name</b></td>
            <td><?php echo $row['name']; ?></td>
        </tr>
     
       

       
         <tr>
            <td><b>Address</b></td>
            <td><?php echo $row['address']; ?></td>
        </tr>
         <tr>
            <td><b>Landmark</b></td>
            <td><?php echo $row['land_mark']; ?></td>
        </tr>
        <tr>
            <td><b>Phone</b></td>
            <td><?php echo $row['phone']; ?></td>
        </tr>
         <tr>
            <td><b>Alternative Phone</b></td>
            <td><?php echo $row['alter_phone']; ?></td>
        </tr>
        
        <tr>
            <td ><b>Item</b></td>
            <td><b>Qty</b></td>
            <td><b>Image</b></td>
        </tr>
<?php foreach ($row['product'] as $stock) { ?>     

       <tr>
            
            <td><?php echo $stock['stock_name']; ?></td>
            <td><?php echo $stock['qty']; ?></td>
            <td><img src="<?= CUSTOM_BASE_URL.'uploads/product_multimage/'.$stock['image'];?>" class="img-responsive" height=50 width=50 /></a>
        </tr>


<?php } ?> 


    <?php } ?> 
       
</tbody>
</table>





