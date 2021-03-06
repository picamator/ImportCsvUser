Docker
======

Application environment has several containers:

* import-web - [Apache2.4](https://www.apache.org/), [PHP 7.0](http://php.net/manual/en/migration70.new-features.php), [OpenSSH](https://www.openssh.com/), [Supervised](http://supervisord.org/)
* import-mysql - [official MySQL docker](https://hub.docker.com/_/mysql/)

Pre installation
----------------
Before start please be sure that was installed:

1. [Docker](https://docs.docker.com/engine/installation/)
2. [Compose](https://docs.docker.com/compose/install/)

Installation
------------
1. Set environment variable `HOST_IP` with your host machine IP, e.g. `export host_ip=192.168.0.104`
2. Run in application root `sudo docker-compose -f dev/docker/docker-compose.yml up`
3. Check containers `sudo docker-compose ps`

Containers
----------

### import-web

#### SSH
SSH credentials:

1. user: `root`
2. password: `screencast`
3. ip: 0.0.0.0
4. port: 2229

To make connection via console simple run `ssh root@0.0.0.0 -p 2229`.

### import-mysql
For configuration MySQL connection inside linked `import-web`` use:

* host: import-mysql
* port: 3306
* username: 'root'
* password: 'root'

To get access from hosted machine please use:

* ip: 0.0.0.0
* port: 9306
* username: 'root'
* password: 'root'

Usefull commands
----------------

* go to shell inside container `sudo docker-compose -f ./dev/docker/docker-compose.yml exec {{container-name}} bash`
* build container `sudo docker-compose -f ./dev/docker/docker-compose.yml build {{container-name}}`
* build container without caching `sudo docker-compose -f ./dev/docker/docker-compose.yml build --no-cache {{container-name}}`

_Note_: please substitute all `{{container-name}}` by `import-web `, `import-mysql`.

For more information please visit [Docker Compose Command-line Reference](https://docs.docker.com/compose/reference/).

Configuration IDE (PhpStorm)
---------------------------- 
### Remote interpreter
1. Use ssh connection to set php interpreter
2. Set "Path mappings": `host machine project root->/ImportCsvUser`

More information is [here](https://confluence.jetbrains.com/display/PhpStorm/Working+with+Remote+PHP+Interpreters+in+PhpStorm).

### UnitTests
1. Configure UnitTest using remote interpreter. 
2. Choose "Use Composer autoload"
3. Set "Path to script": `/ImportCsvUser/vendor/autoload.php`
4. Set "Default configuration file": `/ImportCsvUser/phpunit.xml.dist`

More information is [here](https://confluence.jetbrains.com/display/PhpStorm/Running+PHPUnit+tests+over+SSH+on+a+remote+server+with+PhpStorm).
