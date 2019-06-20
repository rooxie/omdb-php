<?php

namespace Rooxie\Tests;

use PHPUnit\Framework\Error\Notice;
use Rooxie\Model\Movie;

class MovieModelTest extends BaseTest
{
    /**
     * Test successful creation of a Movie object.
     */
    public function testCreateTitlePositive()
    {
        $this->positiveCreateTitleTest($this->sample('titles.movie'));
        $this->positiveCreateTitleTest($this->sample('titles.series'));
        $this->positiveCreateTitleTest($this->sample('titles.episode'));
    }

    /**
     * Test unsuccessful creation of a Movie object.
     */
    public function testCreateTitleNegative()
    {
        $this->negativeCreateTitleTest($this->sample('titles.movie'));
        $this->negativeCreateTitleTest($this->sample('titles.series'));
        $this->negativeCreateTitleTest($this->sample('titles.episode'));
    }

    /**
     * Helper method for successful tests.
     *
     * @param array $title
     */
    private function positiveCreateTitleTest(array $title): void
    {
        $movie = $this->invokeOmdbMethod('createMovieObject', [$title]);

        $this->assertEquals(Movie::class, get_class($movie));
        $this->validateResults($movie, $title);
    }

    /**
     * Helper method for unsuccessful tests.
     *
     * @param array $title
     */
    private function negativeCreateTitleTest(array $title): void
    {
        $got        = [];
        $expected   = [
            'imdbID',
            'Title',
            'Year',
            'Rated',
            'Released',
            'Runtime',
            'Genre',
            'Director',
            'Writer',
            'Actors',
            'Plot',
            'Language',
            'Country',
            'Awards',
            'Poster',
            'Type',
            'imdbRating',
        ];

        foreach ($expected as $key) {
            unset($title[$key]);
            try {
                $this->positiveCreateTitleTest($title);
            } catch (Notice $e) {
                $got[] = $key;
            }
        }

        $this->assertEquals($expected, $got);
    }

    /**
     * Compare movie data with the data from the created model.
     *
     * @param Movie $movie
     * @param array $data
     */
    private function validateResults(Movie $movie, array $data): void
    {
        $rottenTomatoesRating = 0;

        foreach ($data['Ratings'] as $rating) {
            if ($rating['Source'] === 'Rotten Tomatoes') {
                $rottenTomatoesRating = intval($rating['Value']);
                break;
            }
        }

        $this->assertMovieModel($movie, [
            'ImdbId'                => $data['imdbID'],
            'Title'                 => $data['Title'],
            'Year'                  => $data['Year'],
            'Rated'                 => $data['Rated'],
            'Released'              => $data['Released'],
            'Runtime'               => intval($data['Runtime']),
            'Genre'                 => explode(', ', $data['Genre']),
            'Director'              => explode(', ', $data['Director']),
            'Writer'                => explode(', ', $data['Writer']),
            'Actors'                => explode(', ', $data['Actors']),
            'Plot'                  => $data['Plot'],
            'Language'              => explode(', ', $data['Language']),
            'Country'               => explode(', ', $data['Country']),
            'Awards'                => $data['Awards'],
            'Poster'                => $data['Poster'],
            'Type'                  => $data['Type'],
            'DVD'                   => $data['DVD'] ?? 'N/A',
            'BoxOffice'             => $data['BoxOffice'] ?? 'N/A',
            'Production'            => $data['Production'] ?? 'N/A',
            'Website'               => $data['Website'] ?? 'N/A',
            'Metascore'             => $data['Metascore'] === 'N/A' ? 0 : $data['Metascore'],
            'RottenTomatoesRating'  => $rottenTomatoesRating,
            'IMDbRating'            => floatval($data['imdbRating']),
            'IMDbVotes'             => intval(str_replace(',', '', $data['imdbVotes'])),
            'TotalSeasons'          => $data['totalSeasons'] ?? 'N/A',
            'SeriesID'              => $data['seriesID'] ?? 'N/A',
            'Season'                => $data['Season'] ?? 'N/A',
            'Episode'               => $data['Season'] ?? 'N/A',
        ]);

        $toArray = $movie->toArray();
        $getters = array_filter(get_class_methods($movie), function (string $name) {
            return substr($name, 0, 3) === "get";
        });

        $this->assertEquals(count($toArray), count($getters));
        $this->assertMovieModel($movie, $toArray);
    }

    /**
     * @param Movie $movie
     * @param array $compare
     */
    private function assertMovieModel(Movie $movie, array $compare): void
    {
        $this->assertEquals($movie->getImdbId(), $compare['ImdbId']);
        $this->assertEquals($movie->getTitle(), $compare['Title']);
        $this->assertEquals($movie->getYear(), $compare['Year']);
        $this->assertEquals($movie->getRated(), $compare['Rated']);
        $this->assertEquals($movie->getReleased(), $compare['Released']);
        $this->assertEquals($movie->getRuntime(), $compare['Runtime']);
        $this->assertEquals($movie->getGenre(), $compare['Genre']);
        $this->assertEquals($movie->getDirector(), $compare['Director']);
        $this->assertEquals($movie->getWriter(), $compare['Writer']);
        $this->assertEquals($movie->getActors(), $compare['Actors']);
        $this->assertEquals($movie->getPlot(), $compare['Plot']);
        $this->assertEquals($movie->getLanguage(), $compare['Language']);
        $this->assertEquals($movie->getCountry(), $compare['Country']);
        $this->assertEquals($movie->getAwards(), $compare['Awards']);
        $this->assertEquals($movie->getPosterUrl(), $compare['Poster']);
        $this->assertEquals($movie->getType(), $compare['Type']);
        $this->assertEquals($movie->getDvd(), $compare['DVD']);
        $this->assertEquals($movie->getBoxOffice(), $compare['BoxOffice']);
        $this->assertEquals($movie->getProduction(), $compare['Production']);
        $this->assertEquals($movie->getWebsite(), $compare['Website']);
        $this->assertEquals($movie->getMetascore(), $compare['Metascore']);
        $this->assertEquals($movie->getRottenTomatoesRating(), $compare['RottenTomatoesRating']);
        $this->assertEquals($movie->getImdbRating(), $compare['IMDbRating']);
        $this->assertEquals($movie->getImdbVotes(), $compare['IMDbVotes']);
        $this->assertEquals($movie->getTotalSeasons(), $compare['TotalSeasons']);
        $this->assertEquals($movie->getSeriesImdbId(), $compare['SeriesID']);
        $this->assertEquals($movie->getSeason(), $compare['Season']);
        $this->assertEquals($movie->getEpisode(), $compare['Episode']);
    }
}
