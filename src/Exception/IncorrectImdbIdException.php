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
 * Class IncorrectImdbIdException
 */
class IncorrectImdbIdException extends \Exception
{
    public const API_MESSAGE_INCORRECT_IMDB_ID  = 'Incorrect IMDb ID.';
    public const API_MESSAGE_VARCHHAR_CONVERT   = "Error converting data type varchar to int.";

    /**
     * IncorrectImdbIdException constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        parent::__construct(sprintf('Incorrect IMDb ID "%s"', $value));
    }
}
