# Wordpot-Frontend
===========

Wordpot-Frontend is a full featured script to visualize statistics from a Wordpot honeypot.

It requires version of wordpot that logs to postgresql (https://github.com/GovCERT-CZ/wordpot).

It is based on Kippo-Graph (https://github.com/ikoniaris/kippo-graph). Thanks to ikoniaris.

It uses the Libchart PHP chart drawing library by Jean-Marc Trémeaux,
QGoogleVisualizationAPI PHP Wrapper for Google's Visualization API by Thomas Schäfer,
RedBeanPHP library by Gabor de Mooij, MaxMind and geoPlugin geolocation technology.

# REQUIREMENTS:
-------------
1. PHP version 5.3.4 or higher.
2. The following packages: _libapache2-mod-php5_, _php5-pgsql_, _php5-gd_, _php5-curl_.

On Ubuntu/Debian:
> apt-get update && apt-get install -y libapache2-mod-php5 php5-pgsql php5-gd php5-curl
>
> /etc/init.d/apache2 restart

# QUICK INSTALLATION:
-------------------
> wget https://github.com/GovCERT-CZ/Wordpot-Frontend/archive/master.zip
>
> mv Wordpot-Frontend-master.zip /var/www/html
>
> cd /var/www/html
>
> unzip Wordpot-Frontend-master.zip
>
> mv Wordpot-Frontend-master wordpot-frontend
>
> cd wordpot-frontend
>
> chmod 777 generated-graphs
>
> cp config.php.dist config.php
>
> nano config.php #enter the appropriate values

Browse to http://your-server/wordpot-frontend to generate the statistics.




Note 1: If you choose to disable `REALTIME_STATS` in your config.php file it is advisable to
        setup a cron job to update the charts in the background. The recommended way to do that
        is to add the following line in your crontab with `crontab -e` (make sure to change the
        wordpot-frontend path if it's different):
> @hourly cd /var/www/wordpot-frontend && php wordpot-graph.php > /dev/null 2>&1


