## StrawpollVoteBot ##

This is a [Strawpoll](http://strawpoll.me/) Vote Bot. You will need to have PHP5 and PHP-curl installed on your machine for this script to work.

## Installing PHP and cURL

**Ubuntu Linx**

1. Install PHP:

    `sudo apt-get install php5`

2. Install cURL:

    `sudo apt-get install php5-curl`

**Other**

1. ![Go to cURL's download section on their website](http://curl.haxx.se/dlwiz/?type=bin)
2. Select your Operating System
3. Select your OS version [situational]
4. Select cURL version [situational]
5. Click download
6. Follow install directions

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
