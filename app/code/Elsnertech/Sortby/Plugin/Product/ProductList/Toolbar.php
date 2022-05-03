<?php
namespace Elsnertech\Sortby\Plugin\Product\ProductList;

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
            }elseif($this->getCurrentOrder() == "newest_product"){
                $direction = $this->getCurrentDirection();
                // $this->_collection->getSelect()->orderBy('created_at',$direction);
                $this->_collection->getSelect()->order('created_at', $this->getCurrentDirection());
            } else {
                $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
            }
        }
        // if ($this->getCurrentOrder()) {
        //     if ($this->getCurrentOrder() == "newest_product") {
        //             $direction = $this->getCurrentDirection();
        //             $this->_collection->getSelect()->order('created_at',$direction);
        //         }
        // }
        return $this;
    }

}