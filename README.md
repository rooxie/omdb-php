# OMDb API PHP Wrapper

## Introduction
A PHP wrapper for [OMDb](http://www.omdbapi.com/) API with object-oriented approach and no dependencies.

## Prerequisites
* PHP >= 7.1
* PHP JSON extension
* PHP CURL extension

## Installation
Install **omdb-php** using [Composer](https://getcomposer.org/).

It is available on [Packagist](https://packagist.org/) as [`rooxie/omdb`](http://packagist.org/packages/rooxie/omdb) package:

```
composer require rooxie/omdb
```

## Quickstart
*Create an instace of `OMDb` class, providing the API key as the constructor argument*
```php
$omdb = new Rooxie\OMDb('xxxxxxx');
```

#### Get title by IMDb ID
*One gets an instance of `Movie` model class after fetching movie data vit HTTP request*
```php
$movie = $omdb->getByImdbId('tt0110912');

echo $movie->getTitle();        // Pulp Fiction
echo $movie->getReleased();     // 14 Oct 1994
echo $movie->getRuntime();      // 154
echo $movie->getImdbRating();   // 8.9
...
```

#### Get by title and other optional arguments
*Same goes for fetching data using movie title. One can also provide optional arguments such as movie type (`movie`, `series` or `episode`) and the release year*
```php
$movie = $omdb->getByTitle('harry potter', 'movie', 2004);

echo $movie->getTitle();        // Harry Potter and the Prisoner of Azkaban
echo $movie->getImdbId();       // tt0304141
echo $movie->getRated();        // PG
echo $movie->getMetascore();    // 82
...
```

*Each object also has a `$movie->toArray()` method*
```php
Array
(
    [ImdbId] => tt0246578
    [Title] => Donnie Darko
    [Year] => 2001
    [Rated] => R
    [Released] => 26 Oct 2001
    [Runtime] => 113
    [Genre] => Array
        (
            [0] => Drama
            [1] => Sci-Fi
            [2] => Thriller
        )

    [Director] => Array
        (
            [0] => Richard Kelly
        )

    [Writer] => Array
        (
            [0] => Richard Kelly
        )

    [Actors] => Array
        (
            [0] => Jake Gyllenhaal
            [1] => Holmes Osborne
            [2] => Maggie Gyllenhaal
            [3] => Daveigh Chase
        )

    [Plot] => A troubled teenager is plagued by visions of a man in a large rabbit suit who manipulates him to commit a series of crimes, after he narrowly escapes a bizarre accident.
    [Language] => Array
        (
            [0] => English
        )

    [Country] => Array
        (
            [0] => USA
        )

    [Awards] => 11 wins & 15 nominations.
    [Poster] => https://m.media-amazon.com/images/M/MV5BZjZlZDlkYTktMmU1My00ZDBiLWFlNjEtYTBhNjVhOTM4ZjJjXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_.jpg
    [Type] => movie
    [DVD] => 19 Mar 2002
    [BoxOffice] => N/A
    [Production] => Newmarket Film Group
    [Website] => http://www.donniedarko.com
    [Metascore] => 88
    [RottenTomatoesRating] => 87
    [IMDbRating] => 8.1
    [IMDbVotes] => 695608
    [TotalSeasons] => N/A
    [SeriesID] => N/A
    [Season] => N/A
    [Episode] => N/A
)
```

#### Search by title and other optional arguments
*Movie search method returns a raw array from the API response and has an optional pagination parameter as the last argument*
```php
$movies = $omdb->search('arrival', 'movie', 2016, 1);
```

*Result*
```php
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

#### Error Handling
The majority of basic errors have corresponding exceptions.

*Invalid API key*
```php
try {
    $movies = $omdb->getByTitle('a clockwork orange');
} catch (\Rooxie\Exception\InvalidApiKeyException $e) {
    echo $e->getMessage(); // Invalid API key "Invalid or missing API key"
}
```

*Movie not found*
```php
try {
    $movies = $omdb->getByTitle('zaqxswcde');
} catch (\Rooxie\Exception\MovieNotFoundException $e) {
    echo $e->getMessage(); // Could not find movie "zaqxswcde"
}
```

*Incorrect IMDb ID*
```php
try {
    $movies = $omdb->getByImdbId('gj349gj349gj34');
} catch (\Rooxie\Exception\IncorrectImdbIdException $e) {
    echo $e->getMessage(); // Incorrect IMDb ID "gj349gj349gj34"
}
```

Should the API return a value with a wrong format, the `InvalidResponseException` will be thrown.

In all the other cases the `ApiErrorException` will be thrown.