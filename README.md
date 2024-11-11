# Testaufgabe Telemedizin

Im Folgenden findest du alle Informationen zur Installation und zum Aufbau.

## Voraussetzungen

PHP, composer und Node.js bzw. npm werden benötigt.

## Installation

Nachdem das Projekt mit Git geklont wurde und das Projektverzeichnis aufgerufen wurde, müssen die Composer- und npm-Abhängigkeiten installiert werden. Anschließend kann der Build-Prozess gestartet werden. Dafür werden folgende Befehle verwendet:

```bash
composer install
npm install
npm run build
```

Für die .env-Datei mit allen umgebungsspezifischen Werten kann die .env.example-Datei verwendet werden, da keine besonderen Konfigurationen erforderlich sind.

```bash
cp .env.example .env
```

Applikation key setzen:

```bash
php artisan key:generate
```

Als Datenbank wurde SQLite verwendet und die Datenbank wurde dem Git Repo hinzugefügt um den Installationsaufwand zu begrenzen. Falls eine andere Datenbank genutzt werden soll, sind dies die Befehle um sie aufzusetzen und zu befüllen:

 ```bash
php artisan migrate
php artisan db:seed
```

Der Development-Server kann wie folgt gestartet werden und ist dann unter http://localhost:8000/ erreichbar:

```bash
php artisan serve
```

## Backend

Für das Backend wurde Laravel 11 genutzt. Die Erstellung der benötigten Klassen erfolgte, soweit möglich, mit Artisan. 

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

Das Frontend wurde mit Vue.js, Pinia für das State Management, Tailwind CSS als Framework und DaisyUI als Komponentenbibliothek entwickelt.

Die wichtigsten Dateien befinden sich unter:

- **Components** -> `\resources\js\components`
- **Store** -> `\resources\js\stores`
- **Router** -> `\resources\js\router`

In der Ärzteübersicht, kann ein Arzt angeklickt werden und man kommt in die Detailansicht in der die Sprechzeiten (TimeSlots) und Termine (Appointments) angezeigt werden. Die Termine können gebucht werden. Eine Fehlermeldung wird ausgelöst, wenn der Patientenname weniger als drei Zeichen enthält. Die Validierung erfolgt aktuell im Backend. Idealerweise sollte die Validierung bereits im Frontend stattfinden, dies wurde jedoch aus Zeitgründen nicht umgesetzt. Im oberen linken Menü können die gebuchten Termine aufgerufen und storniert werden. Ein User Account existiert nicht, so dass ein Reload der Seite dazu führt, dass die gebuchten Termine nicht mehr angezeigt werden, da sie nicht dem aktuellen User zugeordnet werden.

![Fehler](/readme_images/detail-page.png)

![Gebuchte Termine](/readme_images/booked-appointments.png)

## Tests

Die Tests befinden sich im Verzeichnis /tests. Es gibt Unit-Tests für das Doctor-Model und die zugehörigen Relationen sowie einige Feature-Tests für die Doctor- und Appointment-APIs. Die Tests werden mit folgendem Befehl aufgerufen:

 ```bash
php artisan test
```

![Tests](/readme_images/tests.png)

## Bonusaufgaben

### Verfügbarkeitsprüfung

Die Methode "checkAppointmentAvailability" aktualisiert alle 10 Sekunden die Informationen zu einer Detailseite eines Doktors. Aus Zeitgründen wurde darauf verzichtet, nur die Appointments zu aktualisieren.

### Suche

Die Suche wurde so aufgesetzt, dass nach Fachgebieten gesucht werden kann. Die Suche erfolgt der Einfachheit halber mit einer einfachen SQL Abfrage, die im entsprechenden Repository liegt. Die beteiligten Klassen sind:

- **Controller** -> \app\Http\Controllers\DoctorSearchController.php
- **Repository Interface** -> \app\Repositories\DoctorRepositoryInterface.php
- **Repository** -> \app\Repositories\DoctorRepository.php

### eMail Benachrichtigung

Bei der Buchung eines Termins wird eine E-Mail-Benachrichtigung versendet. Diese erfolgt asynchron über eine Queue, um die Anfragen so schnell wie möglich zu bearbeiten. Die Queue kann mit folgendem Befehl gestartet werden:

 ```bash
php artisan queue:work
```

Die Mails werden dem Logfile hinzugefügt. Dieses liegt unter "\storage\logs\laravel.log".