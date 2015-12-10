<?php
echo doctype("html5");
?>  
<html>
    <head> 
    
    <meta charset="UTF-8" />
    <link href="<?php echo base_url(); ?>css/default.css" type="text/css" rel="stylesheet" />
    <title>CI Tutorial <?php echo $title;?></title>
    
   
     </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <p><?= $welcome ?> if you are not, <a href="<?php base_url();?>logout">log out</a></div></p>
                
                <h1>CI Tutorial <?php echo $title;?></h1> 
                <?php
                print_r($this->session->all_userdata());
                
               
                ?>
                
                
                    
