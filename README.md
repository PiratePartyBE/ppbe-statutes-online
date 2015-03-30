# ppbe-statutes-online

Website for the PPBE statutes.

## Installation

Install php librarie using composer.

```
cd ppbe-statutes-online
composer update
```

Install javascript and css usin bower

```
cd web
bower install
```

## Run the server

```
cd web
php -S localhost:8001
```

And go to localhost:8001 in your web browser.

Go to localhost:8001/index_dev.php for the development/debug version.

## Features to implement next

* Use caching for the GitHub files
* Use GitHub API to retrieve the statutes
* Cache the generated HTML
* Generate the TOC on the server side
