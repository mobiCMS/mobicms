# [mobiCMS](https://mobicms.org)

mobiCMS Content Management System is in the early development stage and is not intended for installation on existing
public sites. **LOCAL TEST ONLY!!!**

[![GitHub](https://img.shields.io/github/license/mobicms/mobicms?color=green)](https://github.com/mobicms/mobicms/blob/main/LICENSE)
[![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/mobicms/mobicms)](https://github.com/mobicms/mobicms/releases)
[![Packagist](https://img.shields.io/packagist/dt/mobicms/mobicms)](https://packagist.org/packages/mobicms/mobicms)

[![CI-Analysis](https://github.com/mobicms/mobicms/workflows/Analysis/badge.svg)](https://github.com/mobicms/mobicms/actions/workflows/analysis.yml)
[![CI-Tests](https://github.com/mobicms/mobicms/workflows/Tests/badge.svg)](https://github.com/mobicms/mobicms/actions/workflows/tests.yml)
[![Sonar Coverage](https://img.shields.io/sonar/coverage/mobicms_mobicms?server=https%3A%2F%2Fsonarcloud.io)](https://sonarcloud.io/code?id=mobicms_mobicms)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=mobicms_mobicms&metric=alert_status)](https://sonarcloud.io/summary/overall?id=mobicms_mobicms)


## System requirements

Make sure your server meets the following requirements:
- Apache webserver
  - [mod_rewrite](https://httpd.apache.org/docs/2.4/mod/mod_rewrite.html)
- PHP 8.0 or higher
  - [gd](https://www.php.net/manual/en/book.image.php)
  - [mbstring](https://www.php.net/manual/en/book.mbstring.php)
  - [pdo_mysql](https://www.php.net/manual/en/ref.pdo-mysql.php)
- MariaDB, MySQL or other compatible database
  - InnoDB must be enabled


## Installation
**To install the general availability version**, go to the [**project website**][website] and download the latest available distributive.
Then follow the installation instructions that came with it.

**To install the developer version**, you must have a [Composer](https://getcomposer.org) dependency manager
and [GIT](https://git-scm.com/) version control system.
1. Clone or download this repository on local workstation.
2. Assign the repository folder as Apache virtual host, or move contents to the previously created virtual host folder.
3. Create MySQL Database.
4. Import into the created database ALL files that are located in the `/install/sql` folder.
5. Copy the `/config/config.local.php.dist` file to `/config/config.local.php`.
6. Write in the copied file the credentials of access to the database you created.
7. Open the console in the virtual host folder and install the dependencies using the command `composer install`.
8. **This is all done**. If you go to the address of your virtual host from the browser, you should see a working site with demo data.

## Contributing
Contributions are welcome! Please read [CONTRIBUTING][contributing] for details.

[![YAGNI](https://img.shields.io/badge/principle-YAGNI-blueviolet.svg)](https://en.wikipedia.org/wiki/YAGNI)
[![KISS](https://img.shields.io/badge/principle-KISS-blueviolet.svg)](https://en.wikipedia.org/wiki/KISS_principle)

In our development, we follow the principles of YAGNI and KISS.
The source code should not have extra unnecessary functionality and should be as simple and efficient as possible.


## License
This package is licensed for use under the GPL-3 License.  
Please see [LICENSE][license] for more information.


## Copyright
Copyright (c) 2021 [mobiCMS Project][website].  
All rights to used third-party libraries, fonts, images, etc. reserved by their authors.


## Our links
- [**mobiCMS Project**][website] website and support forum
- [**GitHub**](https://github.com/mobicms) mobiCMS project repository
- [**Twitter**](https://twitter.com/mobicms)

[website]: https://mobicms.org
[repository]: https://github.com/mobicms/mobicms
[contributing]: https://github.com/mobicms/mobicms/blob/main/.github/CONTRIBUTING.md
[license]: https://github.com/mobicms/system/blob/main/LICENSE
