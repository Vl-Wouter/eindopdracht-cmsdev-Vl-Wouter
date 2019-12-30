<?php

namespace App\Serializer;

use App\Entity\Period;
use Symfony\Component\Routing\RouterInterface;

class CircularReferenceHandler {
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke($object)
    {
        // TODO: Implement __invoke() method.
        switch ($object) {
            case $object instanceof Period:
                return $this->router->generate('api_tasks_index', ['id' => $object->getId()]); break;
            default:
                return $object->getId();
        }
    }
}