<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Category;
use DateTime;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class EntityCreatedSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
        Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Article || $object instanceof Category) {
        $object->setCreated(new DateTime());
        }
    }
}