<?php

declare(strict_types=1);

namespace MauticPlugin\GrapesJsBuilderBundle\EventSubscriber;

use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CustomTokenSubscriber implements EventSubscriberInterface
{
    /**
     * These tokens are supplied by the external email worker.
     *
     * Do not add send-time replacement logic here.
     */
    private const TOKENS = [
        '{person_id}'        => 'Person ID',
        '{email}'            => 'Email Address',
        '{first_name}'       => 'First Name',
        '{last_name}'        => 'Last Name',
        '{chosen_name}'      => 'Chosen Name',
        '{full_name}'        => 'Full Name',
        '{publication_key}'  => 'Publication Key',
        '{publication_id}'   => 'Publication ID',
        '{publication_name}' => 'Publication Name',
        '{confirmation_url}' => 'Confirmation URL',
        '{unsubscribe_url}'  => 'Unsubscribe URL',
    ];

    public static function getSubscribedEvents(): array
    {
        return [
            EmailEvents::EMAIL_ON_BUILD => ['onEmailBuild', 0],
        ];
    }

    public function onEmailBuild(EmailBuilderEvent $event): void
    {
        $tokens = self::TOKENS;

        if ($event->tokensRequested(array_keys($tokens))) {
            $event->addTokens($event->filterTokens($tokens));
        }
    }
}

