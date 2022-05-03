<?php

namespace Amasty\Label\Model\Config\Backend;

use Magento\Framework\App\Config\Value;

class StockStatus extends Value
{
    public function beforeSave()
    {
        if ($this->isValueChanged()) {
            $id = $this->getData('config')->getDefaultStockLabelId();

            if (null !== $id) {
                $status = $this->getValue();
                $this->getData('changeStatus')->execute($id, (int) $status);
            }
        }

        return parent::beforeSave();
    }
}
