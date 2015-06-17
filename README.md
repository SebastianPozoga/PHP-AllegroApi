# PHP-AllegroApi
A newest library to communicate with Allegro Api. The library is OOP, good tested and easy to use. Make your job enjoyable. The version is tested with PHP5.5

# Documentation
In this section I describe a class and methods you should use

## Configuration
To run test you must insert you login, password and appkey to Config/config.ini file.

`````ini
login = "Insert your login here"
password = "Insert your password here - never do it in production"
apikey = "Insert your apikey here"
sandbox = false
countryCode = 1
`````

The file is use only by tests.

You can create your access data by http://allegro.pl/myaccount/webapi.php/ page.
*sandbox*  is use to switch allegro sandbox and production version. *countryCode* is used to select current country. Default 1 mean *Poland*. If you want you can change country to communication with other allegroGroup services like: aukro.cz, molotok.ru, aukro.ua, teszvesz.hu

## Security

Never storage your plain password. Your app should always hash it by sha256 (used by allegro)

`````php
  $hashPassword = base64_encode(hash('sha256', YOUR_ALLEGRO_PASSWORD, true));
`````

## Class AllegroApi
AllegroApi is main class. Provide api access interface.

### Constructor
*Require* one object with login, hashPassword (or password - strongly no recomended), apikey, sandbox, countryCode fields. The data is use to init connections. 

### LoginEnc
Login to allegro (use constructor data)

### Run functions
The api use _call to maping functions names to allegro request. You should use short names without "do". Use  getCountries (to rum allegro doGetCountries function).

`````php
  $allegroApi = new AllegroApi($config);
  $countrisResponse = $allegroApi->getCountries();
`````

#Allegro functions documentation
Description of all allegro functions are available on http://allegro.pl/webapi/documentation.php

# Quick start

Clone empty project:
~~~bash
git clone https://github.com/SebastianPozoga/PHP-AllegroApi-EmptyProject.git
composer install
~~~

And run:
~~~
php index.php
~~~

# Tests

Run tests by:
~~~
phpunit tests/AllegroApiTest
~~~

# Older version
It is strong recomended to use new version of PHP Allegro Api Library. If you must use old version is available on https://github.com/SebastianPozoga/Allegro-PHP-API-14
