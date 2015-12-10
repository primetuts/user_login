<?php
    $menu = array( 
        'id'=>'nav',
        'menus'=>array(
                'menu1'=>'Users',
                'menu2'=>'Sessions Log',
                'menu3'=>'Locked Users'
            )    
    );
    echo nav_menu($menu);


?>