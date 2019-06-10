<?php

namespace Rooxie;

use Rooxie\Exception\MovieNotFoundException;
use Rooxie\Model\Movie;
use Rooxie\Exception\ApiErrorException;
use Rooxie\Exception\InvalidApiKeyException;
use Rooxie\Exception\IncorrectImdbIdException;
use Rooxie\Exception\InvalidResponseException;

/**
 * A PHP wrapper for OMDb API.
 *
 * @author  Roman Derlemenko <romanderlemenko@gmail.com>
 * @license MIT License
 * @link    https://github.com/rooxie/omdb
 */
class OMDb
{
    public const API_VERSION    = 1;
    public const API_URL        = 'http://www.omdbapi.com';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * OMDb constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get movie by IMDb ID.
     *
     * @param string $imdbId
     *
     * @return Movie
     *
     * @throws ApiErrorException
     * @throws IncorrectImdbIdException
     * @throws InvalidApiKeyException
     * @throws InvalidResponseException
     * @throws MovieNotFoundException
     */
    public function getByImdbId(string $imdbId): Movie
    {
        return $this->createMovieObject(
            $this->parseResponse('i', $imdbId, '', 0, 0)
        );
    }

    /**
     * Get movie by title, type and year.
     *
     * @param string $title
     * @param string $type
     * @param int    $year
     *
     * @return Movie
     *
     * @throws ApiErrorException
     * @throws IncorrectImdbIdException
     * @throws InvalidApiKeyException
     * @throws InvalidResponseException
     * @throws MovieNotFoundException
     */
    public function getByTitle(string $title, string $type = '', int $year = 0): Movie
    {
        return $this->createMovieObject(
            $this->parseResponse('t', $title, $type, $year, 0)
        );
    }

    /**
     * Search movies by title, type and year.
     *
     * @param string $title
     * @param string $type
     * @param int    $year
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiErrorException
     * @throws IncorrectImdbIdException
     * @throws InvalidApiKeyException
     * @throws InvalidResponseException
     * @throws MovieNotFoundException
     */
    public function search(string $title, string $type = '', int $year = 0, int $page = 1): array
    {
        return $this->parseResponse('s', $title, $type, $year, $page);
    }

    /**
     * @param string $getBy
     * @param string $value
     * @param string $type
     * @param int    $year
     * @param int    $page
     *
     * @return array
     *
     * @throws ApiErrorException
     * @throws IncorrectImdbIdException
     * @throws InvalidApiKeyException
     * @throws InvalidResponseException
     * @throws MovieNotFoundException
     */
    protected function parseResponse(string $getBy, string $value, string $type, int $year, int $page): array
    {
        $params = [$getBy => $value];

        if ($type) {
            $params['type'] = $type;
        }

        if ($year) {
            $params['y'] = $year;
        }

        if ($page) {
            $params['page'] = $page;
        }

        $response = $this->httpGet($params);
        $httpCode = $response['Info']['http_code'];

        if (empty($response['Decoded']['Response'])) {
            throw new InvalidResponseException($httpCode, $value, $response['Output']);
        }

        if ($response['Decoded']['Response'] === 'False') {
            switch ($response['Decoded']['Error']) {
                case InvalidApiKeyException::API_MESSAGE_INVALID_KEY:
                case InvalidApiKeyException::API_MESSAGE_NO_KEY_PROVIDED:
                    throw new InvalidApiKeyException($httpCode, $this->apiKey);
                case IncorrectImdbIdException::API_MESSAGE_INCORRECT_IMDB_ID:
                case IncorrectImdbIdException::API_MESSAGE_VARCHHAR_CONVERT:
                    throw new IncorrectImdbIdException($httpCode, $value);
                case MovieNotFoundException::API_MESSAGE_NOT_FOUND_KEY:
                    throw new MovieNotFoundException($httpCode, $value);
                default:
                    throw new ApiErrorException($httpCode, $value, $response['Decoded']['Error']);
            }
        }

        return $response['Decoded'];
    }

    /**
     * Perform an HTTP GET request to fetch data from OMDb API.
     *
     * @param array $params
     *
     * @return array
     */
    protected function httpGet(array $params): array
    {
        $query = http_build_query(array_merge($params, [
            'v' => self::API_VERSION,
            'r' => 'json',
        ]));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, sprintf('%s?apikey=%s&%s', self::API_URL, $this->apiKey, $query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $info   = curl_getinfo($ch);

        curl_close($ch);

        return [
            'Output'    => $output,
            'Info'      => $info,
            'Decoded'   => json_decode($output, true),
        ];
    }

    /**
     * Create movie class object from decoded response.
     *
     * @param array $data
     *
     * @return Movie
     */
    protected function createMovieObject(array $data): Movie
    {
        $rottenTomatoesRating = 0;

        foreach ($data['Ratings'] as $rating) {
            if ($rating['Source'] === 'Rotten Tomatoes') {
                $rottenTomatoesRating = intval($rating['Value']);
                break;
            }
        }

        return new Movie(
            $data['imdbID'],
            $data['Title'],
            $data['Year'],
            $data['Rated'],
            $data['Released'],
            intval($data['Runtime']),
            explode(', ', $data['Genre']),
            explode(', ', $data['Director']),
            explode(', ', $data['Writer']),
            explode(', ', $data['Actors']),
            $data['Plot'],
            explode(', ', $data['Language']),
            explode(', ', $data['Country']),
            $data['Awards'],
            $data['Poster'],
            $data['Type'],
            $data['DVD'] ?? 'N/A',
            $data['BoxOffice'] ?? 'N/A',
            $data['Production'] ?? 'N/A',
            $data['Website'] ?? 'N/A',
            $data['Metascore'] === 'N/A' ? 0 : $data['Metascore'],
            $rottenTomatoesRating,
            floatval($data['imdbRating']),
            intval(str_replace(',', '', $data['imdbVotes'])),
            $data['totalSeasons'] ?? 'N/A',
            $data['seriesID'] ?? 'N/A',
            $data['Season'] ?? 'N/A',
            $data['Episode'] ?? 'N/A'
        );
    }
}
