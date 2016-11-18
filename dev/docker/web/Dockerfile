FROM ubuntu:16.04
ARG host_ip

RUN apt-get update

# php
RUN apt-get -y install php7.0
RUN apt-get -y install php7.0-xml
RUN apt-get -y install php7.0-curl
RUN apt-get -y install php7.0-zip
RUN apt-get -y install php7.0-intl
RUN apt-get -y install php7.0-bcmath
RUN apt-get -y install php7.0-mbstring
RUN apt-get -y install php7.0-mysql

# git
RUN apt-get -y install git

# composer
RUN php -r "file_put_contents('composer-setup.php', file_get_contents('https://getcomposer.org/installer'));"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === 'aa96f26c2b67226a324c27919f1eb05f21c248b987e6195cad9690d5c1ff713d53020a02ac8c217dbf90a7eacc9d141d') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# ssh, source https://docs.docker.com/engine/examples/running_ssh_service/ with correction https://github.com/docker/docker/issues/23621#issuecomment-226575258
RUN apt-get -y install openssh-server

RUN mkdir /var/run/sshd
RUN echo 'root:screencast' | chpasswd
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

# supervisor
RUN apt-get install -y supervisor
RUN mkdir -p  /var/log/supervisor
ADD ./dev/docker/web/config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# xdebug
RUN apt-get -y install wget
RUN apt-get -y install php7.0-dev

RUN wget -O ~/xdebug-2.4.1.tgz http://xdebug.org/files/xdebug-2.4.1.tgz
RUN tar -xvzf ~/xdebug-2.4.1.tgz
RUN rm ~/xdebug-2.4.1.tgz
RUN cd xdebug-2.4.1 && phpize
RUN cd xdebug-2.4.1 && ./configure
RUN cd xdebug-2.4.1 && make
RUN cd xdebug-2.4.1 && cp modules/xdebug.so /usr/lib/php/20151012
RUN rm -rf xdebug-2.4.1

# xdebug config cli
RUN echo "" >> /etc/php/7.0/cli/php.ini
RUN echo "; xdebug" >> /etc/php/7.0/cli/php.ini
RUN echo "zend_extension = /usr/lib/php/20151012/xdebug.so" >> /etc/php/7.0/cli/php.ini

RUN echo "xdebug.remote_enable = 1" >> /etc/php/7.0/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_autostart = 1" >> /etc/php/7.0/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_host = $host_ip" >> /etc/php/7.0/cli/conf.d/20-xdebug.ini

# display errors
RUN echo "display_errors = 1" >> /etc/php/7.0/cli/php.ini

# expose ports
EXPOSE 22
CMD ["supervisord", "--configuration", "/etc/supervisor/conf.d/supervisord.conf", "--logfile", "/var/log/supervisor/supervisord.log", "--logfile_maxbytes", "5000000", "--logfile_backups", "5", "--pidfile", "/var/tmp/supervisord.pid"]

# volume
RUN mkdir /ImportCsvUser
VOLUME /ImportCsvUser

# workdir
WORKDIR /ImportCsvUser

# permission & user
RUN usermod -u 1000 www-data
RUN chown -R www-data:www-data /ImportCsvUser
