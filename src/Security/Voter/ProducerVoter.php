<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ProducerVoter extends Voter
{
    const NOT_REGISTERED = 'NOT_PRODUCER';
    const EDIT           = 'PRODUCER_EDIT';

    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        return in_array($attribute, [self::NOT_REGISTERED, self::EDIT]);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::NOT_REGISTERED:
                return $this->isNotRegistered($user);
                break;
            case self::EDIT:
                return $this->canEdit($user, $subject);
                break;
        }

        return false;
    }

    private function isNotRegistered($user)
    {
        return !$this->security->isGranted('ROLE_PRODUCER')
            && !$user->getProducer();
    }

    private function canEdit($user, $subject)
    {
        return $this->security->isGranted('ROLE_PRODUCER')
            && $user->getProducer() === $subject->getProducer();
    }
}
