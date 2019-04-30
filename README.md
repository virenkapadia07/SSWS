#Project Description
Leave Management System and Lecture Arranagement
###Student
Students can apply for Half/Full Leave

###Faculty
Faculty can apply for Leave and Arranage their lectures with the help of system


#Modules(Users)

##There are total 6 Users
- Admin
- Student
- Faculty
- HOD
- Director
- Gatekeeper

**Framework:-** Laravel Framework 5.7.6


# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone git@github.com:virenkapadia07/SSWS.git

Switch to the repo folder

    cd laravel-realworld-example-app

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Import "college.sql" file in MySQL Database

Configure your database in .env file

Start the local development server

    php artisan serve

# Code overview

## Dependencies

- [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf) - For Genetrating PDF
- System must have **Python3 (with pandas libarary) installed**

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the auth middleware
- `app/Http/Requests/Api` - Contains all the api form requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature/Api` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.