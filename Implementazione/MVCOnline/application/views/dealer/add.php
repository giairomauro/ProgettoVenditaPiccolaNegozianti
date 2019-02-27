        <!-- Popup per i dati errati -->
        <div class="cd-popup" role="alert">
            <div class="cd-popup-container">
                <p>Prodotto già esistente</p>
                <ul class="cd-buttons" style="list-style-type: none;">
                    <li><a href="#0" class="ok-close">OK</a></li>
                </ul>
                <a href="#0" class="cd-popup-close img-replace">Close</a>
            </div> <!-- cd-popup-container -->
        </div> <!-- cd-popup -->

        <form action="<?php echo URL ?>dealer/insertProduct" method="POST" enctype="multipart/form-data">
            <!-- ##### Single Product Details Area Start ##### -->
            <section class="single_product_details_area d-flex align-items-center sBody">

                <!-- Single Product Thumb -->
                <div class="single_product_thumb clearfix">
                    <label for="file-input">
                        <img id="image" src="<?php echo URL ?>application/img/blankImg.png"/>
                    </label>
                    <input type="file" id="file-input" name="imageQuestion" onchange="setImage(this)" accept="image/*" required>
                </div>

                <!-- Single Product Description -->
                <div class="single_product_desc clearfix">
                    <h5>Categoria</h5>

                    <select name="category" id="category" onchange="setCategory(this.id)" required>
                        <option disabled selected>Categoria</option>
                    </select><br><br><br><br>
                    <input type="text" name="title" id="title" placeholder="Nome" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                    <input type="number" name="prize" id="prize" placeholder="Prezzo" min="0" onkeyup="convalidate(this.value, this.id, regNumbers)" required><br><br>
                    <input type="number" name="quantity" id="quantity" placeholder="Quantità" min="0" onkeyup="convalidate(this.value, this.id, regNumbers)" required>
                </div>
                <div class="formDiv">
                    <input type="submit" id="insertProduct" value="INSERISCI" disabled/>
                </div>

                <select name="shop" id="shop" onchange="setShop(this.id)" required>
                    <option disabled selected>Negozio</option>
                </select>
            </section>
            <!-- ##### Single Product Details Area End ##### -->
        </form>

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

        <script  src="http://samtinfo.ch/gestionevendita2018/application/views/login_register/js/main.js"></script>

        <script>getCategories(false);</script>

        <?php
        if(isset($_SESSION['ExistData'])){
            echo "<h1 style='color:red;'>PRODOTTO GIÀ ESISTENTE</h1>";

            unset($_SESSION['ExistData']);
        }else if(isset($_SESSION['created'])){
            header("location: ". URL ."dealer/home");

            unset($_SESSION['created']);
        }

        ?>
    </body>

</html>