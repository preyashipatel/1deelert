<?php

namespace Amasty\Label\Model\Indexer;

use Magento\Framework\Exception\LocalizedException;

class LabelMainIndexer extends LabelIndexer
{
    const INDEXER_ID = 'amasty_label_main';

    /**
     * Execute materialization on ids entities
     *
     * @param int[] $ids
     * @throws LocalizedException
     */
    public function execute($ids)
    {
        $this->executeByLabelIds($ids);
    }

    /**
     * @param int[] $ids
     * @throws LocalizedException
     */
    public function executeList(array $ids)
    {
        $this->executeByLabelIds($ids);
    }
}
