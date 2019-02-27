

        <!-- ##### Right Side Cart Area ##### -->
        <div class="cart-bg-overlay"></div>

        <div class="right-side-cart-area">

            <!-- Cart Button -->
            <div class="cart-button">
                <a href="#" id="rightSideCart"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/bag.svg" alt=""> <span>1</span></a>
            </div>

            <div class="cart-content d-flex">
                <!-- Cart List Area -->
                <div class="cart-list" id="cart-list">
                    <!-- Single Cart Item -->
                    <div class="single-cart-item">
                        <a href="#" class="product-image">
                            <img src="<?php echo URL ?>application/views/_templates/shop/img/product-img/product-1.jpg" class="cart-thumb" alt="">
                            <!-- Cart Item Desc -->
                            <div class="cart-item-desc">
                              <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                                <span class="badge">Mango</span>
                                <h6>Button Through Strap Mini Dress</h6>
                                <p class="size">Size: S</p>
                                <p class="color">Color: Red</p>
                                <p class="price">$45.00</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="cart-amount-summary">

                    <h2>Summary</h2>
                    <ul class="summary-table">
                        <li><span>subtotal:</span> <span>$274.00</span></li>
                        <li><span>delivery:</span> <span>Free</span></li>
                        <li><span>discount:</span> <span>-15%</span></li>
                        <li><span>total:</span> <span>$232.00</span></li>
                    </ul>
                    <div class="checkout-btn mt-100">
                        <a href="checkout.html" class="btn essence-btn">check out</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ##### Right Side Cart End ##### -->

        <!-- ##### Breadcumb Area Start ##### -->
        <div class="breadcumb_area bg-img" style="background-image: url(<?php echo URL ?>application/views/_templates/shop/img/bg-img/breadcumb.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="page-title text-center">
                            <h2>dresses</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ##### Breadcumb Area End ##### -->

        <!-- ##### Shop Grid Area Start ##### -->
        <section class="shop_grid_area section-padding-80">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-3">
                        <div class="shop_sidebar_area">

                            <!-- ##### Single Widget ##### -->
                            <div class="widget catagory mb-50">
                                <!-- Widget Title -->
                                <h6 class="widget-title mb-30">Catagories</h6>

                                <!--  Catagories  -->
                                <div class="catagories-menu">
                                    <ul id="menu-content2" class="menu-content collapse show">

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="shop_grid_product_area">
                            <div class="row">
                                <div class="col-12">
                                    <div class="product-topbar d-flex align-items-center justify-content-between">
                                        <!-- Total Products -->
                                        <div class="total-products">
                                            <p>prodotti trovati</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Area -->
                            <div class="search-area">
                                <form>
                                    <input type="search" name="search" id="headerSearch" placeholder="Ricerca" onkeyup="searchProduct(this.value)">
                                    <button type="submit" id="buttonSearch" onclick=""><i class="fa fa-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                            <div class="row" id="prodContainer">

                            </div>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="navigation">
                            <ul class="pagination mt-50 mb-70">
                                <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">21</a></li>
                                <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <div class="cd-signin-modal js-signin-modal"> <!-- this is the entire modal form, including the background -->
            <div class="cd-signin-modal__container"> <!-- this is the container wrapper -->
                <ul class="cd-signin-modal__switcher js-signin-modal-switcher js-signin-modal-trigger">
                    <li><a href="#0" data-signin="login" data-type="login">Informazioni prodotto</a></li>
                </ul>

                <div class="cd-signin-modal__block js-signin-modal-block" data-type="login"> <!-- log in form -->
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
                </div>
                <a href="#0" class="cd-signin-modal__close js-close">Close</a>
            </div> <!-- cd-signin-modal__container -->
        </div> <!-- cd-signin-modal -->

        <script src="<?php echo URL ?>application/views/shop/js/main.js"></script> <!-- Resource JavaScript -->

        <!-- ##### Shop Grid Area End ##### -->
        <script>getCategories(true);
            disableForm();</script>
