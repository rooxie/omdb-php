# OMDb API PHP Wrapper

## Introduction
A PHP wrapper for [OMDb](http://www.omdbapi.com/) API with [PSR-17 HTTP Factories](https://www.php-fig.org/psr/psr-17/) and [PSR-18 HTTP Client](https://www.php-fig.org/psr/psr-18/).

## Prerequisites
* PHP >= `8.1`
* Any PSR-17 and PSR-18 compatible HTTP client

## Installation
Install [`omdb-php`](http://packagist.org/packages/rooxie/omdb) using [Composer](https://getcomposer.org/).
```bash
# Install the package
composer require rooxie/omdb

# Install the PSR-17 and PSR-18 implementations
composer require guzzlehttp/guzzle
```

## Usage
*Create an instace of `OMDb` class, providing the API key as the constructor argument*
```php
$omdb = new Rooxie\OMDb(
    new \GuzzleHttp\Client(),
    new \GuzzleHttp\Psr7\HttpFactory(),
    'your-api-key'
);
```

#### Get title by IMDb ID
*One gets an instance of `Movie` model class after fetching movie data vit HTTP request*
```php
$movie = $omdb->getByImdbId('tt0110912');
// {"Title":"Pulp Fiction","Year":"1994","Rated":"R","Released":"14 Oct 1994" ...
echo $movie->getBody()->getContents();
```

#### Get by title and other optional arguments
*Same goes for fetching data using movie title. One can also provide optional arguments such as movie type (`movie`, `series` or `episode`) and the release year*
```php
$movie = $omdb->getByTitle('harry potter', \Rooxie\Enum\TitleType::MOVIE, 2004);
// {"Title":"Harry Potter and the Prisoner of Azkaban","Year":"2004","Rated":"PG","Released":"04 Jun 2004" ...
echo $movie->getBody()->getContents();
```

#### Search by title and other optional arguments
*Movie search method returns a raw array from the API response and has an optional pagination parameter as the last argument*
```php
$movies = $omdb->search('arrival', \Rooxie\Enum\TitleType::MOVIE, 2016, 1)->getBody()->getContents();
print_r(json_decode($movies, true));
```
```text
Array
(
    [Search] => Array
        (
            [0] => Array
                (
                    [Title] => Arrival
                    [Year] => 2016
                    [imdbID] => tt2543164
                    [Type] => movie
                    [Poster] => https://m.media-amazon.com/images/M/MV5BMTExMzU0ODcxNDheQTJeQWpwZ15BbWU4MDE1OTI4MzAy._V1_SX300.jpg
                )

            [1] => Array
                (
                    [Title] => Alien Arrival
                    [Year] => 2016
                    [imdbID] => tt3013160
                    [Type] => movie
                    [Poster] => https://m.media-amazon.com/images/M/MV5BMjE5ODg2MTUtMDQ3Ny00MjA2LWJmZjMtYThlNTY3NGJhZmI2XkEyXkFqcGdeQXVyMjA4MDYxNDk@._V1_SX300.jpg
                )

            [2] => Array
                (
                    [Title] => The Arrival
                    [Year] => 2016
                    [imdbID] => tt5623378
                    [Type] => movie
                    [Poster] => https://images-na.ssl-images-amazon.com/images/M/MV5BNTMyMDRhODgtOTE4Yi00MGI5LTllMDUtNThhYWM0ZGVhZTg1XkEyXkFqcGdeQXVyNjQ2NzI0Mw@@._V1_SX300.jpg
                )

            [3] => Array
                (
                    [Title] => Arrival
                    [Year] => 2016
                    [imdbID] => tt5433758
                    [Type] => movie
                    [Poster] => https://images-na.ssl-images-amazon.com/images/M/MV5BMTNiMDRlMDQtZTVkNS00MWVhLWFiOGUtMTkxNTgzODBkMWIyXkEyXkFqcGdeQXVyMjMxMTU4MzA@._V1_SX300.jpg
                )

            [4] => Array
                (
                    [Title] => The Arrival of the Train at a Subway Station in Vienna
                    [Year] => 2016
                    [imdbID] => tt5972896
                    [Type] => movie
                    [Poster] => https://images-na.ssl-images-amazon.com/images/M/MV5BMGVlY2MwYWUtODE1Zi00NGNjLWJjMDgtM2M0ZmJmYTFmMWM4XkEyXkFqcGdeQXVyNDcwNDE0Nzk@._V1_SX300.jpg
                )

            [5] => Array
                (
                    [Title] => Arrival: Common Ground
                    [Year] => 2016
                    [imdbID] => tt6196852
                    [Type] => movie
                    [Poster] => https://images-na.ssl-images-amazon.com/images/M/MV5BMTE4ZjA0MjctNmY0Yy00OWE2LTk1ZTItZmViZDg3ODQwY2NjL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMzM2MjIzNA@@._V1_SX300.jpg
                )

            [6] => Array
                (
                    [Title] => The Arrival
                    [Year] => 2016
                    [imdbID] => tt5678770
                    [Type] => movie
                    [Poster] => N/A
                )

            [7] => Array
                (
                    [Title] => Dead on Arrival
                    [Year] => 2016
                    [imdbID] => tt5175144
                    [Type] => movie
                    [Poster] => N/A
                )

            [8] => Array
                (
                    [Title] => Arrival of a Train At
                    [Year] => 2016
                    [imdbID] => tt5333154
                    [Type] => movie
                    [Poster] => http://ia.media-imdb.com/images/M/MV5BY2M2YWYyMDUtNGM5MC00Y2YwLTkzZWEtNzgzOGEzYTQxYmQwXkEyXkFqcGdeQXVyNjQ3Mjc0Nzg@._V1_SX300.jpg
                )

            [9] => Array
                (
                    [Title] => Arrival of Their Majesties the Emperor and Empress of Japan
                    [Year] => 2016
                    [imdbID] => tt5378228
                    [Type] => movie
                    [Poster] => N/A
                )

        )

    [totalResults] => 10
    [Response] => True
)
```

### Error Handling
Error handling fully depends on the PSR-18 HTTP client implementation. One can catch exceptions thrown by the HTTP client and handle them accordingly.
