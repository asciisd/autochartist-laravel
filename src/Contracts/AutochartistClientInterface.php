<?php

namespace Mohanad\Autochartist\Contracts;

interface AutochartistClientInterface
{
    public function get(string $endpoint, array $params = []): array;

    public function post(string $endpoint, array $data = []): array;
}
