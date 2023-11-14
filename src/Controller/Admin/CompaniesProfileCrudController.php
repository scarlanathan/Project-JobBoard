<?php

namespace App\Controller\Admin;

use App\Entity\CompaniesProfile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompaniesProfileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompaniesProfile::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
