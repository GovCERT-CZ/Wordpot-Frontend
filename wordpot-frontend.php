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
            <li class="active"><a href="wordpot-frontend.php">Wordpot-Frontend</a></li>
            <li><a href="wordpot-input.php">Wordpot-Input</a></li>
            <li><a href="wordpot-ip.php">Wordpot-Ip</a></li>
            <li><a href="wordpot-geo.php">Wordpot-Geo</a></li>
            <li class="last"><a href="gallery.php">Graph Gallery</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper">
<div class="container">
<div class="whitebox">
<!-- ############################# -->
<h2>Overall honeypot activity</h2>
<hr/>
<?php
# Author: standab4

require_once('config.php');
require_once(DIR_ROOT . '/class/WordpotFrontend.class.php');

$WordpotFrontend = new WordpotFrontend();

//if realtime and not a cronjob OR not realtime but is a cronjob OR not realtime but there are no images yet,
//then populate the generated-graphs folder
if (REALTIME_STATS == 'YES' && PHP_SAPI != 'cli' || (REALTIME_STATS == 'NO' && PHP_SAPI == 'cli') ||
    (REALTIME_STATS == 'NO' && !$WordpotFrontend->generatedWordpotFrontendChartsExist())
) {
    $WordpotFrontend->generateWordpotFrontendCharts();
}

//-----------------------------------------------------------------------------------------------------------------
//OVERALL HONEYPOT ACTIVITY
//-----------------------------------------------------------------------------------------------------------------
$WordpotFrontend->printOverallHoneypotActivity();

echo '<br /><br />';
?>
<h2>Graphical statistics generated from your Wordpot honeypot database<br/><!--For more, visit the other pages/components of this package-->
</h2>

