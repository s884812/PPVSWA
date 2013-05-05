<?php
$dbserver = "localhost"; //your MySQL server address
$dbuser = "root"; //your MySQL user name
$dbpassword = "asdf5566isme"; //your MySQL user password
$dbname = "vpn"; //your MySQL database name for your site
$sitename = "puvpn"; //your site's name
$vpnaddress = "jp2.puvpn.com"; //your pptp vpn server's address
$vpnname = "pptpd"; //your pptp vpn server's name
$sitepassword = "asdf5566isme"; //set a password for this web admin program
$siteurl = "http://puvpn.net"; //your site's url with http://
$siteemail = "s884812@gmail.com"; //your site's admin email address
$logfile = "/var/log/messages"; //your 'messages' log file
$sublogfile = "sublog"; //sublog file created by PPVSWA, Need Write permission for that.
$analyzedlogfile = "analyzedlog"; //analyzed system log file. Do Not Delete Or Modify.
$maxip = "172.16.36.1";//client MAX ipv4 . The last 8 bit SHOULD BE 254. And you should alow this network access NAT by setting iptables.
$secretfile = "/etc/ppp/chap-secrets"; //your chap-secrets file location
$oldsecretfile = "/etc/ppp/chap-secrets.old"; //your old chap-secrets file location

//ALL varables in this file MUST be set.
?>
