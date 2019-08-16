<?php

namespace App\EventSubscriber;

use App\Events;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserWelcomeMailSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $urlGenerator;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::USER_CREATED => 'onUserCreated',
        ];
    }

    public function onUserCreated($event)
    {
        /** @var Comment $comment */
        $user = $event->getSubject();

        //$linkToPost = $this->urlGenerator->generate('home');

        /*$subject = $this->translator->trans('notification.comment_created');
        $body = $this->translator->trans('notification.comment_created.description', [
            '%title%' => $post->getTitle(),
            '%link%' => $linkToPost,
        ]);*/

        // Symfony uses a library called SwiftMailer to send emails. That's why
        // email messages are created instantiating a Swift_Message class.
        // See https://symfony.com/doc/current/email.html#sending-emails
        $message = (new \Swift_Message())
            ->setSubject("Bienvenu !")
            ->setTo($user->getMail())
            ->setFrom('no-reply@futbol-scout.com')
            ->setBody("Bienvenu sur la plateforme Futbol-Scout", 'text/html')
        ;

        // In config/packages/dev/swiftmailer.yaml the 'disable_delivery' option is set to 'true'.
        // That's why in the development environment you won't actually receive any email.
        // However, you can inspect the contents of those unsent emails using the debug toolbar.
        // See https://symfony.com/doc/current/email/dev_environment.html#viewing-from-the-web-debug-toolbar
        $this->mailer->send($message);
    }

    
}
