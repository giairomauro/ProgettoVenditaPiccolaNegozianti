

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
            </form>

