<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Contracts;

class CKEditor extends Field implements Contracts\CanBeLengthConstrained, Contracts\HasFileAttachments
{
    use Concerns\HasPlaceholder;
    use Concerns\HasFileAttachments;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'filament.forms.components.ck-editor';
}
