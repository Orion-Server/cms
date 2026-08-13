<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Contracts\CanBeLengthConstrained;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Concerns;

// Filament 4 dropped Contracts\HasFileAttachments; only the concern remains.
class CKEditor extends Field implements CanBeLengthConstrained
{
    use HasPlaceholder;
    use Concerns\HasFileAttachments;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'filament.forms.components.ck-editor';
}
