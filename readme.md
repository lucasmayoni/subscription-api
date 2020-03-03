## MSISDN Subscription API

#### Instalación

- git clone https://github.com/lucasmayoni/subscription-api.git
- mv .env.example .env
- Completar los datos de conexion de la Base de Datos
- composer install (requieres PHP^7.1)
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

#### Uso API

##### Agregar una subscripcion
```
curl -X POST \
  https://local.subscription-api.com/api/subscription/ \
  -H 'accept: application/json' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
  -H 'postman-token: 6c344e25-e755-445f-7f8c-c0613c29c369' \
  -d 'msisdn=%2B54123457877&service=*2020&insert_date=2020-03-01'
```
```
curl -X DELETE \
  https://local.subscription-api.com/api/subscription/ \
  -H 'accept: application/json' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
  -H 'postman-token: 967b8a4c-9de4-4a44-47cc-7b5d0c9b3019' \
  -d 'msisdn=%2B54123456789&service=OnlineTopUp'
```
> Tanto el MSISDN como el Service deben figurar en la tabla Subscriber y Service respectivamente

#### Ejecucion del comando artisan
``` 
php artisan generate:report --date={date}
```

> {date} debe ser la fecha en formato YYYY-MM-DD y solo se insertara la informacion si la misma no existe
