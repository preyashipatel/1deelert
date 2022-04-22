<?php
namespace Elsnertech\Customisation\Plugin\Catalog\Block;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{

    /**
     * Set collection to pager
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @return \Magento\Catalog\Block\Product\ProductList\Toolbar
     */
    public function setCollection($collection)
    {
        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        // we need to set pagination only if passed value integer and more that 0
        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }
        if ($this->getCurrentOrder()) {
            if (($this->getCurrentOrder()) == 'position') {
                $this->_collection->addAttributeToSort(
                    $this->getCurrentOrder(),
                    $this->getCurrentDirection()
                );
            } else {
                if ($this->getCurrentOrder() == 'high_to_low') {
                    $this->_collection->setOrder('price', 'desc');
                } elseif ($this->getCurrentOrder() == 'low_to_high') {
                    $this->_collection->setOrder('price', 'asc');
                }
                if ($this->getCurrentOrder() == "newest_product") {
                    $direction = $this->getCurrentDirection();
                    $this->_collection->getSelect()->order('created_at',$direction);
                }

            }
        }
        return $this;
    }

}