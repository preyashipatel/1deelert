<?php

namespace Elsnertech\Flashsale\Api\Data;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface FlashsaleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Flashsale list.
     *
     * @return FlashsaleInterface[]
     */
    public function getItems();

    /**
     * Set galleries list.
     *
     * @param FlashsaleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
