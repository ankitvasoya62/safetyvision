<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Safety Vision Gate - <?php echo $screen->name; ?></title>
        <link rel="stylesheet" type="text/css" href="/css/screen.css">
        <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <header>
            <img src="/images/safetyvision.png">
        </header>
        <section class="info">
            Information
        </section>
        <section class="title">Select AC Types</section>
        <section class="wrap">
            <?php
             if (!empty($spots)) {
                echo '<ul id="video">';
                foreach ($spots as $val) {
                    ?>
                    <li>
                        <video poster="<?php echo $val['image']; ?>" controls>
                            <source src="<?php echo $val['video']; ?>" type="video/mp4" />
                            Your browser does not support HTML5 video.
                        </video>
                        <p><?php echo $val['title']; ?></p>
                    </li>
                    <?php
                }
                echo '<section class="clear"></section>';
                echo '</ul>';
            } else {
                echo '<center style="padding:1em; font-weight:bold; color:#f00;">No items</center>';
            }
            ?>
        </section>
        
        <footer>
            © <?php echo date("Y", time()); ?> Online Informasjonssystemer AS - Alle Rettigheter Reservert
        </footer>
    </body>
</html>