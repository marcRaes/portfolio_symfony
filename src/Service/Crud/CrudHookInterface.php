<?php

namespace App\Service\Crud;

interface CrudHookInterface
{
    public function beforeSave(object $entity): void;
    public function afterSave(object $entity): void;
    public function beforeDelete(object $entity): void;
    public function afterDelete(object $entity): void;
}
