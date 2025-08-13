<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',
        'completed_at',
        'workspace_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'completed') {
            return false;
        }
        
        return $this->deadline->isPast();
    }

    public function getTimeRemainingAttribute(): string
    {
        if ($this->status === 'completed') {
            return $this->completed_at->diffForHumans();
        }

        if ($this->is_overdue) {
            return 'Overdue by ' . $this->deadline->diffForHumans(null, true);
        }

        return $this->deadline->diffForHumans();
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->status === 'completed') {
            return '<span class="badge badge-success">Completed</span>';
        }

        if ($this->is_overdue) {
            return '<span class="badge badge-danger">Overdue</span>';
        }

        $hoursUntilDeadline = now()->diffInHours($this->deadline);
        $warningHours = env('TASK_OVERDUE_WARNING_HOURS', 24);

        if ($hoursUntilDeadline <= $warningHours) {
            return '<span class="badge badge-warning">Due Soon</span>';
        }

        return '<span class="badge badge-info">Pending</span>';
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsIncomplete(): void
    {
        $this->update([
            'status' => 'incomplete',
            'completed_at' => null,
        ]);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeIncomplete($query)
    {
        return $query->where('status', 'incomplete');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'incomplete')
                    ->where('deadline', '<', now());
    }

    public function scopeDueSoon($query)
    {
        $warningHours = env('TASK_OVERDUE_WARNING_HOURS', 24);
        return $query->where('status', 'incomplete')
                    ->where('deadline', '>', now())
                    ->where('deadline', '<=', now()->addHours($warningHours));
    }
}
