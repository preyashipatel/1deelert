<?php
namespace Smartwave\Megamenu\Model\Attribute;

class Floattype extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Comment of getAllOptions function
     *
     * @return void
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => '', 'label' => __('Default')],
                ['value' => 'left', 'label' => __('Left')],
                ['value' => 'right', 'label' => __('Right')]
            ];
        }
        
        return $this->_options;
    }
}
