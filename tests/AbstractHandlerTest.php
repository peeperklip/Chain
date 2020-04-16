<?php

use Extendable\Handler\AbstractHandler;
use Extendable\Handler\Exception\InvalidInstanceException;
use Extendable\Handler\HandlerInterface;
use PHPUnit\Framework\TestCase;

class AbstractHandlerTest extends TestCase
{
    public function testHandle()
    {
        $third  = $this->getHandler('done_by_third_handler', null);
        $second = $this->getHandler(null, $third);
        $first  = $this->getHandler(null, $second);
        $result = $first->handle();

        self::assertSame('done_by_third_handler', $result);
    }

    /**
     * @expectedException InvalidInstanceException
     */
    public function testReturnTypeHintingInHandle()
    {
        $third  = $this->getHandler('done_by_third_handler', null);
        $second = $this->getHandler(null, $third);
        $first  =$this->getHandler(null, $second);

        $this->expectException(InvalidInstanceException::class);
        $first->handle(InvalidInstanceException::class);
    }

    private function getHandler($handlerWillReturn, ?HandlerInterface $next) :HandlerInterface
    {
        return new class ($handlerWillReturn, $next) extends AbstractHandler {
            protected $handlerWillReturn;
            protected $next;

            public function __construct($handlerWillReturn, $next)
            {
                $this->handlerWillReturn = $handlerWillReturn;
                $this->next              = $next;
            }

            public function handle(?string $returnInstanceOf = null)
            {
                if (null !== $this->handlerWillReturn) {
                    return $this->handlerWillReturn;
                }

                return parent::handle($returnInstanceOf);
            }
        };
    }
}
