<?php

namespace App\Security\Voter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    private $security = null;


    public function __construct(Security $security)
    {
        $this->security = $security;

    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic

            return  in_array( $attribute, ['TOKEN']);


        // https://symfony.com/doc/current/security/voters.html
//        return in_array($attribute, [self::EDIT, self::VIEW])
//            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /**
         * @var Request $subject
         */

        $headerToken  = $subject->headers->get('TOKEN',null);

        //dd($headerToken);

        if(is_null($headerToken))
        {
            return false;
        }

//        $user = $token->getUser();
//        // if the user is anonymous, do not grant access
//        if (!$user instanceof UserInterface) {
//            return false;
//        }

        if( $headerToken == '12345678')
        {
           
            return true;
        }
        else {
            return false;
        }

//        // ... (check conditions and return true to grant permission) ...
//        switch ($attribute) {
//            case self::EDIT:
//                // logic to determine if the user can EDIT
//                // return true or false
//                break;
//            case self::VIEW:
//                // logic to determine if the user can VIEW
//                // return true or false
//                break;
//        }

        return false;
    }
}
