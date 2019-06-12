<?php

namespace Rooxie\Exception;

/**
 * Class ApiErrorException
 */
class ApiErrorException extends \Exception
{
    /**
     * ApiErrorException constructor.
     *
     * @param string $value
     * @param string $error
     */
    public function __construct(string $value, string $error)
    {
        $message = sprintf('Could not get movie data for "%s". Got error message: "%s"', $value, $error);

        parent::__construct($message);
    }
}
