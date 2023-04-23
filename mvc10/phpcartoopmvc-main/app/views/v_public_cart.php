<?php include("includes/public_header.php"); ?>

<div id="content">
   

    <ul class="alerts">
        <?php $this->get_alerts(); ?>
    </ul>

    <form action="" method="post">
        <ul class="cart">
         <?php $this->get_data('cart_rows'); ?> 

        </ul>

        <div class="buttons_row">
        <a class="button_alt" href="?empty">Empty Cart</a>
        <input type="submit" name="update" class="button_alt" value="Update Cart">
        </div>

    </form>



</div>

<?php include("includes/public_footer.php"); ?>