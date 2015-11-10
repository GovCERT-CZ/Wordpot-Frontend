<?php
require_once(DIR_ROOT . '/include/rb.php');
require_once(DIR_ROOT . '/include/libchart/classes/libchart.php');
require_once(DIR_ROOT . '/include/misc/xss_clean.php');

class WordpotInput
{

    function __construct()
    {
        //Let's connect to the database
        R::setup('pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    function __destruct()
    {
        R::close();
    }

    public function printOverallHoneypotActivity()
    {
        echo '<h3>Overall honeypot activity</h3>';

        //TOTAL NUMBER OF COMMANDS
        $db_query = "SELECT COUNT(*) as total, COUNT(DISTINCT probed_author) as uniq FROM author_probes WHERE probed_author <> ''";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a skeleton for the table
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th colspan="2">Author enumeration probes</th>';
            echo '</tr>';
            echo '<tr class="dark">';
            echo '<th>Total number of author enumerations</th>';
            echo '<th>Distinct number of enumerated authors</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                echo '<tr class="light word-break">';
                echo '<td>' . $row['total'] . '</td>';
                echo '<td>' . $row['uniq'] . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }

        //TOTAL 
        $db_query = "SELECT COUNT(*) as total, COUNT(DISTINCT probed_filename) as uniq FROM file_probes WHERE probed_filename <> ''";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a skeleton for the table
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th colspan="2">Filename probes</th>';
            echo '</tr>';
            echo '<tr class="dark">';
            echo '<th>Total number of filename probes</th>';
            echo '<th>Distinct number of probed filenames</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                echo '<tr class="light word-break">';
                echo '<td>' . $row['total'] . '</td>';
                echo '<td>' . $row['uniq'] . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }

        //TOTAL 
        $db_query = "SELECT COUNT(*) as total, COUNT(DISTINCT '' || username || '/' || password) as uniq FROM login_attempts WHERE username <> '' AND password <> ''";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a skeleton for the table
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th colspan="2">Login attemps</th>';
            echo '</tr>';
            echo '<tr class="dark">';
            echo '<th>Total number of login attemps</th>';
            echo '<th>Distinct number of login attemps (distinct combination of username and password)</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                echo '<tr class="light word-break">';
                echo '<td>' . $row['total'] . '</td>';
                echo '<td>' . $row['uniq'] . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }

