<?php

namespace Rooxie\Model;

/**
 * Class Movie
 */
class Movie
{
    /**
     * @var string
     *
     * @example "tt0241527"
     */
    protected $imdbId;

    /**
     * @var string
     *
     * @example "Harry Potter and the Sorcerer's Stone"
     */
    protected $title;

    /**
     * @var string
     *
     * @example "2001"
     */
    protected $year;

    /**
     * @var string
     *
     * @example "PG"
     */
    protected $rated;

    /**
     * @var string
     *
     * @example "16 Nov 2001"
     */
    protected $released;

    /**
     * @var int
     *
     * @example 152
     */
    protected $runtime;

    /**
     * @var string[]
     *
     * @example ["Adventure", "Family", "Fantasy"]
     */
    protected $genre;

    /**
     * @var string[]
     *
     * @example ["Chris Columbus"]
     */
    protected $director;

    /**
     * @var string[]
     *
     * @example ["J.K. Rowling (novel)", "Steve Kloves (screenplay)"]
     */
    protected $writer;

    /**
     * @var string[]
     *
     * @example ["Richard Harris", "Maggie Smith", "Robbie Coltrane", "Saunders Triplets"]
     */
    protected $actors;

    /**
     * @var string
     *
     * @example "An orphaned boy enrolls in a school of wizardry, where he learns the truth about himself, his fam..."
     */
    protected $plot;

    /**
     * @var string[]
     *
     * @example ["English"]
     */
    protected $language;

    /**
     * @var string[]
     *
     * @example ["UK", "USA"]
     */
    protected $country;

    /**
     * @var string
     *
     * @example "Nominated for 3 Oscars. Another 17 wins & 62 nominations."
     */
    protected $awards;

    /**
     * @var string
     *
     * @example "https://m.media-amazon.com/images/M/MV5BNjQ3NWNlNmQtMTE5ZS00MDdmLTlkZjUtZTBlM2UxMGFiMTU3XkEyXkFqcGdeQXVyNjUwNzk3NDc@._V1_SX300.jpg"
     */
    protected $posterUrl;

    /**
     * @var string
     *
     * @example "movie"
     */
    protected $type;

    /**
     * @var string
     *
     * @example "28 May 2002"
     */
    protected $dvd;

    /**
     * @var ?int
     *
     * @example "$317,557,891"
     */
    protected $boxOffice;

    /**
     * @var string
     *
     * @example "Warner Bros. Pictures"
     */
    protected $production;

    /**
     * @var string
     *
     * @example "http://movies.warnerbros.com/awards/harry.html"
     */
    protected $website;

    /**
     * @var int
     *
     * @example 64
     */
    protected $metascore;

    /**
     * @var int
     *
     * @example 81
     */
    protected $rottenTomatoesRating;

    /**
     * @var float
     *
     * @example 7.6
     */
    protected $imdbRating;

    /**
     * @var int
     *
     * @example 568931
     */
    protected $imdbVotes;

    /**
     * @var string
     *
     * @example "N/A"
     */
    protected $totalSeasons;

    /**
     * @var string
     *
     * @example "N/A"
     */
    protected $seriesImdbId;

    /**
     * @var string
     *
     * @example "N/A"
     */
    protected $season;

    /**
     * @var string
     *
     * @example "N/A"
     */
    protected $episode;

    /**
     * Movie constructor.
     *
     * @param string   $imdbId
     * @param string   $title
     * @param string   $year
     * @param string   $rated
     * @param string   $released
     * @param int      $runtime
     * @param string[] $genre
     * @param string[] $director
     * @param string[] $writer
     * @param string[] $actors
     * @param string   $plot
     * @param string[] $language
     * @param string[] $country
     * @param string   $awards
     * @param string   $posterUrl
     * @param string   $type
     * @param string   $dvd
     * @param string   $boxOffice
     * @param string   $production
     * @param string   $website
     * @param int      $metascore
     * @param int      $rottenTomatoesRating
     * @param float    $imdbRating
     * @param int      $imdbVotes
     * @param string   $totalSeasons
     * @param string   $seriesImdbId
     * @param string   $season
     * @param string   $episode
     */
    public function __construct(
        string $imdbId,
        string $title,
        string $year,
        string $rated,
        string $released,
        int $runtime,
        array $genre,
        array $director,
        array $writer,
        array $actors,
        string $plot,
        array $language,
        array $country,
        string $awards,
        string $posterUrl,
        string $type,
        string $dvd,
        string $boxOffice,
        string $production,
        string $website,
        int $metascore,
        int $rottenTomatoesRating,
        float $imdbRating,
        int $imdbVotes,
        string $totalSeasons,
        string $seriesImdbId,
        string $season,
        string $episode
    ) {
        $this->imdbId               = $imdbId;
        $this->title                = $title;
        $this->year                 = $year;
        $this->rated                = $rated;
        $this->released             = $released;
        $this->runtime              = $runtime;
        $this->genre                = $genre;
        $this->director             = $director;
        $this->writer               = $writer;
        $this->actors               = $actors;
        $this->plot                 = $plot;
        $this->language             = $language;
        $this->country              = $country;
        $this->awards               = $awards;
        $this->posterUrl            = $posterUrl;
        $this->type                 = $type;
        $this->dvd                  = $dvd;
        $this->boxOffice            = $boxOffice;
        $this->production           = $production;
        $this->website              = $website;
        $this->metascore            = $metascore;
        $this->rottenTomatoesRating = $rottenTomatoesRating;
        $this->imdbRating           = $imdbRating;
        $this->imdbVotes            = $imdbVotes;
        $this->totalSeasons         = $totalSeasons;
        $this->seriesImdbId         = $seriesImdbId;
        $this->season               = $season;
        $this->episode              = $episode;
    }

