<?php

namespace Modules\Page\Enums;

use Omaicode\Enum\Enum;

/**
 * @method static static DEFAULT()
 * @method static static HOME()
 * @method static static BOXED()
 */
final class PageTemplateEnum extends Enum
{
    const DEFAULT =   0;
    const HOME    =   1;
    const BOXED   =   2;
}
