<?php

namespace Rooxie\Tests;

class BuildParamsTest extends BaseTest
{
    /**
     * Test building parameters only with IMDb ID.
     */
    public function testBasicParams()
    {
        $this->assertParams(['i' => 'tt0120737'], ['i', 'tt0120737', '', 0, 0]);
    }

    /**
     * Test building parameters with title and year.
     */
    public function testYearParam()
    {
        $this->assertParams(['t' => 'inception', 'y' => 2010], ['t', 'inception', '', 2010, 0]);
    }

    /**
     * Test building parameters with search query and type.
     */
    public function testTypeParam()
    {
        $this->assertParams(['s' => 'matrix', 'type' => 'movie'], ['s', 'matrix', 'movie', 0, 0]);
    }

    /**
     * Test building parameters with search query and pagination.
     */
    public function testPaginationParam()
    {
        $this->assertParams(['s' => 'mirror', 'page' => 2], ['s', 'mirror', '', 0, 2]);
    }

    /**
     * Test building parameters with search query, type, year and pagination.
     */
    public function testAllParams()
    {
        $this->assertParams(['s' => 'lost', 'type' => 'movie', 'y' => 2003, 'page' => 1], ['s', 'lost', 'movie', 2003, 1]);
    }

    /**
     * Helper method for asserting array from request building method.
     *
     * @param array $expected
     * @param array $args
     */
    private function assertParams(array $expected, array $args): void
    {
        $this->assertEquals($expected, $this->invokeOmdbMethod('buildParams', $args));
    }
}
