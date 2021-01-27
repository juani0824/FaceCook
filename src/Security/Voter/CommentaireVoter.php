<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Commentaire;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentaireVoter extends Voter
{
    const COMMENTAIRE_VIEW = 'commentaire_view';
    const COMMENTAIRE_EDIT = 'commentaire_edit';
    const COMMENTAIRE_DELETE = 'commentaire_delete';

    protected $attributes = [
        self::COMMENTAIRE_VIEW,
        self::COMMENTAIRE_EDIT,
        self::COMMENTAIRE_DELETE
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
            && $subject instanceof Commentaire;
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
            case self::COMMENTAIRE_VIEW:
                return $this->canView($user, $subject);
            case self::COMMENTAIRE_EDIT:
                return $this->canEdit($user, $subject);
            case self::COMMENTAIRE_DELETE:
                return $this->canDelete($user, $subject);
            default:
                return false;
        }

    }

    /**
     * @param User $user
     * @param Commentaire $commentaire
     * @return boolean
     */
    public function canView(User $user, Commentaire $commentaire): bool
    {
        if($this->authChecker->isGranted('ROLE_USER') && $user === $commentaire->getUsers()) {
            return true;
        }

        return $this->authChecker->isGranted('ROLE_ADMIN');
    }

    /**
     * @param User $user
     * @param Commentaire $commentaire
     * @return boolean
     */
    public function canEdit(User $user, Commentaire $commentaire): bool
    {
        if($this->authChecker->isGranted('ROLE_USER') && $user === $commentaire->getUsers()) {
            return true;
        }

        return $this->authChecker->isGranted('ROLE_ADMIN');
    }

    /**
     * @param User $user
     * @param Commentaire $commentaire
     * @return boolean
     */
    public function canDelete(User $user, Commentaire $commentaire): bool
    {
        if($this->authChecker->isGranted('ROLE_USER') && $user === $commentaire->getUsers()) {
            return true;
        }

        return $this->authChecker->isGranted('ROLE_ADMIN');
    }
}
