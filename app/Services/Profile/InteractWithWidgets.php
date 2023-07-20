<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Models\Home\UserHomeItem;

trait InteractWithWidgets
{
    use HasCacheableWidgets;

    public function getCacheableWidgetContent(User $user, UserHomeItem $item): ?string
    {
        $viewName = "components.home.items.widgets.{$item->widget_type}";

        if (!view()->exists($viewName)) return null;

        $user = $this->getCacheableWidgetData($user, $item);

        return view($viewName, compact('item', 'user'))->render();
    }
}
