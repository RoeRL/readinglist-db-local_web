<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Manga extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cover_url',
        'sources',
        'status',
        'current_chapter',
        'total_chapters',
        'genres',
    ];

    protected $casts = [
        'sources' => 'array',
        'genres'  => 'array',
    ];

//    -------------------------status display------------------------
    public static array $statuses = [
        'plan-to-read' => 'Plan to Read',
        'reading'      => 'Reading',
        'on-hold'      => 'On Hold',
        'completed'    => 'Completed',
        're-reading'   => 'Re-reading',
        'dropped'      => 'Dropped',
    ];

    public static array $statusColors = [
        'plan-to-read' => '#6B7280', // gray a bit
        'reading'      => '#3B82F6', // blue
        'on-hold'      => '#F59E0B', // yellow
        'completed'    => '#10B981', // green
        're-reading'   => '#8B5CF6', // purple
        'dropped'      => '#EF4444', // red
    ];

    public function statusLabel(): string
    {
        return self::$statuses[$this->status] ?? $this->status;
    }

    public function statusColor(): string
    {
        return self::$statusColors[$this->status] ?? '#6B7280';
    }

//    -----------------------------------------------------------------------------

// chapter progress tracker
    public function progressPercent(): int
    {
        if (!$this->total_chapters || $this->total_chapters === 0) {
            return 0;
        }
        return (int) min(100, round(($this->current_chapter / $this->total_chapters) * 100));
    }

    public function chapterLabel(): string
    {
        $cur = $this->current_chapter ?? '?';
        $tot = $this->total_chapters  ?? '?';
        return "Ch. {$cur} / {$tot}";
    }
    public function genreList(): array
    {
        return $this->genres ?? [];
    }
}
