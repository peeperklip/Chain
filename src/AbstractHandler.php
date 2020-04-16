<?php

namespace Extendable\Handler;

use Extendable\Handler\Exception\InvalidInstanceException;

abstract class AbstractHandler implements HandlerInterface
{
    /** @var HandlerInterface */
    protected $next;

    public function setNext(HandlerInterface $handler = null):?HandlerInterface
    {
        $this->next = $handler;

        return $handler;
    }

    public function handle(?string $returnInstanceOf = null)
    {
        $result = (null !== $this->next) ? $this->next->handle(): null;

        $this->checkIfTypeOf($returnInstanceOf, $result);

        return $result;
    }

    protected function checkIfTypeOf($returnInstanceOf, $result)
    {
        if (null !== $returnInstanceOf) {
            if (isset($result) && is_object($result) && get_class($result) !== $returnInstanceOf) {
                throw new InvalidInstanceException("handle() should return an instance of {$returnInstanceOf}");
            }

            if (isset($result) && !is_object($result) && gettype($result) !== $returnInstanceOf) {
                throw new InvalidInstanceException("handle() should return type of {$returnInstanceOf}");
            }
        }
    }
}
