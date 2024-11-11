# Testaufgabe Telemedizin

Im Folgendem alle Informationen zur Installation und zum Aufbau.

## Installation

Nachdem das Projekt mit git geklont wurde, müssen composer und npm Dependencies installiert werden. Danach kann der Buildprozess aufgerufen werden. Dafür werden folgende Befehle verwendet:

```bash
composer install
npm install
npm run build
```

Achtung: Die ".env" wurde dem Repository hinzugefügt. Dies ist natürlich nicht üblich und wäre in anderen Projekten sicherheitskritisch, dient hier aber der erleichterten Installation.

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

## Frontend

Frontend.

## Tests

Tests.

## Bonusaufgaben

### Verfügbarkeitsprüfung

### Suche

### eMail Benachrichtigung

