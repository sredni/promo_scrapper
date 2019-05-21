<?php

declare(strict_types=1);

namespace Sredni\Routing;

class Route
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $action;

    /**
     * @param string $method
     * @param string $route
     * @param string $action
     */
    public function __construct(string $method, string $route, string $action)
    {
        if (!in_array($method, [
            'get',
            'post',
            'put',
            'delete',
            'head',
            'patch',
            'options',
        ])) {
            throw new \InvalidArgumentException(sprintf('Invalid method %s', $method));
        }

        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function route(): string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function action(): string
    {
        return $this->action;
    }
}