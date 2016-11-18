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
ImportCsvUser supports commands:

 * `user:import-csv`: import csv file to database
 * `user:age-average`: get age average

_Note_: all example command SHOULD be run inside `import-web` container.

### user:import-csv

Please run `php bin/console user:import-csv -h` to see how to use command.

#### Example 1

In that example valid user file is importing.

Please execute:

```bash
php bin/console user:import-csv --path ./doc/csv/user.valid.csv

```

As execution result:

```bash
Imported: 5
Skipped: 0

```

#### Example 2

In that example some file contains some invalid rows.

Please execute command:

```bash
php bin/console user:import-csv --path ./doc/csv/user.valid.csv

```

As execution result:

```bash
Imported: 2
Skipped: 3
Line #1: Invalid parameter 'firstName'. This value should not be blank.
Line #1: Invalid parameter 'gender'. Choose a valid gender.
Line #5: Invalid parameter 'zipCode'. This value is too long. It should have 32 character or less.
Line #7: Invalid parameter 'birthDate'. This value is not a valid date.

```

### user:age-average

Please run `php bin/console user:age-average -h` to see how to use command.

#### Example 1

Please execute command:

```bash
php bin/console user:age-average

```

As execution result:

```bash
Average male age: 32.12
Average female age: 30.26

```

File format
-----------
File SHOULD has delimiter `,` with enclosure `"`.
First row in csv file is a schema. It is important the column name not an order. 

Table bellow describes column name.

name/characteristics    | firstname     | infix         | lastname      | date of birth | gender            | zipcode           | housenumber
---                     | ---           | ---           | ---           | ---           | ---               | ---               | ---
required                | yes           | no            | no            | no            | no                | no                | no
has normalizers         | no            | no            | no            | no            | tim, lowercase    | trim, uppercase   | no
data type               | String[2-255] | String[0-45]  | String[0-255] | Date[Y-m-d]   | String['m', 'f']  | String[0-32]      | String[0-255]
example                 | Nick          | ter           | Tester        | 1991-08-24    | m                 | 12010             | 9b 

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

* zipcode: trim spaces, make uppercase

Validators
----------
The data validators skip rows and write the report result with keeping process running.

There is a list of validators:

* `firstname`: required, max length 255
* `infix`: max length 45
* `lastname`: max length 255
* `gender`: `m` or `f`
* `birthday`: date `yyyy-mm-dd`
* `zipcode`: max length 32
* `housenumber`: max length 255

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
1. Database EER: [import_csv_user.png](doc/db/import_csv_user.png)
2. Uml class diagram: [class.diagram.png](doc/uml/class.diagram.png) 
3. Ideas: [FUTURE.CANDIDATE.md](FUTURE.CANDIDATE.md)
4. CSV samples: [csv](doc/csv)

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
