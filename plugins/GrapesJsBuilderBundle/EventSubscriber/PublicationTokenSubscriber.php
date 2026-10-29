<?php

declare(strict_types=1);

namespace MauticPlugin\GrapesJsBuilderBundle\EventSubscriber;

use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PublicationTokenSubscriber implements EventSubscriberInterface
{
    /**
     * Tokens supplied by the publication email worker.
     *
     * Values here are builder descriptions, not the actual
     * recipient-specific values. Those arrive through the API.
     */
    private const TOKENS = [
        '{person_id}'        => 'Publication: Person ID',
        '{email}'            => 'Publication: Email address',
        '{first_name}'       => 'Publication: First name',
        '{last_name}'        => 'Publication: Last name',
        '{chosen_name}'      => 'Publication: Chosen name',
        '{full_name}'        => 'Publication: Full name',
        '{publication_key}'  => 'Publication: Key',
        '{publication_id}'   => 'Publication: ID',
        '{publication_name}' => 'Publication: Name',
        '{confirmation_url}' => 'Publication: Confirmation URL',
        '{unsubscribe_url}'  => 'Publication: Unsubscribe URL',
    ];

    public static function getSubscribedEvents(): array
    {
        return [
            // Run after Mautic's standard builder token registration
            // so the publication token descriptions take precedence
            // in the builder's token list.
            EmailEvents::EMAIL_ON_BUILD => ['onEmailBuild', -100],
        ];
    }

    public function onEmailBuild(EmailBuilderEvent $event): void
    {
        $requested = $event->filterTokens(array_keys(self::TOKENS));

        if ($event->tokensRequested(array_keys(self::TOKENS))) {
            $event->addTokens($requested);
        }
    }
}
