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
     * Provides access to OMDb::class protected method by method named.
     *
     * @param string $methodName
     *
     * @return ReflectionMethod
     */
    protected function getOmdbProtectedMethod(string $methodName): ReflectionMethod
    {
        try {
            $omdbRef    = new ReflectionClass(OMDb::class);
            $methodRef  = $omdbRef->getMethod($methodName);

            $methodRef->setAccessible(true);

            return $methodRef;
        } catch (ReflectionException $e) {
            $this->fail("Couldn'n create OMDb class reflection, got: ".$e->getMessage());
        }
    }

    protected function invokeOmdbMethod(string $name, array $args)
    {
        try {
            $class  = new ReflectionClass(OMDb::class);
            $method = $class->getMethod($name);

            $method->setAccessible(true);

            return $method->invokeArgs(new OMDb('.......'), $args);
        } catch (ReflectionException $e) {
            $this->fail("Couldn'n create OMDb class reflection, got: ".$e->getMessage());
        }
    }
}
