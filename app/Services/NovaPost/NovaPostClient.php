<?php

namespace App\Services\NovaPost;

class NovaPostClient
{
    protected string $endpoint = 'https://api.novaposhta.ua/v2.0/json/';

    public function __construct(
        public readonly string $apiToken,
    ) {}


}
