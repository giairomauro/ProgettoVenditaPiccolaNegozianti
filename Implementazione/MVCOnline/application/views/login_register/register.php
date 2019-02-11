
                <div class="formHeader">
                    <h1>Register</h1>
                </div>
                <div class="formDiv">
                    <input type="text" placeholder="name" id="name" name="name" onkeyup="convalidate(this.value, this.id, regLetters)" required/>
                    <div class="inputImage fa fa-user"></div>
                </div>
                <div class="formDiv">
                    <input type="text" placeholder="surname" id="surname" name="surname" onkeyup="convalidate(this.value, this.id, regLetters)" required/>
                    <div class="inputImage fa fa-user"></div>
                </div>
                <div class="formDiv">
                    <input type="email" placeholder="Email" id="emailR" name="emailR" onkeyup="convalidate(this.value, this.id, regMail)" required/>
                    <div class="inputImage fa fa-envelope"></div>
                </div>
                <div class="formDiv">
                    <input type="text" placeholder="phone" id="phone" name="phone" onkeyup="convalidate(this.value, this.id, regPhone)" required/>
                    <div class="inputImage fa fa-phone"></div>
                </div>
                <div class="formDiv">
                    <input type="password" placeholder="Password" id="password" name="password" onkeyup="checkPassword(this.value)" required/>
                    <div class="inputImage fa fa-lock"></div>
                </div>
                <div class="formDiv">
                    <input type="password" placeholder="Conferma password" id="confirm-password" name="password" onkeyup="confirm()"  disabled required/>
                    <div class="inputImage fa fa-lock"></div>
                </div>

                <!-- Messaggio password invalida -->
                <p id="invalid-pass" style="color: red;" hidden>Password non valida<br> (8-25 caratteri, sia lettere che numeri)</p>
                <p id="mailExists" style="color: red" hidden>ERRORE: mail già in uso</p>
                <p id="noPassMatch" style="color: red" hidden>ERRORE: password diverse</p>
                <p id="invalidInput" style="color: red" hidden>ERRORE: 1 o più dati inseriti errati o mancanti</p>
                <p id="invalidInput">TUTTI I CAMPI SONO OBBLIGATORI</p>
                <div class="formDiv">
                    <input type="submit" value="REGISTER" id="register-submit" disabled/>
                </div>
            </form>
