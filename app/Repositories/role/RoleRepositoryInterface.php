<?php

namespace App\Repositories\Role;

interface RoleRepositoryInterface 
{
    public function getAllRoles();
    public function getRoleById($roleId);
    public function deleteRole($orderId);
    public function createRole(array $roleDetails);
    public function updateRole($roleId, array $newDetails);
    //public function getFulfilledOrders();
}