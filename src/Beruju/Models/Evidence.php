<?php

namespace Src\Beruju\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Evidence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brj_evidences';

    protected $fillable = [
        'beruju_entry_id',
        'name',
        'file_name',
        'description',
        'action_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'beruju_entry_id' => 'string',
        'name' => 'string',

        'file_name' => 'string',

        'action_id' => 'integer',

        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function berujuEntry(): BelongsTo
    {
        return $this->belongsTo(BerujuEntry::class, 'beruju_entry_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Accessors
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '0 B';

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? Storage::url($this->file_path) : '';
    }
}
