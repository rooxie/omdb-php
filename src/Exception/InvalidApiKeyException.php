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
 * Class InvalidApiKeyException
 */
class InvalidApiKeyException extends \Exception
{
    public const API_MESSAGE_INVALID_KEY        = 'Invalid API key!';
    public const API_MESSAGE_NO_KEY_PROVIDED    = 'No API key provided.';

    /**
     * InvalidApiKeyException constructor.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        parent::__construct(sprintf('Invalid or missing API key "%s"', $apiKey));
    }
}