<div class="portfolio">
    <div class="fl_left">
        <h2>Top 10 query paths</h2>

        <p>This vertical bar chart displays the top 10 path used in query.</p>

        <p><a href="include/export.php?type=Paths">CSV of all distinct paths</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/top10_paths.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Top 10 author probes</h2>

        <p>This vertical bar chart displays the top 10 author probes.</p>

        <p><a href="include/export.php?type=Authors">CSV of all distinct author probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/top10_authors.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Top 10 file probes</h2>

        <p>This vertical bar chart displays the top 10 file probes.</p>

        <p><a href="include/export.php?type=Filenames">CSV of all distinct filename probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/top10_files.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Top 10 user-pass combos</h2>

        <p>This vertical bar chart displays the top 10 username and password combinations that attackers try
            when attacking the system.</p>

        <p><a href="include/export.php?type=Combo">CSV of all distinct combinations</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/top10_combinations.png" alt=""/></div>
    <div class="fl_left">
        <p>This pie chart displays the top 10 username and password combinations that attackers try when
            attacking the system.</p>

    </div>
    <div class="fl_right"><img src="generated-graphs/top10_combinations_pie.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Top 10 plugin probes</h2>

        <p>This vertical bar chart displays the top 10 plugin probes.</p>

        <p><a href="include/export.php?type=Plugins">CSV of all distinct plugin probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/top10_plugins.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Top 10 theme probes</h2>

        <p>This vertical bar chart displays the top 10 theme probes.</p>

        <p><a href="include/export.php?type=Themes">CSV of all distinct theme probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/top10_themes.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Author probes per day/week</h2>

        <p>This vertical bar chart displays the most author probes per day (Top 20) for the
            particular honeypot system. The numbers indicate how many times author was probed
            by attackers.</p>

        <p><a href="include/export.php?type=WordpotAuthorsMost">CSV of all author probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/most_author_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the daily author probes on the honeypot system. Spikes indicate attacks
            over a weekly period.<br/><br/><strong>Warning:</strong> Dates with zero attacks are
            not displayed.</p>

        <p><a href="include/export.php?type=WordpotAuthorsDay">CSV of daily author probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/author_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the weekly author probes on the honeypot system. Curves indicate attacks
             over a weekly period.</p>

        <p><a href="include/export.php?type=WordpotAuthorsWeek">CSV of weekly author probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/author_probes_per_week.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>File probes per day/week</h2>

        <p>This vertical bar chart displays the most filename probes per day (Top 20) for the
            particular honeypot system. The numbers indicate how many times filename was probed
            by attackers.</p>

        <p><a href="include/export.php?type=WordpotFilenamesMost">CSV of all filename probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/most_file_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the daily filename probes on the honeypot system. Spikes indicate attacks
            over a weekly period.<br/><br/><strong>Warning:</strong> Dates with zero attacks are
            not displayed.</p>

        <p><a href="include/export.php?type=WordpotFilenamesDay">CSV of daily filename probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/file_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the weekly filename probes on the honeypot system. Curves indicate attacks
             over a weekly period.</p>

        <p><a href="include/export.php?type=WordpotFilenamesWeek">CSV of weekly filename probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/file_probes_per_week.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Login page probes per day/week</h2>

        <p>This vertical bar chart displays the most login page probes per day (Top 20) for the
            particular honeypot system. The numbers indicate how many times login page probes was probed
            by attackers.</p>

        <p><a href="include/export.php?type=WordpotLoginProbesMost">CSV of all login page probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/most_login_page_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the daily shellshock attacks on the honeypot system. Spikes indicate attacks
            over a weekly period.<br/><br/><strong>Warning:</strong> Dates with zero attacks are
            not displayed.</p>

        <p><a href="include/export.php?type=WordpotLoginProbesDay">CSV of daily login page probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/login_page_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the weekly shellshock attacks on the honeypot system. Curves indicate attacks
             over a weekly period.</p>

        <p><a href="include/export.php?type=WordpotLoginProbesWeek">CSV of weekly login page probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/login_page_probes_per_week.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Plugin probes per day/week</h2>

        <p>This vertical bar chart displays the most shellshock attacks per day (Top 20) for the
            particular honeypot system. The numbers indicate how many times shellshock command were used
            by attackers.</p>

        <p><a href="include/export.php?type=WordpotPluginsMost">CSV of all plugin probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/most_plugin_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the daily shellshock attacks on the honeypot system. Spikes indicate attacks
            over a weekly period.<br/><br/><strong>Warning:</strong> Dates with zero attacks are
            not displayed.</p>

        <p><a href="include/export.php?type=WordpotPluginsDay">CSV of daily plugin probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/plugin_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the weekly shellshock attacks on the honeypot system. Curves indicate attacks
             over a weekly period.</p>

        <p><a href="include/export.php?type=WordpotPluginsWeek">CSV of weekly plugin probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/plugin_probes_per_week.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Theme probes per day/week</h2>

        <p>This vertical bar chart displays the most shellshock attacks per day (Top 20) for the
            particular honeypot system. The numbers indicate how many times shellshock command were used
            by attackers.</p>

        <p><a href="include/export.php?type=WordpotThemesMost">CSV of all theme probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/most_theme_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the daily shellshock attacks on the honeypot system. Spikes indicate attacks
            over a weekly period.<br/><br/><strong>Warning:</strong> Dates with zero attacks are
            not displayed.</p>

        <p><a href="include/export.php?type=WordpotThemesDay">CSV of daily theme probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/theme_probes_per_day.png" alt=""/></div>
    <div class="clear"></div>
    <div class="fl_left">
        <p>This line chart displays the weekly shellshock attacks on the honeypot system. Curves indicate attacks
             over a weekly period.</p>

        <p><a href="include/export.php?type=WordpotThemesWeek">CSV of weekly theme probes</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/theme_probes_per_week.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Connections per IP</h2>

        <p>This vertical bar chart displays the top 10 unique IPs ordered by the number of overall
            connections to the system.</p>

        <p><a href="include/export.php?type=ConnIP">CSV of all connections per IP</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/connections_per_ip.png" alt=""/></div>
    <div class="fl_left">
        <p>This pie chart displays the top 10 unique IPs ordered by the number of overall connections to the
            system.</p>
    </div>
    <div class="fl_right"><img src="generated-graphs/connections_per_ip_pie.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Author probes from the same IP</h2>

        <p>This vertical bar chart displays the number of shellshock attacks from the same IP address (Top
            20). The numbers indicate how many times the particular source used shellshock attack.</p>

        <p><a href="include/export.php?type=AuthorsIP">CSV of all author probes from same IPs</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/author_probes_from_same_ip.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>File probes from the same IP</h2>

        <p>This vertical bar chart displays the number of shellshock attacks from the same IP address (Top
            20). The numbers indicate how many times the particular source used shellshock attack.</p>

        <p><a href="include/export.php?type=FilenamesIP">CSV of all filename probes from same IPs</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/file_probes_from_same_ip.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Login page probes from the same IP</h2>

        <p>This vertical bar chart displays the number of shellshock attacks from the same IP address (Top
            20). The numbers indicate how many times the particular source used shellshock attack.</p>

        <p><a href="include/export.php?type=LoginProbesIP">CSV of all login page probes from same IPs</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/login_page_probes_from_same_ip.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Plugin probes from the same IP</h2>

        <p>This vertical bar chart displays the number of shellshock attacks from the same IP address (Top
            20). The numbers indicate how many times the particular source used shellshock attack.</p>

        <p><a href="include/export.php?type=PluginsIP">CSV of all plugin probes from same IPs</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/plugin_probes_from_same_ip.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Theme probes from the same IP</h2>

        <p>This vertical bar chart displays the number of shellshock attacks from the same IP address (Top
            20). The numbers indicate how many times the particular source used shellshock attack.</p>

        <p><a href="include/export.php?type=ThemesIP">CSV of all theme probes from same IPs</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/theme_probes_from_same_ip.png" alt=""/></div>
    <div class="clear"></div>
</div>
<!-- ############################# -->
<div class="portfolio">
    <div class="fl_left">
        <h2>Probes per day/week</h2>

        <p>This horizontal bar chart displays the most probes per day (Top 20) against the honeypot
            system.</p>
    </div>
    <div class="fl_right"><img src="generated-graphs/most_probes_per_day.png" alt=""/></div>
    <div class="fl_left">
        <p>This line chart displays the daily activity on the honeypot system. Spikes indicate hacking
            attempts.<br/><br/><strong>Warning:</strong> Dates with zero probes are not displayed.</p>

        <p><a href="include/export.php?type=ProbesDay">CSV of all probes per day</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/probes_per_day.png" alt=""/></div>
    <div class="fl_left">
        <p>This line chart displays the weekly activity on the honeypot system. Curves indicate hacking
            attempts over a weekly period.</p>

        <p><a href="include/export.php?type=ProbesWeek">CSV of all probes per week</a>

        <p>
    </div>
    <div class="fl_right"><img src="generated-graphs/probes_per_week.png" alt=""/></div>
    <div class="clear"></div>
</div>
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
