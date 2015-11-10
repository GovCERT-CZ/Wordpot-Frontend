<?php
require_once(DIR_ROOT . '/include/rb.php');
require_once(DIR_ROOT . '/include/libchart/classes/libchart.php');

class WordpotFrontend
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

    // "meta" function to generate all charts
    // this way wordpot-graph.php can also be cron'd
    public function generateWordpotFrontendCharts()
    {
        $this->createTop10paths();
        $this->createTop10author_probes();
        $this->createTop10file_probes();
        $this->createTop10Combinations();
        $this->createTop10plugin_probes();
        $this->createTop10theme_probes();
        $this->createMostAuthorProbesPerDay();
        $this->createAuthorProbesPerDay();
        $this->createAuthorProbesPerWeek();
        $this->createMostFileProbesPerDay();
        $this->createFileProbesPerDay();
        $this->createFileProbesPerWeek();
        $this->createMostLoginPageProbesPerDay();
        $this->createLoginPageProbesPerDay();
        $this->createLoginPageProbesPerWeek();
        $this->createMostPluginProbesPerDay();
        $this->createPluginProbesPerDay();
        $this->createPluginProbesPerWeek();
        $this->createMostThemeProbesPerDay();
        $this->createThemeProbesPerDay();
        $this->createThemeProbesPerWeek();
        $this->createNumberOfConnectionsPerIP();
        $this->createAuthorProbesFromSameIP();
        $this->createFileProbesFromSameIP();
        $this->createLoginPageProbesFromSameIP();
        $this->createPluginProbesFromSameIP();
        $this->createThemeProbesFromSameIP();
        $this->createMostProbesPerDay();
        $this->createProbesPerDay();
        $this->createProbesPerWeek();
    }

    public function generatedWordpotFrontendChartsExist()
    {
        $generated_graphs_path = DIR_ROOT . '/generated-graphs/';
        $generated_graphs_names_array = [
            'top10_paths.png',
            'top10_authors.png',
            'top10_files.png',
            'top10_combinations.png',
            'top10_combinations_pie.png',
            'top10_plugins.png',
            'top10_themes.png',
            'most_author_probes_per_day.png',
            'author_probes_per_day.png',
            'author_probes_per_week.png',
            'most_file_probes_per_day.png',
            'file_probes_per_day.png',
            'file_probes_per_week.png',
            'most_login_page_probes_per_day.png',
            'login_page_probes_per_day.png',
            'login_page_probes_per_week.png',
            'most_plugin_probes_per_day.png',
            'plugin_probes_per_day.png',
            'plugin_probes_per_week.png',
            'most_theme_probes_per_day.png',
            'theme_probes_per_day.png',
            'theme_probes_per_week.png',
            'connections_per_ip.png',
            'connections_per_ip_pie.png',
            'author_probes_from_same_ip.png',
            'file_probes_from_same_ip.png',
            'login_page_probes_from_same_ip.png',
            'plugin_probes_from_same_ip.png',
            'theme_probes_from_same_ip.png',
            'most_probes_per_day.png',
            'probes_per_day.png',
            'probes_per_week.png',
        ];

        foreach ($generated_graphs_names_array as $graph_name)
            if (!file_exists($generated_graphs_path . $graph_name))
                return false;

        return true;
    }

    public function printOverallHoneypotActivity()
    {
        //TOTAL LOGIN ATTEMPTS
        $db_query = "SELECT COUNT(*) AS count FROM connections";
        $row = R::getRow($db_query);

        //echo '<strong>Total login attempts: </strong><h3>'.$row['logins'].'</h3>';
        echo '<table><thead>';
        echo '<tr>';
        echo '<th>Total attack attempts</th>';
        echo '<th>' . $row['count'] . '</th>';
        echo '</tr></thead><tbody>';
        echo '</tbody></table>';

        //TOTAL DISTINCT IPs
        $db_query = "SELECT COUNT(DISTINCT source_ip) AS ips FROM connections";
        $row = R::getRow($db_query);

        //echo '<strong>Distinct source IPs: </strong><h3>'.$row['IPs'].'</h3>';
        echo '<table><thead>';
        echo '<tr>';
        echo '<th>Distinct source IP addresses</th>';
        echo '<th>' . $row['ips'] . '</th>';
        echo '</tr></thead><tbody>';
        echo '</tbody></table>';

        //OPERATIONAL TIME PERIOD
        $db_query = "SELECT MIN(timestamp) AS start, MAX(timestamp) AS end FROM connections";
        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a skeleton for the table
            echo '<table><thead>';
            echo '<tr class="dark">';
            echo '<th colspan="2">Active time period</th>';
            echo '</tr>';
            echo '<tr class="dark">';
            echo '<th>Start date (first attack)</th>';
            echo '<th>End date (last attack)</th>';
            echo '</tr></thead><tbody>';

            //For every row returned from the database we add a new point to the dataset,
            //and create a new table row with the data as columns
            foreach ($rows as $row) {
                echo '<tr class="light">';
                echo '<td>' . date('l, d-M-Y, H:i A', strtotime($row['start'])) . '</td>';
                echo '<td>' . date('l, d-M-Y, H:i A', strtotime($row['end'])) . '</td>';
                echo '</tr>';
            }

            //Close tbody and table element, it's ready.
            echo '</tbody></table>';
        }
    }

    public function createTop10paths()
    {
        $db_query = "SELECT path, COUNT(path) AS count
          FROM connections
          GROUP BY path
          ORDER BY COUNT(path) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['path'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_PATHS);
            $chart->render("generated-graphs/top10_paths.png");
        }
    }

    public function createTop10author_probes()
    {
        $db_query = "SELECT probed_author, COUNT(probed_author) AS count
          FROM author_probes
          GROUP BY probed_author
          ORDER BY COUNT(probed_author) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_author'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_AUTHORS);
            $chart->render("generated-graphs/top10_authors.png");
        }
    }

    public function createTop10file_probes()
    {
        $db_query = "SELECT probed_filename, COUNT(probed_filename) AS count
          FROM file_probes
          GROUP BY probed_filename
          ORDER BY COUNT(probed_filename) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_filename'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_FILES);
            $chart->render("generated-graphs/top10_files.png");
        }
    }

    public function createTop10Combinations()
    {
        $db_query = "SELECT username, password, COUNT(username) AS count
          FROM login_attempts
          WHERE username <> '' AND password <> ''
          GROUP BY username, password
          ORDER BY COUNT(username) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart,a new pie chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $pie_chart = new PieChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['username'] . '/' . $row['password'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_COMBINATIONS);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 40, 75, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/top10_combinations.png");

            //We set the pie chart's dataset and render the graph
            $pie_chart->setDataSet($dataSet);
            $pie_chart->setTitle(TOP_10_COMBINATIONS);
            $pie_chart->render("generated-graphs/top10_combinations_pie.png");
        }
    }

    public function createTop10plugin_probes()
    {
        $db_query = "SELECT probed_plugin, COUNT(probed_plugin) AS count
          FROM plugins_probes
          GROUP BY probed_plugin
          ORDER BY COUNT(probed_plugin) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_plugin'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_PLUGINS);
            $chart->render("generated-graphs/top10_plugins.png");
        }
    }

    public function createTop10theme_probes()
    {
        $db_query = "SELECT probed_theme, COUNT(probed_theme) AS count
          FROM themes_probes
          GROUP BY probed_theme
          ORDER BY COUNT(probed_theme) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['probed_theme'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(TOP_10_THEMES);
            $chart->render("generated-graphs/top10_themes.png");
        }
    }


    public function createMostAuthorProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM author_probes
          GROUP BY date
          ORDER BY COUNT(*) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(MOST_AUTHOR_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/most_author_probes_per_day.png");
        }
    }

    public function createAuthorProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM author_probes
          GROUP BY date
          ORDER BY date ASC ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(AUTHOR_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/author_probes_per_day.png");
        }
    }

    public function createAuthorProbesPerWeek()
    {
        $db_query = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
          to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
          FROM author_probes
          GROUP BY week, year
          ORDER BY week ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;

                //We add 6 "empty" points to make a horizontal line representing a week
                for ($i = 0; $i < 6; $i++) {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(AUTHOR_PROBES_PER_WEEK);
            $chart->render("generated-graphs/author_probes_per_week.png");
        }
    }

    public function createMostFileProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM file_probes
          GROUP BY date
          ORDER BY COUNT(*) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(MOST_FILE_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/most_file_probes_per_day.png");
        }
    }

    public function createFileProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM file_probes
          GROUP BY date
          ORDER BY date ASC ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(FILE_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/file_probes_per_day.png");
        }
    }

    public function createFileProbesPerWeek()
    {
        $db_query = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
          to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
          FROM file_probes
          GROUP BY week, year
          ORDER BY week ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;

                //We add 6 "empty" points to make a horizontal line representing a week
                for ($i = 0; $i < 6; $i++) {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(FILE_PROBES_PER_WEEK);
            $chart->render("generated-graphs/file_probes_per_week.png");
        }
    }

    public function createMostLoginPageProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM login_page_probes
          GROUP BY date
          ORDER BY COUNT(*) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(MOST_LOGIN_PAGE_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/most_login_page_probes_per_day.png");
        }
    }

    public function createLoginPageProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM login_page_probes
          GROUP BY date
          ORDER BY date ASC ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(LOGIN_PAGE_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/login_page_probes_per_day.png");
        }
    }

    public function createLoginPageProbesPerWeek()
    {
        $db_query = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
          to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
          FROM login_page_probes
          GROUP BY week, year
          ORDER BY week ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;

                //We add 6 "empty" points to make a horizontal line representing a week
                for ($i = 0; $i < 6; $i++) {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(LOGIN_PAGE_PROBES_PER_WEEK);
            $chart->render("generated-graphs/login_page_probes_per_week.png");
        }
    }

    public function createMostPluginProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM plugins_probes
          GROUP BY date
          ORDER BY COUNT(*) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(MOST_PLUGIN_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/most_plugin_probes_per_day.png");
        }
    }

    public function createPluginProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM plugins_probes
          GROUP BY date
          ORDER BY date ASC ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(PLUGIN_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/plugin_probes_per_day.png");
        }
    }

    public function createPluginProbesPerWeek()
    {
        $db_query = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
          to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
          FROM plugins_probes
          GROUP BY week, year
          ORDER BY week ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;

                //We add 6 "empty" points to make a horizontal line representing a week
                for ($i = 0; $i < 6; $i++) {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(PLUGIN_PROBES_PER_WEEK);
            $chart->render("generated-graphs/plugin_probes_per_week.png");
        }
    }

    public function createMostThemeProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM themes_probes
          GROUP BY date
          ORDER BY COUNT(*) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(MOST_THEME_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/most_theme_probes_per_day.png");
        }
    }

    public function createThemeProbesPerDay()
    {
        $db_query = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
          FROM themes_probes
          GROUP BY date
          ORDER BY date ASC ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(THEME_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/theme_probes_per_day.png");
        }
    }

    public function createThemeProbesPerWeek()
    {
        $db_query = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
          to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
          FROM themes_probes
          GROUP BY week, year
          ORDER BY week ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;

                //We add 6 "empty" points to make a horizontal line representing a week
                for ($i = 0; $i < 6; $i++) {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(THEME_PROBES_PER_WEEK);
            $chart->render("generated-graphs/theme_probes_per_week.png");
        }
    }

    public function createNumberOfConnectionsPerIP()
    {
        $db_query = "SELECT source_ip, COUNT(source_ip) AS count
          FROM connections
          GROUP BY source_ip
          ORDER BY COUNT(source_ip) DESC
          LIMIT 10 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart,a new pie chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $pie_chart = new PieChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['source_ip'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(NUMBER_OF_CONNECTIONS_PER_UNIQUE_IP);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 40, 75, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/connections_per_ip.png");

            //We set the pie chart's dataset and render the graph
            $pie_chart->setDataSet($dataSet);
            $pie_chart->setTitle(NUMBER_OF_CONNECTIONS_PER_UNIQUE_IP);
            $pie_chart->render("generated-graphs/connections_per_ip_pie.png");
        }
    }

    public function createAuthorProbesFromSameIP()
    {
        $db_query = "SELECT source_ip, COUNT(source_ip) AS count
          FROM author_probes
          GROUP BY source_ip
          ORDER BY COUNT(source_ip) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['source_ip'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(AUTHOR_PROBES_FROM_SAME_IP);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 45, 80, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/author_probes_from_same_ip.png");
        }
    }

    public function createFileProbesFromSameIP()
    {
        $db_query = "SELECT source_ip, COUNT(source_ip) AS count
          FROM file_probes
          GROUP BY source_ip
          ORDER BY COUNT(source_ip) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['source_ip'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(FILE_PROBES_FROM_SAME_IP);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 45, 80, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/file_probes_from_same_ip.png");
        }
    }

    public function createLoginPageProbesFromSameIP()
    {
        $db_query = "SELECT source_ip, COUNT(source_ip) AS count
          FROM login_page_probes
          GROUP BY source_ip
          ORDER BY COUNT(source_ip) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['source_ip'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(LOGIN_PAGE_PROBES_FROM_SAME_IP);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 45, 80, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/login_page_probes_from_same_ip.png");
        }
    }

    public function createPluginProbesFromSameIP()
    {
        $db_query = "SELECT source_ip, COUNT(source_ip) AS count
          FROM plugins_probes
          GROUP BY source_ip
          ORDER BY COUNT(source_ip) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['source_ip'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(PLUGIN_PROBES_FROM_SAME_IP);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 45, 80, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/plugin_probes_from_same_ip.png");
        }
    }

    public function createThemeProbesFromSameIP()
    {
        $db_query = "SELECT source_ip, COUNT(source_ip) AS count
          FROM themes_probes
          GROUP BY source_ip
          ORDER BY COUNT(source_ip) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new vertical bar chart and initialize the dataset
            $chart = new VerticalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point($row['source_ip'], $row['count']));
            }

            //We set the bar chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(THEME_PROBES_FROM_SAME_IP);
            //For this particular graph we need to set the corrent padding
            $chart->getPlot()->setGraphPadding(new Padding(5, 45, 80, 50)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/theme_probes_from_same_ip.png");
        }
    }

    public function createMostProbesPerDay()
    {
        $db_query = "SELECT COUNT(*), date_trunc('day', timestamp) AS date
          FROM connections
          GROUP BY date
          ORDER BY COUNT(*) DESC
          LIMIT 20 ";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new horizontal bar chart and initialize the dataset
            $chart = new HorizontalBarChart(600, 300);
            $dataSet = new XYDataSet();

            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                //$dataSet->addPoint(new Point(date('l, d-m-Y', strtotime($row['timestamp'])), $row['COUNT(session)']));
            }

            //We set the horizontal chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(MOST_PROBES_PER_DAY);
            $chart->getPlot()->setGraphPadding(new Padding(5, 30, 50, 75 /*140*/)); //top, right, bottom, left | defaults: 5, 30, 50, 50
            $chart->render("generated-graphs/most_probes_per_day.png");
        }
    }

    public function createProbesPerDay()
    {
        $db_query = "SELECT COUNT(*), date_trunc('day', timestamp) AS date
          FROM connections
          GROUP BY date
          ORDER BY date ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(PROBES_PER_DAY);
            $chart->render("generated-graphs/probes_per_day.png");
        }
    }

    public function createProbesPerWeek()
    {
        $db_query = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
          to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
          FROM connections
          GROUP BY week, year
          ORDER BY week ASC";

        $rows = R::getAll($db_query);

        if (count($rows)) {
            //We create a new line chart and initialize the dataset
            $chart = new LineChart(600, 300);
            $dataSet = new XYDataSet();

            //This graph gets messed up for large DBs, so here is a simple way to limit some of the input
            $counter = 1;
            //Display date legend only every $mod rows, 25 distinct values being the optimal for a graph
            $mod = round(count($rows) / 25);
            if ($mod == 0) $mod = 1; //otherwise a division by zero might happen below
            //For every row returned from the database we add a new point to the dataset
            foreach ($rows as $row) {
                if ($counter % $mod == 0) {
                    $dataSet->addPoint(new Point(date('d-m-Y', strtotime($row['date'])), $row['count']));
                } else {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
                $counter++;

                //We add 6 "empty" points to make a horizontal line representing a week
                for ($i = 0; $i < 6; $i++) {
                    $dataSet->addPoint(new Point('', $row['count']));
                }
            }

            //We set the line chart's dataset and render the graph
            $chart->setDataSet($dataSet);
            $chart->setTitle(PROBES_PER_WEEK);
            $chart->render("generated-graphs/probes_per_week.png");
        }
    }
}

?>