    /**
     * @return string
     */
    public function getImdbId(): string
    {
        return $this->imdbId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @return string
     */
    public function getRated(): string
    {
        return $this->rated;
    }

    /**
     * @return string
     */
    public function getReleased(): string
    {
        return $this->released;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string[]
     */
    public function getGenre(): array
    {
        return $this->genre;
    }

    /**
     * @return string[]
     */
    public function getDirector(): array
    {
        return $this->director;
    }

    /**
     * @return string[]
     */
    public function getWriter(): array
    {
        return $this->writer;
    }

    /**
     * @return string[]
     */
    public function getActors(): array
    {
        return $this->actors;
    }

    /**
     * @return string
     */
    public function getPlot(): string
    {
        return $this->plot;
    }

    /**
     * @return string[]
     */
    public function getLanguage(): array
    {
        return $this->language;
    }

    /**
     * @return string[]
     */
    public function getCountry(): array
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getAwards(): string
    {
        return $this->awards;
    }

    /**
     * @return string
     */
    public function getPosterUrl(): string
    {
        return $this->posterUrl;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDvd(): string
    {
        return $this->dvd;
    }

    /**
     * @return mixed
     */
    public function getBoxOffice(): string
    {
        return $this->boxOffice;
    }

    /**
     * @return string
     */
    public function getProduction(): string
    {
        return $this->production;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @return int
     */
    public function getMetascore(): int
    {
        return $this->metascore;
    }

    /**
     * @return int
     */
    public function getRottenTomatoesRating(): int
    {
        return $this->rottenTomatoesRating;
    }

    /**
     * @return float
     */
    public function getImdbRating(): float
    {
        return $this->imdbRating;
    }

    /**
     * @return int
     */
    public function getImdbVotes(): int
    {
        return $this->imdbVotes;
    }

    /**
     * @return string
     */
    public function getTotalSeasons(): string
    {
        return $this->totalSeasons;
    }

    /**
     * @return string
     */
    public function getSeriesImdbId(): string
    {
        return $this->seriesImdbId;
    }

    /**
     * @return string
     */
    public function getSeason(): string
    {
        return $this->season;
    }

    /**
     * @return string
     */
    public function getEpisode(): string
    {
        return $this->episode;
    }

    /**
     * Convert movie object to associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ImdbId'                => $this->imdbId,
            'Title'                 => $this->title,
            'Year'                  => $this->year,
            'Rated'                 => $this->rated,
            'Released'              => $this->released,
            'Runtime'               => $this->runtime,
            'Genre'                 => $this->genre,
            'Director'              => $this->director,
            'Writer'                => $this->writer,
            'Actors'                => $this->actors,
            'Plot'                  => $this->plot,
            'Language'              => $this->language,
            'Country'               => $this->country,
            'Awards'                => $this->awards,
            'Poster'                => $this->posterUrl,
            'Type'                  => $this->type,
            'DVD'                   => $this->dvd,
            'BoxOffice'             => $this->boxOffice,
            'Production'            => $this->production,
            'Website'               => $this->website,
            'Metascore'             => $this->metascore,
            'RottenTomatoesRating'  => $this->rottenTomatoesRating,
            'IMDbRating'            => $this->imdbRating,
            'IMDbVotes'             => $this->imdbVotes,
            'TotalSeasons'          => $this->totalSeasons,
            'SeriesID'              => $this->seriesImdbId,
            'Season'                => $this->season,
            'Episode'               => $this->episode,
        ];
    }
}
