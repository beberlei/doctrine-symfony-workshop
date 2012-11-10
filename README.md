# Doctrine2 with Symfony2 Workshop

This repository hosts a Symfony2 application used for Doctrine2 workshops.
It is a derivation of the Symfony Standard Distribution that is explicitly
build for teaching Doctrine2 in a Symfony2 application.

## Installation

If you don't have Composer installed, go to: http://getcomposer.org/download/
Install Composer as described.

If you have Composer installed on your machine, go into your working directory
and call:

    composer create-project beberlei/doctrine-symfony-workshop doctrine-ws

This will create a new project with this application and download all the dependencies.

## Configuration

By default this example application will use SQLite as a database. To configure
another database to use during the workshop go to ``app/config/parameters.yml``
and change the configuration as explained in the file. You can uncomment
the specific sections for MySQL or PostgreSQL to change the database.

