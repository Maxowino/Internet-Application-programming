<?php
    class menus{
        public function main_menu(){
?>  
            <div class="topnav">
                <a href="./">Home</a>
                <a href="about.php">About</a>
                <a href="">Projects</a>
                <a href="">Contact</a>
                <?php $this->main_right_menu();?>
            </div>
            <?php
        }
        
        public function main_right_menu(){
            ?>
            <div class="topnav-right">
            <a href="signin.php">Sign up</a>
            <a href="login.php">Sign in</a>
        </div>
        <?php
    }
    }