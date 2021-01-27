<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class CommentaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commentaire::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),            
            TextEditorField::new('contenu', 'Commentaire'),
            AssociationField::new('users', 'Publié par'),
            DateTimeField::new('createdAt', 'Date de création'),
            DateTimeField::new('updatedAt', 'Actualisé'),
        ];
    }
    
}
