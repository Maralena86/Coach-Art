<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ContactService
{
    private $manager;
    private $flash;
    public function ––construct(EntityManagerInterface $manager, FlashBagInterface $flash)
    {
        $this->manager = $manager;
        $this->flash = $flash;
    }
    public function persistContact(Contact $contact):void
    {
       
               dd($contact);
        $this->manager->persist($contact);
        $this->manager->flush();
        $this->flash->add('succes', 'Votre message est bien envoyéé, merci');
    }
}
