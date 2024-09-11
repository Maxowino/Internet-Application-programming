<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- <h1>This is my first page</h1> -->
        <?php
        require_once "load.php";
        
        $Objmenus->main_menu();
        $Objlayout->heading();
        $Objheading->main_heading();
        $ObjCont->main_content();
        $ObjCont->side_bar();
        $Objlayout->footer();
       
        // print $Obj->user_age("Alex", 2004);

        ?>
</body>
</html>