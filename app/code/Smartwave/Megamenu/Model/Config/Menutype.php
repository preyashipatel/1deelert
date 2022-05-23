<?php
namespace Smartwave\Megamenu\Model\Config;

class Menutype implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Comment of toOptionArray function
     *
     * @return void
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'fullwidth', 'label' => __('Full Width')],
            ['value' => 'staticwidth', 'label' => __('Static Width')],
            ['value' => 'classic', 'label' => __('Classic')]
        ];
    }

    /**
     * Comment of toArray function
     *
     * @return void
     */
    public function toArray()
    {
        return [
            'fullwidth' => __('Full Width'),
            'staticwidth' => __('Static Width'),
            'classic' => __('Classic')
        ];
    }
}
