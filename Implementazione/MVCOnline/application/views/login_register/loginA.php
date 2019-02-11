            <!-- Popup per i dati errati -->
            <div class="cd-popup" role="alert">
                <div class="cd-popup-container">
                    <p>Email e/o Passwordd errati</p>
                    <ul class="cd-buttons" style="list-style-type: none;">
                        <li><a href="#0" class="ok-close">OK</a></li>
                    </ul>
                    <a href="#0" class="cd-popup-close img-replace">Close</a>
                </div> <!-- cd-popup-container -->
            </div> <!-- cd-popup -->

            <form id="login" action="<?php echo URL ?>login/loginA" method="POST">
                <div class="formHeader">
                    <h1>Login Amministratore</h1>
                </div>
                <div class="formDiv">
                    <input type="text" placeholder="email" name="email" required/>
                    <div class="inputImage fa fa-envelope"></div>
                </div>
                <div class="formDiv">
                    <input type="password" placeholder="Password" name="pass" required/>
                    <div class="inputImage fa fa-lock"></div>
                </div>
                <div class="formDiv">
                    <input type="submit" value="LOGIN"/>
                </div>
                <div class="formFooter">
                    <a class="forgot" href="#">Forgot Password</a>
                </div>
            </form>

