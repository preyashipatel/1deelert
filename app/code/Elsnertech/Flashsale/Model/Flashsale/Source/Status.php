<?php

namespace Elsnertech\Flashsale\Model\Flashsale\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public const ENABLED = 1;
    public const DISABLED = 0;

    /**
     * $options variable
     *
     * @var [type]
     */
    protected $options = null;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = [
                [
                    'label' => __('Enabled'),
                    'value' => static::ENABLED,
                ],
                [
                    'label' => __('Disabled'),
                    'value' => static::DISABLED,
                ]
            ];
        }

        return $this->options;
    }
}
