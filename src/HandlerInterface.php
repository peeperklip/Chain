<?php

namespace Extendable\Handler;

interface HandlerInterface
{
    public function setNext(HandlerInterface $handler = null): ?HandlerInterface;

    public function handle(?string $returnInstanceOf = null);
}
