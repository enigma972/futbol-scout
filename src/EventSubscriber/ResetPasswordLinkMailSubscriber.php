<?php

namespace App\EventSubscriber;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResetPasswordLinkMailSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $urlGenerator;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $urlGenerator)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return [
            'user.reset.pass' => 'onUserResetPass',
        ];
    }
    public function onUserResetPass($event)
    {
        /** @var ResetPass $resetpass */
        $resetpass = $event->getSubject();

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
            ->setSubject("{$resetpass->getUser()->getFirstname()} , voici le lien pour réinitialiser votre mot de passe.")
            ->setTo($resetpass->getUser()->getMail())
            ->setFrom('no-reply@futbol-scout.com')
            ->setBody("Bonjour {$resetpass->getUser()->getFirstname()}, <br>Modifiez votre mot de passe et vous pourrez poursuivre. <br>Pour changer votre mot de passe Futbol-Scout, cliquez sur le lien ci-dessous. <br><a href=\"{$this->urlGenerator->generate('app_complete_reset_pass', ['mail'=>$resetpass->getUser()->getMail(), 'token'=>$resetpass->getToken()], UrlGeneratorInterface::ABSOLUTE_URL)}\">Réinitialiser mon mot de passe</a> <br>Ce lien expireran dans 4 heures,assurez-vous de l'utiliser bientôt. <br>Merci d'utiliser futbol-scout ! <br>L'équipe Futbol-Scout.", 'text/html')
        ;

        // In config/packages/dev/swiftmailer.yaml the 'disable_delivery' option is set to 'true'.
        // That's why in the development environment you won't actually receive any email.
        // However, you can inspect the contents of those unsent emails using the debug toolbar.
        // See https://symfony.com/doc/current/email/dev_environment.html#viewing-from-the-web-debug-toolbar
        $this->mailer->send($message);
    }
}
