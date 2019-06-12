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
        $params     = $this->buildParams('i', $imdbId, '', 0, 0);
        $response   = $this->httpGet($params);
        $parsed     = $this->parseResponse($response);

        return $this->createMovieObject($parsed);
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
        $params     = $this->buildParams('t', $title, $type, $year, 0);
        $response   = $this->httpGet($params);
        $parsed     = $this->parseResponse($response);

        return $this->createMovieObject($parsed);
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
        $params     = $this->buildParams('s', $title, $type, $year, $page);
        $response   = $this->httpGet($params);

        return $this->parseResponse($response);
    }

    /**
     * Prepare request params for CURL HTTP request.
     *
     * @param string $getBy
     * @param string $value
     * @param string $type
     * @param int    $year
     * @param int    $page
     *
     * @return array
     */
    protected function buildParams(string $getBy, string $value, string $type, int $year, int $page): array
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

        return $params;
    }

    /**
     * Parse fetched response and check for errors.
     *
     * @param array $response
     *
     * @return array
     *
     * @throws ApiErrorException
     * @throws IncorrectImdbIdException
     * @throws InvalidApiKeyException
     * @throws InvalidResponseException
     * @throws MovieNotFoundException
     */
    protected function parseResponse(array $response): array
    {
        $value = array_values($response['Params'])[0];
        $array = json_decode($response['Response'], true);

        if (empty($array['Response'])) {
            throw new InvalidResponseException($value, $response['Response']);
        }

        if ($array['Response'] === 'False') {
            switch ($array['Error']) {
                case InvalidApiKeyException::API_MESSAGE_INVALID_KEY:
                case InvalidApiKeyException::API_MESSAGE_NO_KEY_PROVIDED:
                    throw new InvalidApiKeyException($this->apiKey);
                case IncorrectImdbIdException::API_MESSAGE_INCORRECT_IMDB_ID:
                case IncorrectImdbIdException::API_MESSAGE_VARCHHAR_CONVERT:
                    throw new IncorrectImdbIdException($value);
                case MovieNotFoundException::API_MESSAGE_NOT_FOUND_KEY:
                    throw new MovieNotFoundException($value);
                default:
                    throw new ApiErrorException($value, $array['Error']);
            }
        }

        return $array;
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

        $response   = curl_exec($ch);
        $info       = curl_getinfo($ch);

        curl_close($ch);

        return [
            'Params'    => $params,
            'Response'  => $response,
            'Info'      => $info,
        ];
    }

    /**
     * Creates movie class instance from the decoded response.
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
