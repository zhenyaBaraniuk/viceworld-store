<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    /**
     * Extract the raw Inertia page props, bypassing assertInertia's
     * dot-notation traversal (which misinterprets flat dot-namespaced
     * translation keys as nested paths).
     */
    protected function inertiaProps(TestResponse $response): array
    {
        $page = json_decode(json_encode($response->viewData('page')), true);

        return $page['props'];
    }
}
