

        <!-- ##### Right Side Cart Area ##### -->
        <div class="cart-bg-overlay"></div>

        <div class="right-side-cart-area">

            <!-- Cart Button -->
            <div class="cart-button">
                <a href="#" id="rightSideCart"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/bag.svg" alt=""> <span>1</span></a>
            </div>

            <div class="cart-content d-flex">

                <!-- Cart List Area -->
                <div class="cart-list">
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

        <!-- ##### Welcome Area Start ##### -->
        <section class="welcome_area bg-img background-overlay" style="background-image: url(<?php echo URL ?>application/views/_templates/shop/img/bg-img/bg-1.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="hero-content">
                            <h6>Vendita piccoli negozi</h6>
                            <h2>Sempre nuovi prodotti</h2>
                            <a href="<?php echo URL ?>home/shop" class="btn essence-btn">Guarda prodotti</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Welcome Area End ##### -->

        <!-- ##### Top Catagory Area Start ##### -->
        <div class="top_catagory_area section-padding-80 clearfix">
            <div class="container">
                <div class="row justify-content-center" id="divContainer">
                    <!-- Single Catagory -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img">
                            <div class="catagory-content">
                                <a href="#">Clothing</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ##### Top Catagory Area End ##### -->

        <script>getCategoriesHome()</script>
