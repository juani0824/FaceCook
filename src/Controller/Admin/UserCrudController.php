<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom'),
            EmailField::new('email', 'Email'),
            TelephoneField::new('portable', 'Portable N°'),
            TextField::new('password', 'Mot de Passe' )->onlyWhenCreating(),           
            ChoiceField :: new ( 'roles' , 'Roles' )
                    -> allowMultipleChoices ()                    
                    -> setChoices ([ 'Visiteur' => 'ROLE_USER' ,
                                     'Cantinière' => 'CANTINIER',
                                     'Admin' => 'ROLE_ADMIN' ,
                                     'SuperAdmin' => 'ROLE_SUPER_ADMIN' ]
                                )  
        ];
    }
      
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
}
