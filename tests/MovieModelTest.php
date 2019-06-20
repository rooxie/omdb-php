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
        $this->assertMovieModel($movie, $title);
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
    private function assertMovieModel(Movie $movie, array $data): void
    {
        $rottenTomatoesRating = 0;

        foreach ($data['Ratings'] as $rating) {
            if ($rating['Source'] === 'Rotten Tomatoes') {
                $rottenTomatoesRating = intval($rating['Value']);
                break;
            }
        }

        $this->assertEquals($movie->getImdbId(), $data['imdbID']);
        $this->assertEquals($movie->getTitle(), $data['Title']);
        $this->assertEquals($movie->getYear(), $data['Year']);
        $this->assertEquals($movie->getRated(), $data['Rated']);
        $this->assertEquals($movie->getReleased(), $data['Released']);
        $this->assertEquals($movie->getRuntime(), intval($data['Runtime']));
        $this->assertEquals($movie->getTitle(), $data['Title']);
        $this->assertEquals($movie->getGenre(), explode(', ', $data['Genre']));
        $this->assertEquals($movie->getDirector(), explode(', ', $data['Director']));
        $this->assertEquals($movie->getWriter(), explode(', ', $data['Writer']));
        $this->assertEquals($movie->getActors(), explode(', ', $data['Actors']));
        $this->assertEquals($movie->getPlot(), $data['Plot']);
        $this->assertEquals($movie->getLanguage(), explode(', ', $data['Language']));
        $this->assertEquals($movie->getCountry(), explode(', ', $data['Country']));
        $this->assertEquals($movie->getAwards(), $data['Awards']);
        $this->assertEquals($movie->getPosterUrl(), $data['Poster']);
        $this->assertEquals($movie->getType(), $data['Type']);
        $this->assertEquals($movie->getDvd(), $data['DVD'] ?? 'N/A');
        $this->assertEquals($movie->getBoxOffice(), $data['BoxOffice'] ?? 'N/A');
        $this->assertEquals($movie->getProduction(), $data['Production'] ?? 'N/A');
        $this->assertEquals($movie->getWebsite(), $data['Website'] ?? 'N/A');
        $this->assertEquals($movie->getMetascore(), $data['Metascore'] === 'N/A' ? 0 : $data['Metascore']);
        $this->assertEquals($movie->getRottenTomatoesRating(), $rottenTomatoesRating);
        $this->assertEquals($movie->getImdbRating(), floatval($data['imdbRating']));
        $this->assertEquals($movie->getImdbVotes(), intval(str_replace(',', '', $data['imdbVotes'])));
        $this->assertEquals($movie->getTotalSeasons(), $data['totalSeasons'] ?? 'N/A');
        $this->assertEquals($movie->getSeriesImdbId(), $data['seriesID'] ?? 'N/A');
        $this->assertEquals($movie->getSeason(), $data['Season'] ?? 'N/A');
        $this->assertEquals($movie->getEpisode(), $data['Episode'] ?? 'N/A');
    }
}
