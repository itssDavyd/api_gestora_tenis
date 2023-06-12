<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre el proyecto

Este proyecto esta enfocado a una gestoria de tenis la cual dispone de una api gestionada por JWT con la libreria de
autentificación de Laravel "Passport".

## Instalación componentes básicos

* composer create-project laravel/laravel api_gestora_tenis
* composer.json -> add "laravel/passport":"*" (Puedes gestionarse la version que se quiera esto al ser un test local
  lleva indiferente).
* composer update / install para actualizar y bajar las dependencias.
* Añadir en auth.php una estructura para la api la cual lleva como drivers -> passport para que la autentificación
  siempre tire de esta librería.
* Añadir routing en api.php (ojo posteriori a hacer el controller de User acordarse de poner en los que necesitas
  autorizacion para realizar la peticion el middleware(auth:api) para que gestione con la autentificacion siempre y
  poder usarla).

## Arranque de peticiones

* [Method=>POST][PARAMS=>JSON] http://apigestoratenis.com.devel/api/register
* [Method=>POST][PARAMS=>JSON] http://apigestoratenis.com.devel/api/login
* [Method=>GET][AUTH=>BEARER + TOKEN] http://apigestoratenis.com.devel/api/getAllUsersSystem
* [Method=>GET][AUTH=>BEARER + TOKEN] http://apigestoratenis.com.devel/api/logout

## Servicios

* Todo este servicio esta gestionado por XAMPP en un servidor Apache local + PHP.
* La base de datos de este proyecto esta realizada en PostgreSQL las conexiones se encuentran en el fichero .env

## PUERTOS

* 127.0.0.1 -> LOCALHOST (con un VirtualHost creado por eso se llama a www.apigestoratenis.com.devel)
* BDD->pg->5432
