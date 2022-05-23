<?php
namespace Smartwave\Dailydeals\Model\Dailydeal\Source;

class SwDiscountType implements \Magento\Framework\Option\ArrayInterface
{
    public const FIXED = 1;
    public const PERCENTAGE = 2;
    /**
     * To option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            [ 'value'=>'',
              'label'=>__('Select Options')
            ],
            [
                'value' => self::FIXED,
                'label' => __('Fixed')
            ],
            [
                'value' => self::PERCENTAGE,
                'label' => __('Percentage')
            ],
        ];
        return $options;
    }
}
