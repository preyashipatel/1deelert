<?php

namespace Amasty\Label\Controller\Adminhtml\Label;

use Amasty\Label\Model\Label;

class MassDuplicate extends MassActionAbstract
{
    /**
     * @param Label $label
     */
    protected function itemAction(Label $label): void
    {
        $this->labelRepository->duplicateLabel($label->getId());
    }

    /**
     * {@inheritdoc}
     */
    protected function getSuccessMessage($collectionSize = 0)
    {
        return __('A total of %1 record(s) have been duplicated.', $collectionSize);
    }
}
