<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([TenantScope::class])]
class Department extends Model
{
    protected $fillable = ['name', 'tenant_id'];

    protected static function booted()
    {
        parent::booted();

        static::creating(static function ($department) {
            if (session()->has('tenant_id')) {
                $department->tenant_id = session()->get('tenant_id');
            }
        });
    }

}
