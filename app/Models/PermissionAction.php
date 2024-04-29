<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PermissionAction
 *
 * @property-read \App\Models\Action|null $action
 * @property-read \App\Models\Permission|null $permission
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction query()
 * @property int $id
 * @property string $uuid
 * @property int $permission_id
 * @property int $action_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionAction whereUuid($value)
 * @mixin \Eloquent
 */
class PermissionAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'action_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid=Uuid::generate()->string;
        });
    }

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id')->orderBy('id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

}
