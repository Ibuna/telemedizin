# Testaufgabe Telemedizin

Im Folgendem alle Informationen zur Installation und zum Aufbau.

## Voraussetzungen

PHP, composer und Node.js bzw. npm werden benötigt.

## Installation

Nachdem das Projekt mit git geklont wurde und das Projektverzeichnis aufgerufen wurde, müssen composer und npm Dependencies installiert werden. Danach kann der Buildprozess aufgerufen werden. Dafür werden folgende Befehle verwendet:

```bash
composer install
npm install
npm run build
```

Als .env Datei mit allen evironmentspezifischen Werten, kann die .env.example genutzt werden, da keine besonderen Konfigurationen benötigt werden.

```bash
cp .env.example .env
```

Applikation key setzen:

```bash
php artisan key:generate
```

Als Datenbank wurde SQLite verwendet um den Installationsaufwand zu begrenzen. Folgende Befehle setzen die Datenbank auf und befüllen sie dann mit Testdaten (die Frage ob die Datenbank angelegt werden soll, muss mit "Yes" beantwortet werden).

 ```bash
php artisan migrate
php artisan db:seed
```

Der Deveolpment Server kann nun wie folgt gestartet werden:

```bash
php artisan serve
```

## Backend

Für das Backend wurde Laravel 11 genutzt. Die Erstellung der benötigten Klassen, erfolgte - soweit möglich - mit Artisan. 

Hier beispielhaft die Befehle für die Erstellung des Doctor Models und anderer Klassen, die hiermit zusammenhängen:

```
php artisan make:model Doctor
php artisan make:migration create_doctors_table
php artisan make:controller DoctorApiController --api
php artisan make:factory DoctorFactory
```

Die wichtigsten Dateien befinden sich unter:

- **Models** -> `\app\Models`
- **Controllers** -> `\app\Http\Controllers`
- **Routing** -> `\routes`

Die in der Aufgabe beschriebenen Relationen wurden in den Models festgehalten.

Die verfügbaren Routen sind folgende. Hier ist der korrigierte Satz:

Die verfügbaren Routen sind folgende: API-Routen haben ein `api`-Präfix und sind RESTful aufgebaut.

```
GET|HEAD        / ....................................................................................
GET|HEAD        api/appointments ................. appointments.index › AppointmentApiController@index
POST            api/appointments ................. appointments.store › AppointmentApiController@store
GET|HEAD        api/appointments/{appointment} ..... appointments.show › AppointmentApiController@show
PUT|PATCH       api/appointments/{appointment} . appointments.update › AppointmentApiController@update
DELETE          api/appointments/{appointment} appointments.destroy › AppointmentApiController@destroy
GET|HEAD        api/doctors ................................ doctors.index › DoctorApiController@index
POST            api/doctors ................................ doctors.store › DoctorApiController@store
GET|HEAD        api/doctors/{doctor} ......................... doctors.show › DoctorApiController@show
PUT|PATCH       api/doctors/{doctor} ..................... doctors.update › DoctorApiController@update
DELETE          api/doctors/{doctor} ................... doctors.destroy › DoctorApiController@destroy
GET|HEAD        api/timeslots .......................... timeslots.index › TimeslotApiController@index
POST            api/timeslots .......................... timeslots.store › TimeslotApiController@store
GET|HEAD        api/timeslots/{timeslot} ................. timeslots.show › TimeslotApiController@show
PUT|PATCH       api/timeslots/{timeslot} ............. timeslots.update › TimeslotApiController@update
DELETE          api/timeslots/{timeslot} ........... timeslots.destroy › TimeslotApiController@destroy
GET|HEAD        sanctum/csrf-cookie sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show
GET|HEAD        search/doctors ......................................... DoctorSearchController@search
```

## Frontend

Das Frontend wurde mit Vue.js, Pinia als Store für das State Management, Tailwind als CSS Framework und DaisyUI als Tailwind Komponentenbibliothek, aufgebaut.

Die wichtigsten Dateien befinden sich unter:

- **Components** -> `\resources\js\components`
- **Store** -> `\resources\js\stores`
- **Router** -> `\resources\js\router`

## Tests

Die Tests sind im '/tests' Ordner. Es gibt ein paar Unit Tests für das Doctor Model und die zugehörigen Relationen und ein paar Feature Tests für Doctor und Appointment API. Die Tests werden mit folgendem Befehl aufgerufen:

 ```bash
php artisan test
```

## Bonusaufgaben

### Verfügbarkeitsprüfung

### Suche

### eMail Benachrichtigung
