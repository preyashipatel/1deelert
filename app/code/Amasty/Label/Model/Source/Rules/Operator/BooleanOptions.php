<?php

declare(strict_types=1);

namespace Amasty\Label\Model\Source\Rules\Operator;

use Magento\Framework\Data\OptionSourceInterface;

class BooleanOptions implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('is'),
                'value' => '=='
            ],
            [
                'label' => __('is not'),
                'value' => '!='
            ]
        ];
    }
}