        //TOTAL 
        $db_query = "SELECT COUNT(*) as total, COUNT(DISTINCT probed_plugin) as uniq FROM plugins_probes WHERE probed_plugin <> ''";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a skeleton for the table
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th colspan="2">Plugin probes</th>';
            echo '</tr>';
            echo '<tr class="dark">';
            echo '<th>Total number of plugin probes</th>';
            echo '<th>Distinct number of probed plugins</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                echo '<tr class="light word-break">';
                echo '<td>' . $row['total'] . '</td>';
                echo '<td>' . $row['uniq'] . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }

        //TOTAL 
        $db_query = "SELECT COUNT(*) as total, COUNT(DISTINCT probed_theme) as uniq FROM themes_probes WHERE probed_theme <> ''";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a skeleton for the table
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th colspan="2">Theme probes</th>';
            echo '</tr>';
            echo '<tr class="dark">';
            echo '<th>Total number of theme probes</th>';
            echo '<th>Distinct number of probed themes</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                echo '<tr class="light word-break">';
                echo '<td>' . $row['total'] . '</td>';
                echo '<td>' . $row['uniq'] . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }

        echo '<hr /><br />';
    }



    public function printTop10OverallProbedAuthors()
    {
        $db_query = "SELECT probed_author, COUNT(probed_author) AS count
          FROM author_probes
          WHERE probed_author <> ''
          GROUP BY probed_author
          ORDER BY COUNT(probed_author) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 probed authors (overall)</h3>';
            echo '<p>The following table displays the top 10 authors (overall) probed by attackers.</p>';
            echo '<p><a href="include/export.php?type=ProbedAuthors">CSV of all probed authors</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Command</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';


            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_author'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . xss_clean($row['probed_author']) . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';


            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_AUTHOR_PROBES_OVERALL);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 90, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_overall_authors.png");
            echo '<p>This vertical bar chart visualizes the top 10 authors (overall) probed by attackers.</p>';
            echo '<img src="generated-graphs/top10_overall_authors.png">';
            echo '<hr /><br />';
        }
    }


    public function printTop10OverallProbedFiles()
    {
        $db_query = "SELECT probed_filename, COUNT(probed_filename) AS count
          FROM file_probes
          WHERE probed_filename <> ''
          GROUP BY probed_filename
          ORDER BY COUNT(probed_filename) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 probed files (overall)</h3>';
            echo '<p>The following table displays the top 10 filenames (overall) probed by attackers.</p>';
            echo '<p><a href="include/export.php?type=ProbedFilenames">CSV of all probed files</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Filename</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';


            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_filename'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . xss_clean($row['probed_filename']) . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';


            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_FILE_PROBES_OVERALL);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 90, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_overall_files.png");
            echo '<p>This vertical bar chart visualizes the top 10 files (overall) probed by attackers.</p>';
            echo '<img src="generated-graphs/top10_overall_files.png">';
            echo '<hr /><br />';
        }
    }

    public function printTop10OverallLoginAttempts()
    {
        $db_query = "SELECT username, password, COUNT('' || username || '/' || password) AS count
          FROM login_attempts
          WHERE username <> '' AND password <> ''
          GROUP BY username, password
          ORDER BY COUNT('' || username || '/' || password) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 login attempts (overall)</h3>';
            echo '<p>The following table displays the top 10 login attempts (overall).</p>';
            echo '<p><a href="include/export.php?type=LoginAttempts">CSV of all login attempts</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Username</th>';
            echo '<th>Password</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';


            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['username'] . '/' . $row['password'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['password'] . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';


            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_LOGIN_ATTEMPTS_OVERALL);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 90, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_overall_login_attempts.png");
            echo '<p>This vertical bar chart visualizes the top 10 login attempts (overall).</p>';
            echo '<img src="generated-graphs/top10_overall_login_attempts.png">';
            echo '<hr /><br />';
        }
    }


    public function printTop10OverallProbedPlugins()
    {
        $db_query = "SELECT probed_plugin, COUNT(probed_plugin) AS count
          FROM plugins_probes
          WHERE probed_plugin <> ''
          GROUP BY probed_plugin
          ORDER BY COUNT(probed_plugin) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 probed plugins (overall)</h3>';
            echo '<p>The following table displays the top 10 plugins (overall) probed by attackers.</p>';
            echo '<p><a href="include/export.php?type=ProbedPlugins">CSV of all probed plugins</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Plugin</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';


            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_plugin'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . xss_clean($row['probed_plugin']) . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';


            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_PLUGIN_PROBES_OVERALL);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 90, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_overall_plugins.png");
            echo '<p>This vertical bar chart visualizes the top 10 plugins (overall) probed by attackers.</p>';
            echo '<img src="generated-graphs/top10_overall_plugins.png">';
            echo '<hr /><br />';
        }
    }


    public function printTop10OverallProbedThemes()
    {
        $db_query = "SELECT probed_theme, COUNT(probed_theme) AS count
          FROM themes_probes
          WHERE probed_theme <> ''
          GROUP BY probed_theme
          ORDER BY COUNT(probed_theme) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 probed themes (overall)</h3>';
            echo '<p>The following table displays the top 10 themes (overall) probed by attackers.</p>';
            echo '<p><a href="include/export.php?type=ProbedThemes">CSV of all probed themes</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Theme</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';


            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_theme'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . xss_clean($row['probed_theme']) . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';


            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_THEME_PROBES_OVERALL);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 90, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_overall_themes.png");
            echo '<p>This vertical bar chart visualizes the top 10 themes (overall) probed by attackers.</p>';
            echo '<img src="generated-graphs/top10_overall_themes.png">';
            echo '<hr /><br />';
        }
    }


    public function printTop10Headers()
    {
        $db_query = "SELECT headers, COUNT(headers) AS count
          FROM connections
          WHERE headers <> ''
          GROUP BY headers
          ORDER BY COUNT(headers) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 Headers</h3>';
            echo '<p>The following table displays the top 10 haders sended by attackers as part of request.</p>';
            echo '<p><a href="include/export.php?type=Headers">CSV of all headers</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Headers</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach($rows as $row) {
                $dataSet->addPoint(new Point($row['headers'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . xss_clean($row['headers']) . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_HEADERS);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 90, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_headers.png");
            echo '<p>This vertical bar chart visualizes the top 10 haders sended by attackers as part of request.</p>';
            echo '<img src="generated-graphs/top10_headers.png">';
            echo '<hr /><br />';
        }
    }

    public function printTop10Urls()
    {
        $db_query = "SELECT url, COUNT(url) AS count
          FROM connections
          WHERE url <> ''
          GROUP BY url
          ORDER BY COUNT(url) DESC
          LIMIT 10";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //We create a skeleton for the table
            $counter = 1;
            echo '<h3>Top 10 urls</h3>';
            echo '<p>The following table displays the top 10 urls used by attackers.</p>';
            echo '<p><a href="include/export.php?type=Urls">CSV of all urls</a><p>';
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th>ID</th>';
            echo '<th>Url</th>';
            echo '<th>Count</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach($rows as $row) {
                $dataSet->addPoint(new Point($row['url'], $row['count']));

                echo '<tr class="light word-break">';
                echo '<td>' . $counter . '</td>';
                echo '<td>' . xss_clean($row['url']) . '</td>';
                echo '<td>' . $row['count'] . '</td>';
                echo '</tr>';
                $counter++;
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_URLS);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 40, 120, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_urls.png");
            echo '<p>This vertical bar chart visualizes the top 10 urls used by attackers.</p>';
            echo '<img src="generated-graphs/top10_urls.png">';
            echo '<hr /><br />';
        }
    }
}

?>
