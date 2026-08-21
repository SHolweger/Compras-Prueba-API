<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'responsible_role',
        'days',
        'is_business_days',
        'previous_task_id',
        'message_template',
    ];

    protected function casts(): array
    {
        return [
            'is_business_days' => 'boolean',
        ];
    }

    public function previousTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'previous_task_id');
    }

    public function caseTasks(): HasMany
    {
        return $this->hasMany(CaseTask::class);
    }
}
