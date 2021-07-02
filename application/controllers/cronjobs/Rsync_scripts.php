<?php
exec('rsync -rpog --delete --chown=wwwshop:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/shop7thavenue.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');

exec('rsync -rpog --delete --chown=wwwtemp:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/tempoparis.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');

exec('rsync -rpog --delete --chown=wwwbasix:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/basixblacklabel.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');

exec('rsync -rpog --delete --chown=wwwchaarm:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/chaarmfurs.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');

exec('rsync -rpog --delete --chown=wwwissue:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/issueny.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');

exec('rsync -rpog --delete --chown=wwwgracia:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/graciafashions.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');

exec('rsync -rpog --delete --chown=wwworia:psacln --chmod=Du=rwx,Dg=rx,Do=rx,Fu=rw,Fg=r,Fo=r /var/www/vhosts/instylenewyork.com/httpdocs/assets/custom/js/metronic/pages/scripts /var/www/vhosts/oriacouture.com/httpdocs/assets/custom/js/metronic/pages/ > /dev/null &');
