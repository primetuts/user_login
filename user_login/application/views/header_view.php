<?php echo doctype("html5");?>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="900" />
        <script type="text/javascript" src="<?php echo base_url();?>js/alert.js"></script>
        <link href="<?php echo base_url();?>css/default.css" type="text/css" rel="stylesheet" />
        <title>CI Tutorial <?php echo $title;?></title>
        <style type="text/css">
            
            #register_div {
                width:300px; 
                padding:20px;
                margin: 20px auto;
                border:1px solid #999;
                border-radius:5px;
            }
            input {
                width:200px;
                size:50;
            }
        </style>
        <script type="text/javascript" charset="utf-8" src="http://localhost/ci_tutorials/js/jquery/jquery.js"></script>
        <script type="text/javascript" charset="utf-8">
            // <![CDATA[
            $(document).ready(function() {

                
            });
            // ]]>
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1>CI Tutorial <?php echo $title;?></h1>
                <?php
                //print_r($this -> session -> all_userdata());
                ?>
