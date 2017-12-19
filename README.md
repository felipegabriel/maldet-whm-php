# cPanel-WHM-Maldet-GUI

### Install

	mkdir -p /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php
	cd /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php/
	wget --no-check-certificate -O master.zip https://github.com/felipegabriel/maldet-whm-php/archive/master.zip
	unzip master.zip
	/bin/cp -rf /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php//maldet-whm-php-master/* /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php/
	/bin/rm -rvf /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php/maldet-whm-php
	/bin/rm -f /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php/master.zip
	/usr/local/cpanel/bin/register_appconfig /usr/local/cpanel/whostmgr/docroot/cgi/maldet-whm-php/maldet-whm-php.conf
	

Used by
	brasilwork.com.br
