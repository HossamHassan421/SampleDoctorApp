<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\RolePermissionActions
 *
 * @property-read \App\Models\PermissionAction|null $permissionAction
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions query()
 * @property int $id
 * @property string $uuid
 * @property int $role_id
 * @property int $permission_actions_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions wherePermissionActionsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RolePermissionActions whereUuid($value)
 * @mixin \Eloquent
 */
class RolePermissionActions extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_actions_id',
        'role_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::generate()->string;
        });
    }

    public function permissionAction()
    {
        return $this->belongsTo(PermissionAction::class, 'permission_actions_id');
    }


}
