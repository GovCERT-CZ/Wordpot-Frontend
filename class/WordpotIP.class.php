<?php
require_once(DIR_ROOT . '/include/rb.php');
require_once(DIR_ROOT . '/include/maxmind/geoip2.phar');
require_once(DIR_ROOT . '/include/tor/tor.class.php');

class WordpotIP
{
    private $maxmind;
    private $tor;

    function __construct()
    {
        $this->maxmind = new \GeoIp2\Database\Reader(DIR_ROOT . '/include/maxmind/GeoLite2-City.mmdb');
        $this->tor = new Tor();

        //Let's connect to the database
        R::setup('pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    function __destruct()
    {
        R::close();
    }

    public function printOverallIpActivity()
    {
        $db_query = "SELECT m.*,
                     CASE WHEN a.a_c > 0 THEN true ELSE false END AS author_probe_exists,
                     CASE WHEN b.b_c > 0 THEN true ELSE false END AS file_probe_exists,
                     CASE WHEN c.c_c > 0 THEN true ELSE false END AS login_attempts_exists,
                     CASE WHEN d.d_c > 0 THEN true ELSE false END AS plugin_probes_exists,
                     CASE WHEN e.e_c > 0 THEN true ELSE false END AS themes_probes_exists
                     FROM (SELECT source_ip, MAX(date_trunc('second', timestamp)) AS lastseen FROM connections GROUP BY source_ip) m
                     LEFT JOIN (SELECT source_ip, count(*) AS a_c FROM author_probes GROUP BY source_ip) AS a ON m.source_ip = a.source_ip
                     LEFT JOIN (SELECT source_ip, count(*) AS b_c FROM file_probes GROUP BY source_ip) AS b ON m.source_ip = b.source_ip
                     LEFT JOIN (SELECT source_ip, count(*) AS c_c FROM login_attempts GROUP BY source_ip) AS c ON m.source_ip = c.source_ip
                     LEFT JOIN (SELECT source_ip, count(*) AS d_c FROM plugins_probes GROUP BY source_ip) AS d ON m.source_ip = d.source_ip
                     LEFT JOIN (SELECT source_ip, count(*) AS e_c FROM themes_probes GROUP BY source_ip) AS e ON m.source_ip = e.source_ip
                     ORDER BY m.source_ip ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            echo '<p>Click column heads to sort data, rows to display attack details.</p>';

            echo '<table id="Total-IPs"><thead><tr class="dark"><th>
                  Total identified IP addresses: ' . count($rows) . '</th></tr></thead></table>';

            //We create a skeleton for the table
            echo '<table id="Overall-IP-Activity" class="tablesorter"><thead>';
            echo '<tr class="dark">';
            echo '<th>IP address</th>';
            if (GEO_METHOD == 'LOCAL')
                echo '<th>Geolocation</th>';
            if (TOR_CHECK == 'YES')
                echo '<th>Tor exit node</th>';
            echo '<th>Author probes</th>';
            echo '<th>File probes</th>';
            echo '<th>Login attemps</th>';
            echo '<th>Plugin probes</th>';
            echo '<th>Theme probes</th>';
            echo '<th>Last seen</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                $timestamp = is_null($row['lastseen']) ? 'N/A' : $row['lastseen'];

                echo '<tr class="light word-break" onclick=\'getIPinfo("' . $row['source_ip'] . '")\'>';
                echo '<td>' . $row['source_ip'] . '</td>';

                if (GEO_METHOD == 'LOCAL') {
                    try {
                        $geodata = $this->maxmind->city($row['source_ip']);
                        $geolocation = $geodata->city->name ? $geodata->city->name . ', ' . $geodata->country->name : $geodata->country->name;

                    } catch (\GeoIp2\Exception\GeoIp2Exception $e) {
                        $geolocation = 'N/A';
                    }
                    echo '<td>' . $geolocation . '</td>';
                }

                if (TOR_CHECK == 'YES') {
                    $exitnode = $this->tor->isTorExitNode($row['source_ip']) ? 'Yes' : 'No';
                    echo '<td>' . $exitnode . '</td>';
                }

                $author_probe = $row['author_probe_exists']  ? 'true' : 'false';
                $file_probe = $row['file_probe_exists']  ? 'true' : 'false';
                $login_attempts = $row['login_attempts_exists']  ? 'true' : 'false';
                $plugin_probes = $row['plugin_probes_exists']  ? 'true' : 'false';
                $themes_probes = $row['themes_probes_exists']  ? 'true' : 'false';

                echo '<td>' . $author_probe . '</td>';
                echo '<td>' . $file_probe . '</td>';
                echo '<td>' . $login_attempts . '</td>';
                echo '<td>' . $plugin_probes . '</td>';
                echo '<td>' . $themes_probes . '</td>';

                echo '<td>' . $timestamp . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }

        echo '<div id="pager1" class="pager">';
        echo '  <form>';
        echo '     <img src="images/first.png" class="first"/>';
        echo '     <img src="images/prev.png" class="prev"/>';
        echo '     <span class="pagedisplay"></span>';
        echo '     <img src="images/next.png" class="next"/>';
        echo '     <img src="images/last.png" class="last"/>';
        echo '     <select class="pagesize">';
        echo '        <option selected="selected" value="10">10</option>';
        echo '        <option value="20">20</option>';
        echo '        <option value="30">30</option>';
        echo '        <option value="40">40</option>';
        echo '     </select>';
        echo '  </form>';
        echo '  <a id="allActivityLink" href="include/export.php?type=allActivity">CSV of all recent IP activity</a>';
        echo '</div>';

        echo '<br /><hr />';
        if (GEO_METHOD == 'LOCAL') {
            echo '<small><a href="http://www.maxmind.com">http://www.maxmind.com</a></small><br />';
        }
        else {
            //TODO
        }
    }
}

?>
