<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
    <title>Wordpot-Frontend | Fast Visualization for your Wordpot Honeypot Stats</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="imagetoolbar" content="no"/>
    <link rel="stylesheet" href="styles/layout.css" type="text/css"/>
    <script type="text/javascript" src="scripts/jquery-1.4.1.min.js"></script>
</head>
<body id="top">
<div class="wrapper">
    <div id="header">
        <h1><a href="index.php">Wordpot-Frontend</a></h1>
        <br/>

        <p>Fast Visualization for your Wordpot Honeypot Stats</p>
    </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
    <div id="topbar">
        <div class="fl_left">Version: 1.0 | Website:  <a href="https://github.com/GovCERT-CZ/Wordpot-Frontend">github.com/GovCERT-CZ/Wordpot-Frontend</a>
        </div>
        <br class="clear"/>
    </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
    <div id="topnav">
        <ul class="nav">
            <li><a href="index.php">Homepage</a></li>
            <li><a href="wordpot-frontend.php">Wordpot-Frontend</a></li>
            <li><a href="wordpot-input.php">Wordpot-Input</a></li>
            <li><a href="wordpot-ip.php">Wordpot-Ip</a></li>
            <li class="active"><a href="wordpot-geo.php">Wordpot-Geo</a></li>
            <li class="last"><a href="gallery.php">Graph Gallery</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
    <div class="container">
        <div class="whitebox">
            <!-- ####################################################################################################### -->
            <h2>Geolocation information gathered from the top 10 IP addresses probing the system</h2>
            <hr/>

            <?php
            # Author: ikoniaris
            # Modifications: standa4

            require_once('config.php');
            require_once(DIR_ROOT . '/class/WordpotGeo.class.php');

            $WordpotGeo = new WordpotGeo();

            //-----------------------------------------------------------------------------------------------------------------
            //KIPPO-GEO DATA
            //-----------------------------------------------------------------------------------------------------------------
            $WordpotGeo->printWordpotGeoData();
            //-----------------------------------------------------------------------------------------------------------------
            //END
            //-----------------------------------------------------------------------------------------------------------------

            ?>
            <!-- ####################################################################################################### -->
            <div class="clear"></div>
        </div>
    </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
    <div id="copyright">
        <p class="fl_left">Copyright &copy; 2015 - All Rights Reserved - <a
                href="https://github.com/GovCERT-CZ/Wordpot-Frontend">Wordpot-Frontend</a></p>

        <p class="fl_right">Thanks to <a href="http://bruteforce.gr/kippo-graph" title="Kippo-Graph">Kippo-Graphs</a> and <a href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
        <br class="clear"/>
    </div>
</div>
<script type="text/javascript" src="scripts/superfish.js"></script>
<script type="text/javascript">
    jQuery(function () {
        jQuery('ul.nav').superfish();
    });
</script>
</body>
</html>
