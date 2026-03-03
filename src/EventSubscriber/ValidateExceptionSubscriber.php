<?php

namespace App\EventSubscriber;

use App\Exception\ValidateException;
use App\Exception\EntityNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidateExceptionSubscriber implements EventSubscriberInterface
{
    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if ($e instanceof ValidateException) {
            $event->setResponse(new JsonResponse(['errors' => $e->getErrors()], 422));
        } elseif ($e instanceof EntityNotFoundException) {
            $event->setResponse(new JsonResponse(['message' => $e->getMessage()], 404));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onExceptionEvent',
        ];
    }
}
