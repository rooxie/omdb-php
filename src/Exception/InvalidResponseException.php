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
 * Class InvalidResponseExceptiond
 */
class InvalidResponseException extends \Exception
{
    /**
     * InvalidResponseException constructor.
     *
     * @param string $value
     * @param string $output
     */
    public function __construct(string $value, string $output)
    {
        $message = sprintf('Could not get movie data for "%s". Got response: "%s"', $value, $output);

        parent::__construct($message);
    }
}
