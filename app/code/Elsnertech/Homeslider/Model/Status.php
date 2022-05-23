<?php
namespace Elsnertech\Homeslider\Model;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Comment of getOptionArray function
     *
     * @return void
     */
    public function getOptionArray()
    {
        $options = ['1' => __('Enabled'),'0' => __('Disabled')];
        return $options;
    }

    /**
     * Comment of getAllOptions function
     *
     * @return void
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Comment of getOptions function
     *
     * @return void
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * Comment of toOptionArray function
     *
     * @return void
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
