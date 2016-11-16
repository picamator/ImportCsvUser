ImportCsvUser
=============

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

File format
-----------
File SHOULD has delimiter `,` with enclosure `"`.
First row in csv file is a schema. The main point is a column name not an order. 

Table bellow describes column name.

name/characteristics    | firstname  | infix | lastname  | date of birth | gender    | zipcode          | housenumber
---                     | ---       | ---   | ---       | ---           | ---       | ---               | ---
required                | yes       | no    | no        | no            | no        | no                | no
has normalizers         | no        | no    | no        | no            | no        | trim, uppercase   | no
example                 | Nick      | ter   | Tester    | 1991-08-24    | m         | 12010             | 9b 

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
There are two types of validators:

* csv schema
* data

The csv schema validators prevent file from importing. The data validators skip rows and write the log with keeping process running.

### CSV schema validator
Validator checks that first column has the proper name and all presents even the optional one.

### Data validator

There is a list of validators:

* firstname: required
* gender: empty, `m` or `f`
* birthday: empty, or `yyyy-mm-dd`

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
2. Database schema sql: (import_csv_user.sql)[doc/db/import_csv_user.sql]
3. Uml class diagram: (class.diagram.png)[doc/uml/class.diagram.png] 

Developing
----------
To configure developing environment please:

1. [Install and run Docker container](dev/docker/README.md)
2. Run inside Docker container `composer install`

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
