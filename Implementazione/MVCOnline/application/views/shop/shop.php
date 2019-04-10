

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

        <!-- The Modal to modify products -->
        <div id="detailsModal" class="modal" style="z-index: 101;">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <!-- ##### Single Product Details Area Start ##### -->
                <section class="single_product_details_area d-flex align-items-center SBody">

                    <!-- Single Product Thumb -->
                    <div class="single_product_thumb clearfix">
                        <label for="file-input">
                            <img id="image">
                        </label>
                    </div>

                    <!-- Single Product Description -->
                    <div class="single_product_desc clearfix">
                        <h5>Informazioni prodotto</h5>
                        <br><br>
                        <div class="widget-desc">
                            <ul id="detailsList">
                                <br><li id="category"></li><br>
                                <li id="title"></li><br>
                                <li id="price"></li><br>
                                <li id="quantity"></li><br>
                            </ul>
                        </div>
                    </div>
                </section>
                <!-- ##### Single Product Details Area End ##### -->
            </div>
        </div>

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
                    </div>
                </div>
            </div>
        </section>

        <script src="<?php echo URL ?>application/views/shop/js/main.js"></script> <!-- Resource JavaScript -->

        <!-- ##### Shop Grid Area End ##### -->
        <script>getCategories(true);
            disableForm();</script>
