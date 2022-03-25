<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PermissionRole
 *
 * @property int $id
 * @property int $permission_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PermissionRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermissionRole extends Model
{
    protected $table = 'permission_role';


}
