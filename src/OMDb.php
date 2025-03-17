<?php

/*
 * This file is part of rooxie/omdb.
 *
 * (c) Roman Derlemenko <romanderlemenko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rooxie;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Rooxie\Enum\ResponseFormat;
use Rooxie\Enum\TitleType;

/**
 * A PHP wrapper for OMDb API.
 *
 * @author  Roman Derlemenko <romanderlemenko@gmail.com>
 * @license MIT License
 * @link    https://github.com/rooxie/omdb
 */
class OMDb
{
    /**
     * OMDb API host.
     *
     * @var string
     */
    protected string $host = 'http://www.omdbapi.com';

    /**
     * OMDb API version.
     *
     * @var int
     */
    protected int $version = 1;

    /**
     * OMDb API response return type.
     *
     * @var ResponseFormat
     */
    public ResponseFormat $returnType = ResponseFormat::JSON;

    /**
     * OMDb constructor.
     *
     * @param ClientInterface $client
     * @param RequestFactoryInterface $requestFactory
     */
    public function __construct(
        protected ClientInterface $client,
        protected RequestFactoryInterface $requestFactory,
        protected string $apiKey
    ) {
        //
    }

    /**
     * Get movie by IMDb ID.
     *
     * @param string $imdbId
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function getByImdbId(string $imdbId): ResponseInterface
    {
        $uri = $this->buildUri('i', $imdbId);
        $request = $this->requestFactory->createRequest('GET', $uri);
        $response = $this->client->sendRequest($request);
        return $response;
    }

    /**
     *  Get movie by title, type and year.
     *
     * @param string $title
     * @param TitleType|null $type
     * @param int $year
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function getByTitle(string $title, TitleType|null $type = null, int $year = 0): ResponseInterface
    {
        $uri = $this->buildUri('t', $title, $type, $year);
        $request = $this->requestFactory->createRequest('GET', $uri);
        $response = $this->client->sendRequest($request);
        return $response;
    }

    /**
     * Search movies by title, type and year.
     *
     * @param string $title
     * @param TitleType|null $type
     * @param int $year
     * @param int $page
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function search(string $title, TitleType|null $type = null, int $year = 0, int $page = 1): ResponseInterface
    {
        $uri = $this->buildUri('s', $title, $type, $year, $page);
        $request = $this->requestFactory->createRequest('GET', $uri);
        $response = $this->client->sendRequest($request);
        return $response;
    }

    /**
     * Prepare request params for CURL HTTP request.
     *
     * @param string $getBy
     * @param string $value
     * @param TitleType|null $type
     * @param int $year
     * @param int $page
     * @return string
     */
    protected function buildUri(string $getBy, string $value, TitleType|null $type = null, int $year = 0, int $page = 0): string
    {
        $params = [
            'r' => strtolower($this->returnType->name),
            'apikey' => $this->apiKey,
            $getBy => $value,
        ];
        if ($type) {
            $params['type'] = strtolower($type->name);
        }
        if ($year) {
            $params['y'] = $year;
        }
        if ($page) {
            $params['page'] = $page;
        }

        return $this->host . '/?' . http_build_query($params);
    }
}
