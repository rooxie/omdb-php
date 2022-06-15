<?php

/*
 * This file is part of rooxie/omdb.
 *
 * (c) Roman Derlemenko <romanderlemenko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
