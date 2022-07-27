<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use symfony\Component\EventDispatcher\EventSubscriberInterface;


class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt'],
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof TimestampedInterface) return;

        $entity->setCreatedAt(new DateTime());
    }

    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof TimestampedInterface) return;

        $entity->setUpdatedAt(new DateTime());
    }
}
