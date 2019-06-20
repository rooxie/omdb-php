<?php

namespace Rooxie\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Rooxie\OMDb;
use Throwable;

abstract class BaseTest extends TestCase
{
    /**
     * Get sample data from array using dot notation.
     *
     * @param string $path
     *
     * @return array|mixed
     */
    protected function sample(string $path)
    {
        $data = json_decode(file_get_contents(__DIR__.'/sample.json'), true);
        $part = strtok($path, '.');

        while ($part !== false) {
            if (!isset($data[$part])) {
                $this->fail("Couldn't access '{$path}' in sample data.");
            }

            $data = $data[$part];
            $part = strtok('.');
        }

        return $data;
    }

    /**
     * Invoke private method of OMDb::class and returns it's result.
     *
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    protected function invokeOmdbMethod(string $name, array $args)
    {
        try {
            $class  = new ReflectionClass(OMDb::class);
            $method = $class->getMethod($name);

            $method->setAccessible(true);

            return $method->invokeArgs(new OMDb('.......'), $args);
        } catch (ReflectionException $e) {
            $this->fail("Couldn't create OMDb class reflection, got: ".$e->getMessage());
        }
    }
}
