
    <!-- ##### Single Product Details Area Start ##### -->
    <section class="single_product_details_area d-flex align-items-center sBody">

        <!-- Single Product Thumb -->
        <div class="single_product_thumb clearfix">
            <label for="file-input">
                <img src="<?php echo URL ?>application/img/blankImg.png"/>
            </label>
            <input type="file" id="file-input" name="imageQuestion" accept="image/*" id="imageQuestion" required>
        </div>

        <!-- Single Product Description -->
        <div class="single_product_desc clearfix">
            <select name="category">
                <option>Categoria</option>
            </select><br><br><br><br>
            <input type="text" name="title" placeholder="Nome"><br><br>
            <input type="number" name="prize" placeholder="Prezzo"><br><br>
            <input type="number" name="quantity" placeholder="Quantità">
        </div>
        <div class="formDiv">
            <input type="submit" value="INSERISCI"/>
        </div>
    </section>
    <!-- ##### Single Product Details Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="<?php echo URL ?>application/views/_templates/shop/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="<?php echo URL ?>application/views/_templates/shop/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="<?php echo URL ?>application/views/_templates/shop/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="<?php echo URL ?>application/views/_templates/shop/js/plugins.js"></script>
    <!-- Classy Nav js -->
    <script src="<?php echo URL ?>application/views/_templates/shop/js/classy-nav.min.js"></script>
    <!-- Active js -->
    <script src="<?php echo URL ?>application/views/_templates/shop/js/active.js"></script>

</body>

</html>