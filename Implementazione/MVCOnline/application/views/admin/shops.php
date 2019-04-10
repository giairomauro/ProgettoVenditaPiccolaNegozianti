

    <!-- The Modal to add shops -->
    <div id="addModal" class="modal" style="z-index: 101;">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h5>Inserimento negozio</h5>
            <form action="<?php echo URL ?>admin/registerShopDealer" method="POST" enctype="multipart/form-data">
                <!-- ##### Single Shop Details Area Start ##### -->
                <section class="single_product_details_area d-flex align-items-center sBody">

                    <!-- Single Shop Description -->
                    <div class="single_product_desc clearfix">
                        <h6>Negozio</h6>
                        <span>Nome</span>
                        <input type="text" placeholder="Nome" id="shopName" name="shopName" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Indirizzo</span>
                        <input type="text" placeholder="Indirizzo" id="shopAddress" name="shopAddress" onkeyup="convalidate(this.value, this.id, regVia)" required><br><br>
                        <span>Città</span>
                        <input type="text" placeholder="Città" id="shopCity" name="shopCity" onkeyup="convalidate(this.value, this.id, regLetters)" required>
                        <span>Telefono</span>
                        <input type="text" placeholder="Telefono" id="shopPhone" name="shopPhone" onkeyup="convalidate(this.value, this.id, regPhone)" required>
                    </div>

                    <!-- Single Shop Description -->
                    <div class="single_product_desc clearfix">
                        <h6>Venditore</h6>
                        <span>Nome</span>
                        <input type="text" placeholder="Nome" id="name" name="name" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Cognome</span>
                        <input type="text" placeholder="Cognome" id="surname" name="surname" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Telefono</span>
                        <input type="text" placeholder="Telefono" id="phone" name="phone" onkeyup="convalidate(this.value, this.id, regPhone)" required><br><br>
                        <span>Email</span>
                        <input type="text" placeholder="Email venditore" id="mail" name="mail" onkeyup="convalidate(this.value, this.id, regMail)" required><br><br>
                        <span>Password</span>
                        <input type="password" placeholder="Password" id="password" name="password" onkeyup="checkPassword(this.value)" required/>
                        <span>Conferma password</span>
                        <input type="password" placeholder="Conferma password" id="confirm-password" name="password" onkeyup="confirm()"  disabled required/>
                    </div>

                    <!-- Messaggio password invalida -->
                    <div class="single_product_desc clearfix">
                        <p id="invalid-pass" style="color: red;" hidden>Password non valida <br>(8-25 caratteri, sia lettere che numeri)</p>
                        <p id="mailExists" style="color: red;" hidden>ERRORE: mail già in uso</p>
                        <p id="noPassMatch" style="color: red;" hidden>ERRORE: password diverse</p>
                        <p id="invalidInput" style="color: red;" hidden>ERRORE: 1 o più dati inseriti errati o mancanti</p>
                        <p id="invalidInput">TUTTI I CAMPI SONO OBBLIGATORI</p>
                    </div>

                    <div class="formDiv">
                        <input type="submit" id="register-submit" value="INSERISCI" disabled/>
                    </div>
                </section>
                <!-- ##### Single Shop Details Area End ##### -->
            </form>
        </div>

    </div>

    <!-- The Modal to modify shops -->
    <div id="modifyModal" class="modal" style="z-index: 101;">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="<?php echo URL ?>admin/modifyShop" method="POST" enctype="multipart/form-data">
                <!-- ##### Single Shop Details Area Start ##### -->
                <section class="single_product_details_area d-flex align-items-center modSBody" id="modSBody">

                    <!-- Single Shop Description -->
                    <div class="single_product_desc clearfix">
                        <h6>Negozio</h6>
                        <span>Nome</span>
                        <input type="text" placeholder="Nome" id="modShopName" name="modShopName" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Indirizzo</span>
                        <input type="text" placeholder="Indirizzo" id="modShopAddress" name="modShopAddress" onkeyup="convalidate(this.value, this.id, regVia)" required><br><br>
                        <span>Città</span>
                        <input type="text" placeholder="Città" id="modShopCity" name="modShopCity" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Telefono</span>
                        <input type="text" placeholder="Telefono" id="modShopPhone" name="modShopPhone" onkeyup="convalidate(this.value, this.id, regPhone)" required>
                    </div>

                    <!-- Single Shop Description -->
                    <div class="single_product_desc clearfix">
                        <h6>Venditore</h6>
                        <span>Nome</span>
                        <input type="text" placeholder="Nome" id="modName" name="modName" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Cognome</span>
                        <input type="text" placeholder="Cognome" id="modSurname" name="modSurname" onkeyup="convalidate(this.value, this.id, regLetters)" required><br><br>
                        <span>Telefono</span>
                        <input type="text" placeholder="Telefono" id="modPhone" name="modPhone" onkeyup="convalidate(this.value, this.id, regPhone)" required><br><br>
                        <span>Email</span>
                        <input type="text" placeholder="Email venditore" id="modMail" name="modMail" onkeyup="convalidate(this.value, this.id, regMail)" required>
                    </div>

                    <!-- Messaggio password invalida -->
                    <div class="single_product_desc clearfix">
                        <p id="invalid-pass" style="color: red;" hidden>Password non valida <br>(8-25 caratteri, sia lettere che numeri)</p>
                        <p id="mailExists" style="color: red;" hidden>ERRORE: mail già in uso</p>
                        <p id="noPassMatch" style="color: red;" hidden>ERRORE: password diverse</p>
                        <p id="invalidInput" style="color: red;" hidden>ERRORE: 1 o più dati inseriti errati o mancanti</p>
                        <p id="invalidInput">TUTTI I CAMPI SONO OBBLIGATORI</p>
                    </div>

                    <!-- Dati della vecchia chiave -->
                    <input type="text" style="display: none;" id="oldMail" name="oldMail">
                    <input type="text" style="display: none;" id="oldShopName" name="oldShopName">
                    <input type="text" style="display: none;" id="oldShopAddress" name="oldShopAddress">
                    <input type="text" style="display: none;" id="oldShopCity" name="oldShopCity">
                    <div class="formDiv">
                        <input type="submit" id="modifyShop" value="MODIFICA" disabled/>
                    </div>
                </section>
                <!-- ##### Single Shop Details Area End ##### -->
            </form>
        </div>

    </div>

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Negozio</h2>
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

                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop_grid_product_area">
                        <div class="row">
                            <div class="col-12">
                                <div class="product-topbar d-flex align-items-center justify-content-between">
                                    <!-- Total Products -->
                                    <div class="total-products">
                                        <p>negozi trovati</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="shopContainer">

                        </div>
                    </div>

                    <!-- Aggiungi prodotto -->
                    <div id="switch">
                        <div class="bar" id="myBtn"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Shop Grid Area End ##### -->
    <script>getData()</script>
