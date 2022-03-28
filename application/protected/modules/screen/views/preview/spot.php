<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Safety Vision - <?php echo $spot['title']; ?></title>
        <style>
            *{margin: 0; padding: 0;}
            video{height:100%; border: none;}
        </style>
        <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
    <center>
        <video id="player" controls autobuffer poster="<?php echo $res['image']; ?>">
            <source src="<?php
            if (!empty($res)) {
                echo $res['video'];
            }
            ?>"  type="video/mp4"/>
            <p>Your browser does not support H.264/mp4/ogg.</p>
        </video>
    </center>
    <script>
        $(document).ready(function() {
            $('video').height($(window).height()-4);
        });
        $(window).resize(function() {
            $('video').height($(window).height()-4);
        });
    </script>   
</body>
</html>