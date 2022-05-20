<?php


namespace App\EventsListener;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutListener
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param LogoutEvent $logoutEvent
     * @return void
     */


    public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent $logoutEvent): void
    {
        // Get the User entity.
        $user = $logoutEvent->getToken()->getUser();

        // Update your field here.
        $user->setDeletedAt(new \DateTimeImmutable());

        // Persist the data to database.
        $this->em->persist($user);
        $this->em->flush();

        $logoutEvent->setResponse(new RedirectResponse('https://www.google.co.in/', Response::HTTP_MOVED_PERMANENTLY));
    }
}