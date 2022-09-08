
# Cordial Birthday API

This is a program that keeps track of people's birthdays and warns about upcoming birthdays. If their birthday is today,
the program should warn about the number of hours remaining until the end of a person's birthday, otherwise it should warn about the number
of months/days left until their next birthday.

## Prerequisites

This application requires a working knowledge of composer, github, PHP8+, and MongoDB. You will need to know the connection URI in order to configure this application.

## Installation

1. Clone this repository into a clean directory by running `gh repo clone mtimion/cordial`
2. Once inside of the directory, run `composer install`
3. Once installed, run `php artisan key:generate`
4. Copy the `.env.sample` file and rename it to `.env`
5. Edit the new `.env` file to have your MongoDB connection settings.
- the DB_URI should look like this: `mongodb://127.0.0.1:27017`

- the DB_DATABASE field should be a database you have already created on the MongoDB server.
6. In a terminal window, run `php -S localhost:8000 -t public`. This will host the application.

## How to use

### Creating a person
In order to create a person in the application, send a POST to `http://localhost:8000/person`.
The JSON request must contain three elements: name, birthdate, timezone. An example payload looks like this:
`{'name': 'Firstname Lastname', 'birthdate': '1776-07-04 12:34:56', 'timezone': 'America/New_York'}`

### Getting all records from application
In order to retrieve all people in the application, submit a GET request to `http://localhost:8000/person`. This will return all people in the database along with their associated birtday information.

