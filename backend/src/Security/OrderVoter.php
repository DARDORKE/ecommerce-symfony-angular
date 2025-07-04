<?php

namespace App\Security;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OrderVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT])
            && $subject instanceof Order;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        
        if (!$user instanceof User) {
            return false;
        }

        /** @var Order $order */
        $order = $subject;

        switch ($attribute) {
            case self::VIEW:
            case self::EDIT:
                return $this->canAccessOrder($order, $user);
        }

        return false;
    }

    private function canAccessOrder(Order $order, User $user): bool
    {
        // Users can only access their own orders
        return $order->getUser() === $user;
    }
}