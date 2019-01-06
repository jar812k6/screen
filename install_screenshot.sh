#!/bin/bash

APACHE_ROOT_FOLDER="/var/www/html/"
INSTALL_FOLDER="screen"
GITHUB_LINK="https://github.com/jar812k6/screen"

cp -f memory-check.sh /usr/bin/memory-check
cp -f killphantom.sh /usr/bin/killphantom
chmod 755 /usr/bin/memory-check
chmod 755 /usr/bin/killphantom


yum update -y
yum install -y glibc.i686 zlib.i686 fontconfig.i686 libstdc++.i686
yum install -y git-all
yum install -y epel-release
rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
yum install -y yum-utils
yum repolist enabled
yum-config-manager --enable remi-php56
yum install -y fontconfig
yum install -y freetype*
yum install -y php php-common php-cli
iptables -I INPUT -p tcp --dport 80 -j ACCEPT
/etc/init.d/iptables save

cd $APACHE_ROOT_FOLDER

git clone $GITHUB_LINK $INSTALL_FOLDER

yum install -y cabextract xorg-x11-font-utils -y
rpm -i https://downloads.sourceforge.net/project/mscorefonts2/rpms/msttcore-fonts-installer-2.6-1.noarch.rpm
chmod +x $INSTALL_FOLDER/bin/phantomjs
cd $INSTALL_FOLDER
curl -sS https://getcomposer.org/installer | php
php composer.phar update
cd ..
chown -R apache $INSTALL_FOLDER
chgrp -R apache $INSTALL_FOLDER
setenforce 0
sed -i 's/SELINUX=enforcing/SELINUX=disabled/g' /etc/sysconfig/selinux
service httpd restart
chkconfig httpd on

CRONTAB=$(grep memory-check /etc/crontab | wc -l)
if [ $CRONTAB -eq 0 ]
then
  echo "* * * * * root memory-check" >> /etc/crontab
  echo "*/5 * * * * root killphantom" >> /etc/crontab
  echo "0 * * * * rm -f /var/www/html/screen/jobs/*" >> /etc/crontab
fi

