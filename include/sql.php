<?php
# Author: Kevin Breen
# Modifications: standa4

//TOTAL LOGIN ATTEMPTS
$db_AllCount = "SELECT COUNT(*) AS connections FROM connections";

//TOTAL DISTINCT IPs
$db_CountIP = "SELECT COUNT(DISTINCT source_ip) AS IPs FROM connections";

//NUMBER CONNECTIONS PER IP
$db_IP = "SELECT source_ip, COUNT(source_ip) as count
  FROM connections
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";

//OPERATIONAL TIME PERIOD
$db_OpTime = "SELECT MIN(timestamp) AS start, MAX(timestamp) AS end FROM connections";

// ALL PATHS AND COUNT
$db_Paths = "SELECT path, COUNT(path) AS count
  FROM connections
  GROUP BY path
  ORDER BY COUNT(path) DESC";

// ALL AUTHOR PROBES AND COUNT
$db_Authors = "SELECT probed_author, COUNT(probed_author) AS count
  FROM author_probes
  GROUP BY probed_author
  ORDER BY COUNT(probed_author) DESC";

// ALL FILENAME PROBES AND COUNT
$db_Filenames = "SELECT probed_filename, COUNT(probed_filename) AS count
  FROM file_probes
  GROUP BY probed_filename
  ORDER BY COUNT(probed_filename) DESC";

// ALL USERNAME AND PASSWORD COMBINATIONS AND COUNT
$db_Combo = "SELECT username, password, COUNT(username) AS count
  FROM login_attempts
  WHERE username <> '' AND password <> ''
  GROUP BY username, password
  ORDER BY COUNT(username) DESC";

// ALL PLUGIN PROBES AND COUNT
$db_Plugins = "SELECT probed_plugin, COUNT(probed_plugin) AS count
  FROM plugins_probes
  GROUP BY probed_plugin
  ORDER BY COUNT(probed_plugin) DESC";

// ALL THEME PROBES AND COUNT
$db_Themes = "SELECT probed_theme, COUNT(probed_theme) AS count
  FROM themes_probes
  GROUP BY probed_theme
  ORDER BY COUNT(probed_theme) DESC";

//
$db_WordpotAuthorsMost = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM author_probes
  GROUP BY date
  ORDER BY COUNT(*) DESC";

//
$db_WordpotAuthorsDay = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM author_probes
  GROUP BY date
  ORDER BY date ASC";

//
$db_WordpotAuthorsWeek = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
  to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
  FROM author_probes
  GROUP BY week, year
  ORDER BY week ASC";

//
$db_WordpotFilenamesMost = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM file_probes
  GROUP BY date
  ORDER BY COUNT(*) DESC";

//
$db_WordpotFilenamesDay = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM file_probes
  GROUP BY date
  ORDER BY date ASC";

//
$db_WordpotFilenamesWeek = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
  to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
  FROM file_probes
  GROUP BY week, year
  ORDER BY week ASC";

//
$db_WordpotLoginProbesMost = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM login_page_probes
  GROUP BY date
  ORDER BY COUNT(*) DESC";

//
$db_WordpotLoginProbesDay = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM login_page_probes
  GROUP BY date
  ORDER BY date ASC";

//
$db_WordpotLoginProbesWeek = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
  to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
  FROM login_page_probes
  GROUP BY week, year
  ORDER BY week ASC";

//
$db_WordpotPluginsMost = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM plugins_probes
  GROUP BY date
  ORDER BY COUNT(*) DESC";

//
$db_WordpotPluginsDay = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM plugins_probes
  GROUP BY date
  ORDER BY date ASC";

//
$db_WordpotPluginsWeek = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
  to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
  FROM plugins_probes
  GROUP BY week, year
  ORDER BY week ASC";

//
$db_WordpotThemesMost = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM themes_probes
  GROUP BY date
  ORDER BY COUNT(*) DESC";

//
$db_WordpotThemesDay = "SELECT COUNT(*) AS count, date_trunc('day', timestamp) AS date
  FROM themes_probes
  GROUP BY date
  ORDER BY date ASC";

//
$db_WordpotThemesWeek = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
  to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
  FROM themes_probes
  GROUP BY week, year
  ORDER BY week ASC";

//
$db_ConnIP = "SELECT source_ip, COUNT(source_ip) AS count
  FROM connections
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";

//
$db_AuthorsIP = "SELECT source_ip, COUNT(source_ip) AS count
  FROM author_probes
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";

//
$db_FilenamesIP = "SELECT source_ip, COUNT(source_ip) AS count
  FROM file_probes
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";

//
$db_LoginProbesIP = "SELECT source_ip, COUNT(source_ip) AS count
  FROM login_page_probes
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";

//
$db_PluginsIP = "SELECT source_ip, COUNT(source_ip) AS count
  FROM plugins_probes
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";

