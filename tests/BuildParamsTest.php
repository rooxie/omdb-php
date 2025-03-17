<?php

/*
 * This file is part of rooxie/omdb.
 *
 * (c) Roman Derlemenko <romanderlemenko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rooxie\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Rooxie\Enum\ResponseFormat;
use Rooxie\Enum\TitleType;
use Rooxie\OMDb;

class BuildParamsTest extends TestCase
{
    protected OMDb $omdb;

    protected function setUp(): void
    {
        $this->omdb = new OMDb(
            $this->createStub(ClientInterface::class),
            $this->createStub(RequestFactoryInterface::class),
            'testapikey'
        );
    }

    protected function invokeBuildUri(string $getBy, string $value, ?TitleType $type = null, int $year = 0, int $page = 0): string
    {
        $reflection = new \ReflectionClass($this->omdb);
        $method = $reflection->getMethod('buildUri');
        $method->setAccessible(true);

        return $method->invoke($this->omdb, $getBy, $value, $type, $year, $page);
    }

    public function testBuildUriWithImdbId(): void
    {
        $uri = $this->invokeBuildUri('i', 'tt1234567');
        $expected = 'http://www.omdbapi.com/?r=json&apikey=testapikey&i=tt1234567';
        $this->assertEquals($expected, $uri);
    }

    public function testBuildUriWithTitleOnly(): void
    {
        $uri = $this->invokeBuildUri('t', 'Interstellar');
        $expected = 'http://www.omdbapi.com/?r=json&apikey=testapikey&t=Interstellar';
        $this->assertEquals($expected, $uri);
    }

    public function testBuildUriWithTitleAndType(): void
    {
        $uri = $this->invokeBuildUri('t', 'Interstellar', TitleType::MOVIE);
        $expected = 'http://www.omdbapi.com/?r=json&apikey=testapikey&t=Interstellar&type=movie';
        $this->assertEquals($expected, $uri);
    }

    public function testBuildUriWithTitleTypeAndYear(): void
    {
        $uri = $this->invokeBuildUri('t', 'Interstellar', TitleType::MOVIE, 1999);
        $expected = 'http://www.omdbapi.com/?r=json&apikey=testapikey&t=Interstellar&type=movie&y=1999';
        $this->assertEquals($expected, $uri);
    }

    public function testBuildUriWithAllParameters(): void
    {
        $uri = $this->invokeBuildUri('s', 'Interstellar', TitleType::MOVIE, 1999, 2);
        $expected = 'http://www.omdbapi.com/?r=json&apikey=testapikey&s=Interstellar&type=movie&y=1999&page=2';
        $this->assertEquals($expected, $uri);
    }

    public function testBuildUriWithCustomReturnType(): void
    {
        $this->omdb->returnType = ResponseFormat::XML;
        $uri = $this->invokeBuildUri('i', 'tt1234567');
        $expected = 'http://www.omdbapi.com/?r=xml&apikey=testapikey&i=tt1234567';
        $this->assertEquals($expected, $uri);
    }

    public function testBuildUriReplacesSpecialCharacters(): void
    {
        $uri = $this->invokeBuildUri('t', 'The Lord of the Rings: The Fellowship of the Ring');
        $expected = 'http://www.omdbapi.com/?r=json&apikey=testapikey&t=The+Lord+of+the+Rings%3A+The+Fellowship+of+the+Ring';
        $this->assertEquals($expected, $uri);
    }
}
