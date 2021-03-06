<?php

declare(strict_types=1);

namespace Amasty\Label\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\System\Store;

class Stores implements OptionSourceInterface
{
    /**
     * @var Store
     */
    private $storeProvider;

    public function __construct(
        Store $storeProvider
    ) {
        $this->storeProvider = $storeProvider;
    }

    public function toOptionArray()
    {
        return $this->storeProvider->getStoreValuesForForm(false, true);
    }
}
