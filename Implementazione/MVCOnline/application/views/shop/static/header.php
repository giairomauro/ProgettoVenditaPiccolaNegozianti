        <script src="<?php echo URL ?>application/views/shop/js/script.js"></script>

        <link rel="stylesheet" href="<?php echo URL ?>application/views/shop/css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="<?php echo URL ?>application/views/shop/css/style.css"> <!-- Resource style -->
        <link rel="stylesheet" href="<?php echo URL ?>application/views/shop/css/demo.css"> <!-- Demo style -->

        <!-- ##### Header Area Start ##### -->
        <header class="header_area">
            <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
                <!-- Classy Menu -->
                <nav class="classy-navbar" id="essenceNav">
                    <!-- Logo -->
                    <a class="nav-brand" href="index.html">Vendita</a>
                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>
                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- close btn -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>
                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li><a href="<?php echo URL ?>home/shop">Shop</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>

                <!-- Header Meta Data -->
                <div class="header-meta d-flex clearfix justify-content-end">

                    <!-- Cart Area -->
                    <div class="cart-area">
                        <a href="#" id="essenceCartBtn"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/bag.svg" alt=""> <span>1</span></a>
                    </div>

                    <?php if(isset($_SESSION['customer'])): ?>
                        <!-- Logout Area -->
                        <div class="cart-area">
                            <a href="<?php echo URL ?>logout/customer" id="essenceCartBtn"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/logout.svg" alt=""></a>
                        </div>
                    <?php else: ?>
                        <!-- User Login Info -->
                        <div class="user-login-info">
                            <a href="<?php echo URL ?>login/loginPageC"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/user.svg" alt=""></a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </header>
        <!-- ##### Header Area End ##### -->