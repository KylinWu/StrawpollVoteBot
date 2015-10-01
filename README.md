## StrawpollVoteBot ##

This is a [Strawpoll](http://strawpoll.me/) Vote Bot. You will need to have PHP5 and PHP-curl installed on your machine for this script to work.

## Installing PHP and cURL

**Ubuntu/Debian Linux**

1. Install PHP:

    `sudo apt-get install php5`

2. Install cURL:

    `sudo apt-get install php5-curl`

3. Restart Apache:

    `sudo /etc/init.d/apache2 restart`
    
**Other**

1. ![Go to cURL's download section](http://curl.haxx.se/dlwiz/?type=bin)
2. Select your Operating System
3. Select your OS version [situational]
4. Select cURL version [situational]
5. Click download
6. Follow install directions

If these steps do not work for you, try going ![here](http://php.net/manual/en/curl.installation.php).

## Usage ##




**Update the proxy list**


    php update_proxies.php

----------

**Run the Vote Bot**


    php vote.php <VoteID> <Option> <Amount>

    For example:
    php vote.php 3491291 2 100
    
![](http://i.imgur.com/ZTY1Aaz.png)

----------
