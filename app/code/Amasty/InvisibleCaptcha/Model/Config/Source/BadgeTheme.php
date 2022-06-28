<?php

declare(strict_types=1);

namespace Amasty\InvisibleCaptcha\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class BadgeTheme implements OptionSourceInterface
{
    public const BADGE_THEME_LIGHT = 'light';
    public const BADGE_THEME_DARK = 'dark';

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => self::BADGE_THEME_LIGHT, 'label'=> __('Light')],
            ['value' => self::BADGE_THEME_DARK, 'label'=> __('Dark')]
        ];
    }
}
