<?php

namespace App\EventSubscriber;

use App\Article\Status;
use App\Entity\Article;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class EntityPublishedSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
        Events::prePersist,
        Events::preUpdate
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Article) {
            $object->setStatus(1);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Article) {
            if ($object->getStatus() === Status::PUBLISHED) {
            $object->setPublished(new DateTime());
            }
        }
    }
}