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
 * Class MovieNotFoundException
 */
class MovieNotFoundException extends \Exception
{
    public const API_MESSAGE_NOT_FOUND_KEY = 'Movie not found!';

    /**
     * MovieNotFoundException constructor.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        parent::__construct(sprintf('Could not find movie "%s"', $title));
    }
}
