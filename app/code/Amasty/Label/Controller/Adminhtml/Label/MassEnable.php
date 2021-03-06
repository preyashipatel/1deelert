<?php

namespace Amasty\Label\Controller\Adminhtml\Label;

use Amasty\Label\Model\Label;
use Amasty\Label\Model\Source\Status;

class MassEnable extends MassActionAbstract
{
    /**
     * @param Label $label
     */
    protected function itemAction(Label $label): void
    {
        $label->setStatus(Status::ACTIVE);
        $this->labelRepository->save($label);
    }
}
