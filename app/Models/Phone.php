<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([TenantScope::class])]
class Phone extends Model
{
    /** @use HasFactory<\Database\Factories\PhoneFactory> */
    use HasFactory;

    protected static function booted()
        {
            parent::booted();

            static::creating(static function ($model) {
                if (session()->has('tenant_id')) {
                    $model->tenant_id = session()->get('tenant_id');
                }
            });
        }
}
