<?php

namespace Rooxie\Tests;

use Rooxie\Exception\ApiErrorException;
use Rooxie\Exception\IncorrectImdbIdException;
use Rooxie\Exception\InvalidApiKeyException;
use Rooxie\Exception\InvalidResponseException;
use Rooxie\Exception\MovieNotFoundException;

class ResponseParserTest extends BaseTest
{
    /**
     * Test parse successful response by IMDb ID.
     */
    public function testFoundByImdbId()
    {
        $this->assertSuccessfullParsedResponse('foundByImdbId');
    }

    /**
     * Test parse successful response by movie title.
     */
    public function testFoundByTitle()
    {
        $this->assertSuccessfullParsedResponse('foundByTitle');
    }

    /**
     * Test parse successful response by search.
     */
    public function testFoundBeSearch()
    {
        $this->assertSuccessfullParsedResponse('foundBySearch');
    }

    /**
     * Test parse successful response by movie title.
     */
    public function testNotFoundByTitle()
    {
        $this->expectExceptionOnSample('notFoundByTitle', MovieNotFoundException::class);
    }

    /**
     * Test unsuccessful response with invalid API key.
     */
    public function testInvalidApiKeyException()
    {
        $this->expectExceptionOnSample('invalidApiKey', InvalidApiKeyException::class);
    }

    /**
     * Test unsuccessful response with invalid data.
     */
    public function testInvalidResponseException()
    {
        $this->expectExceptionOnSample('invalidResponse', InvalidResponseException::class);
    }

    /**
     * Test unsuccessful response with invalid IMDb ID.
     */
    public function testIncorrectImdbIdException()
    {
        $this->expectExceptionOnSample('incorrectImdbId', IncorrectImdbIdException::class);
    }

    /**
     * Test unsuccessful response with an API error.
     */
    public function testApiErrorException()
    {
        $this->expectExceptionOnSample('apiError', ApiErrorException::class);
    }

    /**
     * Helper method for asserting successful response parsing.
     *
     * @param string $responseSample
     */
    private function assertSuccessfullParsedResponse(string $responseSample): void
    {
        $sample = $this->sample('responses.'.$responseSample);

        $this->assertEquals($this->invokeOmdbMethod('parseResponse', [$sample]), json_decode($sample['Response'], true));
    }

    /**
     * Helper method for expecting exception of unsuccessful response parsing.
     *
     * @param string $responseSample
     * @param string $exception
     */
    private function expectExceptionOnSample(string $responseSample, string $exception): void
    {
        $this->expectException($exception);
        $this->invokeOmdbMethod('parseResponse', [$this->sample('responses.'.$responseSample)]);
    }
}
