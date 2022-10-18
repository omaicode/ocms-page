<?php

namespace Modules\Page\Enums;

use Omaicode\Enum\Enum;

/**
 * @method static static DRAFT()
 * @method static static PUBLISH()
 */
final class PageStatusEnum extends Enum
{
    const DRAFT   =   0;
    const PUBLISH =   1;
}
