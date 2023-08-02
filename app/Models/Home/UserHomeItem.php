<?php

namespace App\Models\Home;

use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Database\Eloquent\{
    Model,
    Builder,
    Factories\HasFactory,
    Relations\BelongsTo
};

class UserHomeItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'placed' => 'boolean',
        'is_reversed' => 'boolean',
        'item_ids' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function homeItem(): BelongsTo
    {
        return $this->belongsTo(HomeItem::class);
    }

    public function scopeDefaultRelationships(Builder $query, bool $completeLoading = false): void
    {
        $relation = 'homeItem';

        if (!$completeLoading) {
            $relation .= ':id,type,name,image';
        }

        $query->with($relation);
    }

    public function setParsedData(): void
    {
        if (empty($this->extra_data)) return;

        $this->parsed_data = renderBBCodeText($this->extra_data, true);
    }

    public function setWidgetContent(User $user): void
    {
        $this->content = null;

        if ($this->homeItem->type != 'w') return;

        $allAvailableWidgets = $this->homeItem->getAvailableWidgets();

        if (empty($allAvailableWidgets) || !array_key_exists($this->homeItem->name, $allAvailableWidgets)) return;

        $this->widget_type = $allAvailableWidgets[$this->homeItem->name];
        $this->content = app(ProfileService::class)->getCacheableWidgetContent($user, $this);

        $this->homeItem->name = __($this->homeItem->name);
    }
}
