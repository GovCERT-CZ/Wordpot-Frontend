<?php
require_once('../config.php');
require_once(DIR_ROOT . '/include/rb.php');
require_once(DIR_ROOT . '/include/misc/xss_clean.php');

$ip = xss_clean($_POST['ip']);

if (!filter_var($ip, FILTER_VALIDATE_IP)) {
    echo "Error parsing IP address.";
    exit();
}

R::setup('pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

$db_query = "SELECT timestamp, source_ip, url, headers
FROM connections
WHERE source_ip='$ip'
ORDER BY timestamp ASC";

$rows = R::getAll($db_query);

if (count($rows)) {
    //We create a skeleton for the table
    echo '<table id="IP-attemps" class="tablesorter"><thead>';
    echo '<tr class="dark">';
    echo '<th colspan="4">Total connection attempts from ' . $ip . ': ' . count($rows) . ' </th>';
    echo '</tr>';
    echo '<tr class="dark">';
    echo '<th>Timestamp</th>';
    echo '<th>IP</th>';
    echo '<th>Url</th>';
    echo '<th>Headers</th>';
    echo '</tr></thead><tbody>';

    //For every row returned from the database we add a new point to the dataset,
    //and create a new table row with the data as columns
    foreach ($rows as $row) {
        echo '<tr class="light word-break">';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td>' . $row['source_ip'] . '</td>';
        echo '<td>' . $row['url'] . '</td>';
        echo '<td>' . xss_clean($row['headers']) . '</td>';
        echo '</tr>';
    }

    //Close tbody and table element, it's ready.
    echo '</tbody></table>';


    echo '<div id="pager2" class="pager">';
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
    echo '	      <option value="40">40</option>';
    echo '     </select>';
    echo '  </form>';
    echo '</div>';

    echo '<hr /><br />';
} else {
    echo '<p>No attempt records were found</p>';
}


$db_query = "SELECT timestamp, source_ip, probed_author
FROM author_probes
WHERE source_ip='$ip' AND probed_author <> ''
ORDER BY timestamp ASC";

$rows = R::getAll($db_query);

if (count($rows)) {
    //We create a skeleton for the table
    echo '<table id="IP-authors" class="tablesorter"><thead>';
    echo '<tr class="dark">';
    echo '<th colspan="2">Total author probes from ' . $ip . ': ' . count($rows) . ' </th>';
    echo '</tr>';
    echo '<tr class="dark">';
    echo '<th>Timestamp</th>';
    echo '<th>Probed author</th>';
    echo '</tr></thead><tbody>';

    //For every row returned from the database we add a new point to the dataset,
    //and create a new table row with the data as columns
    foreach ($rows as $row) {
        echo '<tr class="light word-break">';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td>' . xss_clean($row['probed_author']) . '</td>';
        echo '</tr>';
    }
    //Close tbody and table element, it's ready.
    echo '</tbody></table>';

    echo '<div id="pager3" class="pager">';
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
    echo '</div>';

    echo '<hr /><br />';
} else {
    echo '<p>No author probes were found</p>';
}

$db_query = "SELECT timestamp, source_ip, probed_filename
FROM file_probes
WHERE source_ip='$ip' AND probed_filename <> ''
ORDER BY timestamp ASC";

$rows = R::getAll($db_query);

if (count($rows)) {
    //We create a skeleton for the table
    echo '<table id="IP-filenames" class="tablesorter"><thead>';
    echo '<tr class="dark">';
    echo '<th colspan="2">Total filename probes from ' . $ip . ': ' . count($rows) . ' </th>';
    echo '</tr>';
    echo '<tr class="dark">';
    echo '<th>Timestamp</th>';
    echo '<th>Probed filename</th>';
    echo '</tr></thead><tbody>';

    //For every row returned from the database we add a new point to the dataset,
    //and create a new table row with the data as columns
    foreach ($rows as $row) {
        echo '<tr class="light word-break">';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td>' . xss_clean($row['probed_filename']) . '</td>';
        echo '</tr>';
    }
    //Close tbody and table element, it's ready.
    echo '</tbody></table>';

    echo '<div id="pager4" class="pager">';
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
    echo '</div>';

    echo '<hr /><br />';
} else {
    echo '<p>No filename probes were found</p>';
}


$db_query = "SELECT timestamp, source_ip, username, password
FROM login_attempts
WHERE source_ip='$ip'
ORDER BY timestamp ASC";

$rows = R::getAll($db_query);

if (count($rows)) {
    //We create a skeleton for the table
    echo '<table id="IP-logins" class="tablesorter"><thead>';
    echo '<tr class="dark">';
    echo '<th colspan="3">Total login attempts from ' . $ip . ': ' . count($rows) . ' </th>';
    echo '</tr>';
    echo '<tr class="dark">';
    echo '<th>Timestamp</th>';
    echo '<th>Username</th>';
    echo '<th>Password</th>';
    echo '</tr></thead><tbody>';

    //For every row returned from the database we add a new point to the dataset,
    //and create a new table row with the data as columns
    foreach ($rows as $row) {
        echo '<tr class="light word-break">';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td>' . xss_clean($row['username']) . '</td>';
        echo '<td>' . xss_clean($row['password']) . '</td>';
        echo '</tr>';
    }
    //Close tbody and table element, it's ready.
    echo '</tbody></table>';

    echo '<div id="pager5" class="pager">';
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
    echo '</div>';

    echo '<hr /><br />';
} else {
    echo '<p>No login attemps were found</p>';
}


$db_query = "SELECT timestamp, source_ip, probed_plugin
FROM plugins_probes
WHERE source_ip='$ip' AND probed_plugin <> ''
ORDER BY timestamp ASC";

$rows = R::getAll($db_query);

if (count($rows)) {
    //We create a skeleton for the table
    echo '<table id="IP-plugins" class="tablesorter"><thead>';
    echo '<tr class="dark">';
    echo '<th colspan="2">Total plugin probes from ' . $ip . ': ' . count($rows) . ' </th>';
    echo '</tr>';
    echo '<tr class="dark">';
    echo '<th>Timestamp</th>';
    echo '<th>Probed plugin</th>';
    echo '</tr></thead><tbody>';

    //For every row returned from the database we add a new point to the dataset,
    //and create a new table row with the data as columns
    foreach ($rows as $row) {
        echo '<tr class="light word-break">';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td>' . xss_clean($row['probed_plugin']) . '</td>';
        echo '</tr>';
    }
    //Close tbody and table element, it's ready.
    echo '</tbody></table>';

    echo '<div id="pager6" class="pager">';
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
    echo '</div>';

    echo '<hr /><br />';
} else {
    echo '<p>No plugin probes were found</p>';
}


$db_query = "SELECT timestamp, source_ip, probed_theme
FROM themes_probes
WHERE source_ip='$ip' AND probed_theme <> ''
ORDER BY timestamp ASC";

$rows = R::getAll($db_query);

if (count($rows)) {
    //We create a skeleton for the table
    echo '<table id="IP-themes" class="tablesorter"><thead>';
    echo '<tr class="dark">';
    echo '<th colspan="2">Total theme probes from ' . $ip . ': ' . count($rows) . ' </th>';
    echo '</tr>';
    echo '<tr class="dark">';
    echo '<th>Timestamp</th>';
    echo '<th>Probed theme</th>';
    echo '</tr></thead><tbody>';

    //For every row returned from the database we add a new point to the dataset,
    //and create a new table row with the data as columns
    foreach ($rows as $row) {
        echo '<tr class="light word-break">';
        echo '<td>' . $row['timestamp'] . '</td>';
        echo '<td>' . xss_clean($row['probed_theme']) . '</td>';
        echo '</tr>';
    }
    //Close tbody and table element, it's ready.
    echo '</tbody></table>';

    echo '<div id="pager7" class="pager">';
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
    echo '</div>';

    echo '<hr /><br />';
} else {
    echo '<p>No theme probes were found</p>';
}


R::close();

?>
