<?php

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
