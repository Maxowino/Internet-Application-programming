<?php
    class menus{
        public function main_menu(){
?>  
            <div class="topnav">
                <a href="HOME">Home</a>
                <a href="ABOUT">About</a>
                <a href="ABOUT">Projects</a>
                <a href="ABOUT">Contact</a>
                <?php $this->main_right_menu();?>
            </div>
            <?php
        }
        
        public function main_right_menu(){
            ?>
            <div class="topnav-right">
            <a href="">Sign up</a>
            <a href="">Sign in</a>
        </div>
        <?php
    }
    }