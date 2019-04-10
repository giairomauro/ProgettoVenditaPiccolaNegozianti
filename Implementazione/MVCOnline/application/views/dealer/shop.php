
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
                <!-- Logout Area -->
                <div class="cart-area">
                    <a href="<?php echo URL ?>logout/dealer" id="essenceCartBtn"><img src="<?php echo URL ?>application/views/_templates/shop/img/core-img/logout.svg" alt=""></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- The Modal to add products -->
    <div id="addModal" class="modal" style="z-index: 101;">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Il sito si prende il 10% del guadagno</p>
            <form action="<?php echo URL ?>dealer/insertProduct" method="POST" enctype="multipart/form-data">
                <!-- ##### Single Product Details Area Start ##### -->
                <section class="single_product_details_area d-flex align-items-center sBody">

                    <!-- Single Product Thumb -->
                    <div class="single_product_thumb clearfix">
                        <label for="file-input">
                            <img id="image" src="<?php echo URL ?>application/img/blankImg.png"/>
                        </label>
                        <input type="file" id="file-input" name="imageQuestion" onchange="setImage(this)" accept="image/*">
                    </div>

                    <!-- Single Product Description -->
                    <div class="single_product_desc clearfix">
                        <h5>Inserimento prodotto</h5>

                        <span>Categoria</span>
                        <select name="category" id="category" onchange="setCategory(this.id)" required>
                            <option disabled>Categoria</option>
                        </select><br><br><br><br>
                        <span>Negozio</span>
                        <select name="shop" id="shop" onchange="setShop(this.id)" required>
                            <option disabled>Negozio</option>
                        </select><br><br><br><br>
                        <input type="text" name="title" id="title" placeholder="Nome" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <input type="number" name="prize" id="prize" placeholder="Prezzo" min="0" onkeyup="convalidate(this.value, this.id, regNumbers)" required><br><br>
                        <input type="number" name="quantity" id="quantity" placeholder="Quantità" min="0" onkeyup="convalidate(this.value, this.id, regNumbers)" required>
                    </div>
                    <div class="formDiv">
                        <input type="submit" id="insertProduct" value="INSERISCI" disabled/>
                    </div>
                </section>
                <!-- ##### Single Product Details Area End ##### -->
            </form>
        </div>

    </div>

    <!-- The Modal to modify products -->
    <div id="modifyModal" class="modal" style="z-index: 101;">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Il sito si prende il 10% del guadagno</p>
            <form action="<?php echo URL ?>dealer/modifyProduct" method="POST" enctype="multipart/form-data">
                <!-- ##### Single Product Details Area Start ##### -->
                <section class="single_product_details_area d-flex align-items-center modSBody">

                    <!-- Single Product Thumb -->
                    <div class="single_product_thumb clearfix">
                        <label for="modfile-input">
                            <img id="modImage">
                        </label>
                        <input type="file" id="modfile-input" name="imageQuestion" onchange="setImage(this)" accept="image/*">
                    </div>

                    <!-- Single Product Description -->
                    <div class="single_product_desc clearfix">
                        <h5>Modifica prodotto</h5>

                        <span>Categoria</span>
                        <select name="category" id="modCategory" onchange="setCategory(this.id)" required>
                            <option disabled>Categoria</option>
                        </select><br><br><br><br>
                        <span>Negozio</span>
                        <select name="modShop" id="modShop" onchange="setShop(this.id)" required>
                            <option disabled>Negozio</option>
                        </select><br><br><br><br>
                        <span>Nome</span>
                        <input type="text" name="title" id="modTitle" placeholder="Nome" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Prezzo</span>
                        <input type="number" name="prize" id="modPrice" placeholder="Prezzo" min="0" onkeyup="convalidate(this.value, this.id, regNumbers)" required><br><br>
                        <span>Quantità</span>
                        <input type="number" name="quantity" id="modQuantity" placeholder="Quantità" min="0" onkeyup="convalidate(this.value, this.id, regNumbers)" required>
                    </div>
                    <input type="text" name="oldData" id="oldData" hidden>
                    <div class="formDiv">
                        <input type="submit" id="modifyProduct" value="MODIFICA" disabled/>
                    </div>
                </section>
                <!-- ##### Single Product Details Area End ##### -->
            </form>
        </div>

    </div>

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img">
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

                        <div class="row" id="prodContainer">

                        </div>
                    </div>

                    <!-- Aggiungi prodotto -->
                    <div id="switch">
                        <div class="bar" id="myBtn"></div>
                    </div>
                </div>
            </div>
        </div>
        <script>getCategories(true);</script>
    </section>
    <!-- ##### Shop Grid Area End ##### -->


    <script src="<?php echo URL ?>application/views/dealer/js/openModal.js"></script>