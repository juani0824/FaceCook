<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Publication;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PublicationVoter extends Voter
{
    const PUBLICATION_VIEW = 'publication_view';
    const PUBLICATION_EDIT = 'publication_edit';
    const PUBLICATION_DELETE = 'publication_delete';

    protected $attributes = [
        self::PUBLICATION_VIEW,
        self::PUBLICATION_EDIT,
        self::PUBLICATION_DELETE
    ];

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authChecker;

    /**
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function __construct(AuthorizationCheckerInterface $authChecker)
    {
        $this->authChecker = $authChecker;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, $this->attributes)
            && $subject instanceof Publication;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::PUBLICATION_VIEW:
                return $this->canView($user, $subject);
            case self::PUBLICATION_EDIT:
                return $this->canEdit($user, $subject);
            case self::PUBLICATION_DELETE:
                return $this->canDelete($user, $subject);
            default:
                return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Publication $publication
     * @return boolean
     */
    public function canView(User $user, Publication $publication): bool
    {
        if($this->authChecker->isGranted('ROLE_USER') && $user === $publication->getUsers()) {
            return true;
        }

        return $this->authChecker->isGranted('ROLE_ADMIN');
    }

    /**
     * @param User $user
     * @param Publication $publication
     * @return boolean
     */
    public function canEdit(User $user, Publication $publication): bool
    {
        if($this->authChecker->isGranted('ROLE_USER') && $user === $publication->getUsers()) {
            return true;
        }

        return $this->authChecker->isGranted('ROLE_ADMIN');
    }

    /**
     * @param User $user
     * @param Publication $publication
     * @return boolean
     */
    public function canDelete(User $user, Publication $publication): bool
    {
        if($this->authChecker->isGranted('ROLE_USER') && $user === $publication->getUsers()) {
            return true;
        }

        return $this->authChecker->isGranted('ROLE_ADMIN');
    }
}
