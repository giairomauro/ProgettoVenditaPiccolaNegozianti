
        </div>
        <script  src="<?php echo URL ?>application/views/login_register/js/main.js"></script>
        <script  src="<?php echo URL ?>application/views/login_register/js/index.js"></script>

        <?php
            if(isset($_SESSION['wrongPass'])){
                print "<script type='text/javascript'>
                            linkClick();
                       </script>";

                unset($_SESSION['wrongPass']);
            }

        ?>
    </body>

</html>