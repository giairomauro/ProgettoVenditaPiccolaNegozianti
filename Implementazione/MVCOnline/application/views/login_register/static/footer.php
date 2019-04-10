
        </div>
        <script  src="<?php echo URL ?>application/views/login_register/js/main.js"></script>
        <script  src="<?php echo URL ?>application/views/login_register/js/index.js"></script>

        <?php
            //Controllo se c'è una variabile di errore creata
            //In caso positivo apro il popup dell'errore
            if(isset($_SESSION['wrongPass'])){
                print "<script type='text/javascript'>
                            linkClickWrongPass();
                       </script>";
                unset($_SESSION['wrongPass']);
            }else if(isset($_SESSION['noUser'])){
                print "<script type='text/javascript'>
                        linkClickNoUser();
                   </script>";
                unset($_SESSION['noUser']);
            }

        ?>
    </body>

</html>