//
$db_ThemesIP = "SELECT source_ip, COUNT(source_ip) AS count
  FROM themes_probes
  GROUP BY source_ip
  ORDER BY COUNT(source_ip) DESC";




// PROBES PER DAY
$db_ProbesDay = "SELECT COUNT(*), date_trunc('day', timestamp) AS date
  FROM connections
  GROUP BY date
  ORDER BY date ASC";

// PROBES PER WEEK
$db_ProbesWeek = "SELECT COUNT(*) AS count, EXTRACT(week from timestamp) AS week, EXTRACT(year from timestamp) AS year,
  to_date('' || EXTRACT(week from timestamp) || ' ' || EXTRACT(year from timestamp), 'IW IYYY') AS date
  FROM connections
  GROUP BY week, year
  ORDER BY week ASC";





//
$db_ProbedAuthors = "SELECT probed_author, COUNT(probed_author) AS count
  FROM author_probes
  WHERE probed_author <> ''
  GROUP BY probed_author
  ORDER BY COUNT(probed_author) DESC";

//
$db_ProbedFilenames = "SELECT probed_filename, COUNT(probed_filename) AS count
  FROM file_probes
  WHERE probed_filename <> ''
  GROUP BY probed_filename
  ORDER BY COUNT(probed_filename) DESC";

//
$db_LoginAttempts = "SELECT username, password, COUNT('' || username || '/' || password) AS count
  FROM login_attempts
  WHERE username <> '' AND password <> ''
  GROUP BY username, password
  ORDER BY COUNT('' || username || '/' || password) DESC";

//
$db_ProbedPlugins = "SELECT probed_plugin, COUNT(probed_plugin) AS count
  FROM plugins_probes
  WHERE probed_plugin <> ''
  GROUP BY probed_plugin
  ORDER BY COUNT(probed_plugin) DESC";

//
$db_ProbedThemes = "SELECT probed_theme, COUNT(probed_theme) AS count
  FROM themes_probes
  WHERE probed_theme <> ''
  GROUP BY probed_theme
  ORDER BY COUNT(probed_theme) DESC";

//
$db_Headers = "SELECT headers, COUNT(headers) AS count
  FROM connections
  WHERE headers <> ''
  GROUP BY headers
  ORDER BY COUNT(headers) DESC";

//
$db_Urls = "SELECT url, COUNT(url) AS count
  FROM connections
  WHERE url <> ''
  GROUP BY url
  ORDER BY COUNT(url) DESC";





// ACTIVITY PER DAY
$db_ActivityDay = "SELECT COUNT(input), timestamp
  FROM input
  GROUP BY DAYOFYEAR(timestamp)
  ORDER BY timestamp ASC";

// ACTIVITY PER WEEK
$db_ActivityWeek = "SELECT COUNT(input),
  MAKEDATE(CASE WHEN WEEKOFYEAR(timestamp) = 52
    THEN YEAR(timestamp)-1
    ELSE YEAR(timestamp)
    END, (WEEKOFYEAR(timestamp) * 7)-4) AS DateOfWeek_Value
  FROM input
  GROUP BY WEEKOFYEAR(timestamp)
  ORDER BY timestamp ASC";




// ALL IP ACTIVITY
$db_allActivity = "SELECT m.*,
  CASE WHEN a.a_c > 0 THEN true ELSE false END AS author_probe_exists,
  CASE WHEN b.b_c > 0 THEN true ELSE false END AS file_probe_exists,
  CASE WHEN c.c_c > 0 THEN true ELSE false END AS login_attempts_exists,
  CASE WHEN d.d_c > 0 THEN true ELSE false END AS plugin_probes_exists,
  CASE WHEN e.e_c > 0 THEN true ELSE false END AS themes_probes_exists
  FROM (SELECT source_ip, MAX(timestamp) AS lastseen FROM connections GROUP BY source_ip) m
  LEFT JOIN (SELECT source_ip, count(*) AS a_c FROM author_probes GROUP BY source_ip) AS a ON m.source_ip = a.source_ip
  LEFT JOIN (SELECT source_ip, count(*) AS b_c FROM file_probes GROUP BY source_ip) AS b ON m.source_ip = b.source_ip
  LEFT JOIN (SELECT source_ip, count(*) AS c_c FROM login_attempts GROUP BY source_ip) AS c ON m.source_ip = c.source_ip
  LEFT JOIN (SELECT source_ip, count(*) AS d_c FROM plugins_probes GROUP BY source_ip) AS d ON m.source_ip = d.source_ip
  LEFT JOIN (SELECT source_ip, count(*) AS e_c FROM themes_probes GROUP BY source_ip) AS e ON m.source_ip = e.source_ip
  ORDER BY m.source_ip ASC
  LIMIT 65535";

?>
