<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
    <title>Wordpot-Frontend | Fast Visualization for your Wordpot Honeypot Stats</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="imagetoolbar" content="no"/>
    <link rel="stylesheet" href="styles/layout.css" type="text/css"/>
    <script type="text/javascript" src="scripts/jquery-1.4.1.min.js"></script>
    <!-- FancyBox -->
    <script type="text/javascript" src="scripts/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="scripts/fancybox/jquery.fancybox-1.3.2.js"></script>
    <script type="text/javascript" src="scripts/fancybox/jquery.fancybox-1.3.2.setup.js"></script>
    <link rel="stylesheet" href="scripts/fancybox/jquery.fancybox-1.3.2.css" type="text/css"/>
    <!-- End FancyBox -->
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
            <li class="active"><a href="index.php">Homepage</a></li>
            <li><a href="wordpot-frontend.php">Wordpot-Frontend</a></li>
            <li><a href="wordpot-input.php">Wordpot-Input</a></li>
            <li><a href="wordpot-ip.php">Wordpot-Ip</a></li>
            <li><a href="wordpot-geo.php">Wordpot-Geo</a></li>
            <li class="active last"><a href="gallery.php">Graph Gallery</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
    <div class="container">
        <!-- ############################# -->
        <div id="gallery" class="whitebox">
            <h2>Provided you have visited all the other pages/components (for the graphs to be generated) you can see
                all the images in this single page with the help of fancybox</h2>
            <hr/>
            <br/>
            <ul>
                <li><a rel="gallery_group" href="generated-graphs/top10_paths.png"
                       title="Top 10 paths"><img src="generated-graphs/top10_paths.png" alt=""/></a>
                </li>
                <li><a rel="gallery_group" href="generated-graphs/top10_authors.png"
                       title="Top 10 probed authors"><img src="generated-graphs/top10_authors.png" alt=""/></a>
                </li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/top10_files.png"
                                    title="Top 10 probed filenames"><img
                            src="generated-graphs/top10_files.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/top10_combinations.png"
                       title="Top 10 username-password combinations"><img
                            src="generated-graphs/top10_combinations.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/top10_combinations_pie.png"
                       title="Top 10 username-password combinations"><img
                            src="generated-graphs/top10_combinations_pie.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/top10_plugins.png"
                                    title="Top 10 probed plugins"><img
                            src="generated-graphs/top10_plugins.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/top10_themes.png" title="Top 10 probed themes"><img
                            src="generated-graphs/top10_themes.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/most_author_probes_per_day.png"
                       title="Most author probes per day (Top 20)"><img src="generated-graphs/most_author_probes_per_day.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/author_probes_per_day.png"
                                    title="Author probes per day"><img
                            src="generated-graphs/author_probes_per_day.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/author_probes_per_week.png" title="Author probes per week"><img
                            src="generated-graphs/author_probes_per_week.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/most_file_probes_per_day.png"
                       title="Most filename probes per day (Top 20)"><img src="generated-graphs/most_file_probes_per_day.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/file_probes_per_day.png"
                                    title="Filename probes per day"><img
                            src="generated-graphs/file_probes_per_day.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/file_probes_per_week.png" title="Filename probes per week"><img
                            src="generated-graphs/file_probes_per_week.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/most_login_page_probes_per_day.png"
                       title="Most login page probes per day (Top 20)"><img src="generated-graphs/most_login_page_probes_per_day.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/login_page_probes_per_day.png"
                                    title="Login page probes per day"><img
                            src="generated-graphs/login_page_probes_per_day.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/login_page_probes_per_week.png" title="Login page probes per week"><img
                            src="generated-graphs/login_page_probes_per_week.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/most_plugin_probes_per_day.png"
                       title="Most plugin probes per day (Top 20)"><img src="generated-graphs/most_plugin_probes_per_day.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/plugin_probes_per_day.png"
                                    title="Plugin probes per day"><img
                            src="generated-graphs/plugin_probes_per_day.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/plugin_probes_per_week.png" title="Plugin probes per week"><img
                            src="generated-graphs/plugin_probes_per_week.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/most_theme_probes_per_day.png"
                       title="Most theme probes per day (Top 20)"><img src="generated-graphs/most_theme_probes_per_day.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/theme_probes_per_day.png"
                                    title="Theme probes per day"><img
                            src="generated-graphs/theme_probes_per_day.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/theme_probes_per_week.png" title="Theme probes per week"><img
                            src="generated-graphs/theme_probes_per_week.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/connections_per_ip.png"
                       title="Number of connections per unique IP (Top 10)"><img src="generated-graphs/connections_per_ip.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/connections_per_ip_pie.png"
                                    title="Number of connections per unique IP (Top 10)"><img
                            src="generated-graphs/connections_per_ip_pie.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/author_probes_from_same_ip.png"
                       title="Author probes from same IP"><img
                            src="generated-graphs/author_probes_from_same_ip.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/file_probes_from_same_ip.png"
                       title="Filename probes from same IP"><img
                            src="generated-graphs/file_probes_from_same_ip.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/login_page_probes_from_same_ip.png"
                                    title="Login page probes from same IP"><img
                            src="generated-graphs/login_page_probes_from_same_ip.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/plugin_probes_from_same_ip.png"
                       title="Plugin probes from same IP"><img
                            src="generated-graphs/plugin_probes_from_same_ip.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/theme_probes_from_same_ip.png"
                       title="Theme probes from same IP"><img
                            src="generated-graphs/theme_probes_from_same_ip.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/most_probes_per_day.png"
                                    title="Most probes per day (Top 20)"><img
                            src="generated-graphs/most_probes_per_day.png" alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/probes_per_day.png" title="Probes per day"><img
                            src="generated-graphs/probes_per_day.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/probes_per_week.png" title="Probes per week"><img
                            src="generated-graphs/probes_per_week.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/top10_overall_authors.png"
                                    title="Top 10 probed authors (overall)"><img src="generated-graphs/top10_overall_authors.png"
                                                                    alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/top10_overall_files.png" title="Top 10 probed filenames (overall)"><img
                            src="generated-graphs/top10_overall_files.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/top10_overall_login_attempts.png" title="Top 10 login attempts (overall)"><img
                            src="generated-graphs/top10_overall_login_attempts.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/top10_overall_plugins.png"
                                    title="Top 10 probed plugins (overall)"><img src="generated-graphs/top10_overall_plugins.png"
                                                                    alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/top10_overall_themes.png" title="Top 10 probed themes (overall)"><img
                            src="generated-graphs/top10_overall_themes.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/top10_headers.png" title="Top 10 headers"><img
                            src="generated-graphs/top10_headers.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/top10_urls.png"
                                    title="Top 10 urls"><img src="generated-graphs/top10_urls.png"
                                                                    alt=""/></a></li>

                <li><a rel="gallery_group" href="generated-graphs/connections_per_country_pie.png"
                       title="Number of connections per country"><img
                            src="generated-graphs/connections_per_country_pie.png" alt=""/></a></li>
                <li><a rel="gallery_group" href="generated-graphs/connections_per_ip_geo.png"
                       title="Number of connections per unique IP (Top 10) + Country Codes"><img
                            src="generated-graphs/connections_per_ip_geo.png" alt=""/></a></li>
                <li class="last"><a rel="gallery_group" href="generated-graphs/connections_per_ip_geo_pie.png"
                                    title="Number of connections per unique IP (Top 10) + Country Codes"><img
                            src="generated-graphs/connections_per_ip_geo_pie.png" alt=""/></a></li>

            </ul>
            <br class="clear"/>
        </div>
        <!-- ############################# -->
        <div class="clear"></div>
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
