<?php

namespace App\NF\Infrastructure\Http;

use App\NF\Infrastructure\Event\SendNotificationEvent;
use App\NF\Infrastructure\Response\NotificationResponse;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SendNotificationController extends AbstractController
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private LoggerInterface $logger // @phpstan-ignore-line
    ) {
    }

    #[Route('/notification', methods: ['POST'])]
    public function notification(Request $request): JsonResponse
    {
        $this->eventDispatcher->dispatch(
            new SendNotificationEvent($request),
            SendNotificationEvent::NAME
        );

        return new NotificationResponse();
    }
}
