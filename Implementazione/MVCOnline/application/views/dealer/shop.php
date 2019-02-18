
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.html"><h3>Progetto vendita - gestore</h3></a>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="#"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/heart.svg" alt=""></a>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
                    <a href="#"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/user.svg" alt=""></a>
                </div>
                <!-- Logout Area -->
                <div class="cart-area">
                    <a href="<?php echo URL ?>logout/dealer" id="essenceCartBtn"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/logout.svg" alt=""></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Prodotti</h2>
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
                            <h6 class="widget-title mb-30">Categories</h6>

                            <!--  Categories  -->
                            <div class="catagories-menu">
                                <ul id="menu-content2" class="menu-content collapse show">
                                    <!-- Single Item -->

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <a class="col-12 col-md-8 col-lg-9">
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

                        <div class="row" id="prodContainer">

                        </div>
                    </div>

                    <!-- Aggiungi prodotto -->
                    <div id="switch">
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
        </div>
        <script>getCategories(true);</script>
    </section>
    <!-- ##### Shop Grid Area End ##### -->