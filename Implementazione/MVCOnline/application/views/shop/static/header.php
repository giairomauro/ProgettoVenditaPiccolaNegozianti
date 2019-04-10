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
                    <a class="nav-brand" href="<?php echo URL ?>">Home</a>
                    <a class="nav-brand" href="<?php echo URL ?>home/shop">Shop</a>
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
                    </div>
                </nav>

                <!-- Header Meta Data -->
                <div class="header-meta d-flex clearfix justify-content-end">

                    <?php if(isset($_SESSION['customer'])): ?>
                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li><?php echo $_SESSION['customer']; ?>
                                </li>
                            </ul>
                        </div>

                        <!-- Cart Area -->
                        <div class="cart-area">
                            <a href="#" id="essenceCartBtn"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/bag.svg" alt=""> <span class="cartObjects"></span></a>
                        </div>

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

        <!-- ##### Right Side Cart Area ##### -->
        <div class="cart-bg-overlay"></div>

        <div class="right-side-cart-area">

            <!-- Cart Button -->
            <div class="cart-button">
                <a href="#" id="rightSideCart"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/bag.svg" alt=""> <span class="cartObjects"></span></a>
            </div>
            <form action="<?php echo URL ?>customer/doCheckout" method="POST" enctype="multipart/form-data" id="my_form">
                <div class="cart-content d-flex">

                    <!-- Cart List Area -->
                    <div class="cart-list" id="cart-list">

                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-amount-summary">

                        <h2>Sommario</h2>
                        <ul class="summary-table">
                            <li><span>Totale:</span> <span id="totPrice"></span></li>
                            <li><span>Quantità:</span> <span id="totQuantity"></span></li>
                        </ul>

                        <span>Luogo di ritiro</span><br><br>
                        <select name="pickupShop" id="pickupShop" onchange="setSelectPickupShop(this.id)" required>
                            <option disabled>Luogo di ritiro</option>
                        </select>
                        <div class="checkout-btn mt-100">
                            <a href="javascript:{}" onclick="document.getElementById('my_form').submit();" class="btn essence-btn" disabled>check out</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- ##### Right Side Cart End ##### -->