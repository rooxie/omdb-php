<?php

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
