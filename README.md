<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:
- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

1) pims_person_genders Table Query:

ALTER TABLE pims_person_genders
ADD active_status INT;
ADD description TEXT;
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

2)pims_person_salutations Table Query:


ALTER TABLE pims_person_salutations
ADD active_status INT;
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;
ADD description TEXT;


3)PIMS Person BloodGroup Table Query:

ALTER TABLE pims_person_blood_groups
ADD description TEXT;
ADD active_status INT;
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

4)PIMS Person marital statues Table Query:

ALTER TABLE pims_person_marital_statues
ADD description TEXT;
ADD active_status INT;
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

5)PIMS Person relationships Table Query:

ALTER TABLE pims_person_relationships
ADD description TEXT,
ADD active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

6) Add Pims_User Table Query:


CREATE TABLE Pims_Users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    mobile VARCHAR(20),
    email VARCHAR(255),
    password VARCHAR(255),
    role_id INT,
    active_status INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

7) Add Pims_bank_account_types Table Query:

ALTER TABLE pims_person_relationships
ADD COLUMN created_at TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN active_status INT NULL;

8) Add Pims_banks Table query:

ALTER TABLE pims_banks
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN active_status INT NULL;

9)  Add Pims_com_address_types Table query:

ALTER TABLE Pims_com_address_types
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL,
CHANGE COLUMN status active_status INT;

10)Add Pims_com_languages Table query:

ALTER TABLE Pims_com_languages
CHANGE COLUMN status active_status INT,
ADD COLUMN created_at TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

11) Add Pims_org_administrator_types Table query:
ALTER TABLE Pims_org_administrator_types
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

12) Add Pims_org_business_activities  Table query:
ALTER TABLE Pims_org_business_activities
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

13) Add Pims_org_business_sale_subsets  Table query:


ALTER TABLE Pims_org_business_sale_subsets
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

14) Add Pims_org_business_sectors  Table query:

ALTER TABLE Pims_org_business_sectors
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

15) Add Pims_org_categories  Table query:

ALTER TABLE Pims_org_categories
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

16) Add Pims_org_document_types  Table query:

ALTER TABLE Pims_org_document_types
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

17) Add Pims_org_ownerships  Table query:

ALTER TABLE Pims_org_ownerships
CHANGE COLUMN STATUS active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

18)Add Pims_person_document_types  Table query:

ALTER TABLE Pims_person_document_types
CHANGE COLUMN mandatory_status active_status INT,
ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;

19) Delete table Lists:
DROP TABLE pims_com_states;
DROP TABLE pims_com_countries;
DROP TABLE pims_com_cities;

20) create pims_com_states tables:
CREATE TABLE pims_com_states (
    id INT PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(255),
    country_id INT,
    active_status INT,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);

 21) create pims_com_countries tables:
 CREATE TABLE pims_com_countries (
	    id INT PRIMARY KEY AUTO_INCREMENT,
	    NAME VARCHAR(255),
	    active_status INT,
	    created_at TIMESTAMP NULL DEFAULT NULL,
	    updated_at TIMESTAMP NULL DEFAULT NULL,
	    deleted_at TIMESTAMP NULL DEFAULT NULL
	);
22) create pims_com_cities tables:
CREATE TABLE pims_com_cities (
	    id INT PRIMARY KEY AUTO_INCREMENT,
	    NAME VARCHAR(255),
	    state_id INT,
	    active_status INT,
	    created_at TIMESTAMP NULL DEFAULT NULL,
	    updated_at TIMESTAMP NULL DEFAULT NULL,
	    deleted_at TIMESTAMP NULL DEFAULT NULL
	);
