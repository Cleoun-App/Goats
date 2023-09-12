# Goats - Aplikasi management perkambingan

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

### Tech

Qioee was built on top of technologies:

* [Laravel] - A Robust PHP Web Framework
* [Livewire] - Laravel Package That Provide Functionality Out Of The Box


### APIs entry point

List of basic APIs entry point

```sh

// Authentication APIs

$ */api/login/ -> parameter( phone_number, password )
$ */api/register/ -> parameter( name, email, phone_number, password)

```

### Installation

Install All Dependencies Package From Composer And NPM

```sh
$ composer install
$ npm install && npm run dev
```

After instalation completed you may need to run this commands

```sh
$ cp .env.example .env
$ php artisan key:generate
```

You may want to create database, setup the migration & much more..., instead of doing lots of thing, We offer you the abbility to achived this in a single command.

```sh   
$ php artisan app:init
```

The app will serve at [http://localhost:8000](http://localhost:8000)

### Generated accounts

| Name | Username | Email | Password |
| ------- | -------- | ------- | ------ |
| Admin | Admin | admin@mail.io | password |


   [Laravel]: <https://laravel.com/>
   [Livewire]: <https://laravel-livewire.com/>

   [PlDb]: <https://github.com/joemccann/dillinger/tree/master/plugins/dropbox/README.md>
   [PlGh]: <https://github.com/joemccann/dillinger/tree/master/plugins/github/README.md>
   [PlGd]: <https://github.com/joemccann/dillinger/tree/master/plugins/googledrive/README.md>
   [PlOd]: <https://github.com/joemccann/dillinger/tree/master/plugins/onedrive/README.md>
   [PlMe]: <https://github.com/joemccann/dillinger/tree/master/plugins/medium/README.md>
   [PlGa]: <https://github.com/RahulHP/dillinger/blob/master/plugins/googleanalytics/README.md>
