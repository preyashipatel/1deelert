<?php

declare(strict_types=1);

namespace Amasty\Label\Model\ResourceModel\Label\Save;

use Amasty\Label\Api\Data\LabelInterface;

interface AdditionalSaveActionInterface
{
    public function execute(LabelInterface $label): void;
}
