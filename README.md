ImportCsvUser
=============

[![PHP 7 ready](http://php7ready.timesplinter.ch/picamator/ImportCsvUser/dev/badge.svg)](https://travis-ci.org/picamator/ImportCsvUser)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/945e8dbd-0f8f-42ec-bfc6-7fcd573d0e6e/mini.png)](https://insight.sensiolabs.com/projects/945e8dbd-0f8f-42ec-bfc6-7fcd573d0e6e)

Master
------
[![Build Status](https://travis-ci.org/picamator/ImportCsvUser.svg?branch=master)](https://travis-ci.org/picamator/ImportCsvUser)
[![Coverage Status](https://coveralls.io/repos/github/picamator/ImportCsvUser/badge.svg?branch=master)](https://coveralls.io/github/picamator/ImportCsvUser?branch=master)

Dev
---
[![Build Status](https://travis-ci.org/picamator/ImportCsvUser.svg?branch=dev)](https://travis-ci.org/picamator/ImportCsvUser)
[![Coverage Status](https://coveralls.io/repos/github/picamator/ImportCsvUser/badge.svg?branch=dev)](https://coveralls.io/github/picamator/ImportCsvUser?branch=dev)

ImportCsvUser is a console application to help import User's data from CSV (comma separated value) to MySQL.
Project is working for specific CSV structure where first row acts as a schema. 

Additionally ImportCsvUser has:
 
* validators
* normalizers
* import result
* statistics

Requirements
------------
* [PHP 7.0](http://php.net/manual/en/migration70.new-features.php)
* [MySQL 5.7](https://www.mysql.com/)
* [Symfony 3](http://symfony.com/)

Install
-------
1. [Install and run Docker container](dev/docker/README.md)
2. Run inside Docker container `composer install`
3. Run inside Docker container to create database `php bin/console doctrine:database:create`

Usage
-----
ImportCsvUser supports `user:import-csv` withe required option `--path`.
For instance:

```
php bin/console user:import-csv --path ./tests/AppBundle/data/user.csv --verbose

```

_Note_: command SHOULD be run inside `import-web` container.


File format
-----------
File SHOULD has delimiter `,` with enclosure `"`.
First row in csv file is a schema. It is important the column name not an order. 

Table bellow describes column name.

name/characteristics    | firstname | infix | lastname  | date of birth | gender            | zipcode           | housenumber
---                     | ---       | ---   | ---       | ---           | ---               | ---               | ---
required                | yes       | no    | no        | no            | no                | no                | no
has normalizers         | no        | no    | no        | no            | tim, lowercase    | trim, uppercase   | no
example                 | Nick      | ter   | Tester    | 1991-08-24    | m                 | 12010             | 9b 

_Note_: column name SHOULD start form alphabetic character. It case if it's present some non alphabetic character it will be
remove and application try to map columns with sanitized column name. For instance if the original column name `# firstname` 
ImportCsvUser converts it to `firstname`.

Skipped rows
------------
Rows that has first column started with `#` are skipped. 

Normalizers
-----------
Normalizers helps to clean users data of get the right format.

Here is a normalizer list:

* zipcode: trim spaces and make uppercase

Validators
----------
The data validators skip rows and write the report result with keeping process running.

There is a list of validators:

* `firstname`: required
* `gender`: empty, `m` or `f`
* `birthday`: empty, or `yyyy-mm-dd`

Import result
-------------
Import result contains:

* Number of imported rows
* Number of skipped rows

Statistics
----------
Here is a list of supported statistics:

* Average age for women and men

Documentation
-------------
1. Database EER: (import_csv_user.png)[doc/db/import_csv_user.png]
2. Uml class diagram: (class.diagram.png)[doc/uml/class.diagram.png] 
3. Ideas: (FUTURE.CANDIDATE.md)[FUTURE.CANDIDATE.md]

Contribution
------------
If you find this project worth to use please add a star. Follow changes to see all activities.
And if you see room for improvement, proposals please feel free to create an issue or send pull request.
Here is a great [guide to start contributing](https://guides.github.com/activities/contributing-to-open-source/).

Please note that this project is released with a [Contributor Code of Conduct](http://contributor-covenant.org/version/1/4/).
By participating in this project and its community you agree to abide by those terms.

License
-------
ImportCsvUser is licensed under the MIT License. Please see the [LICENSE](LICENSE.txt) file for details.
