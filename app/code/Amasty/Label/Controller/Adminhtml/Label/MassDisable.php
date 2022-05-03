<?php

namespace Amasty\Label\Controller\Adminhtml\Label;

use Amasty\Label\Model\Label;
use Amasty\Label\Model\Source\Status;

class MassDisable extends MassActionAbstract
{
    /**
     * @param Label $label
     */
    protected function itemAction(Label $label): void
    {
        $label->setStatus(Status::INACTIVE);
        $this->labelRepository->save($label);
    }
}
