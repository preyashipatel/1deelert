<?php

declare(strict_types=1);

namespace Amasty\Label\Api\Label;

use Amasty\Label\Api\Data\LabelInterface;

/**
 * @api
 */
interface GetLabelImageUrlInterface
{
    /**
     * @param string|null $imageName
     * @return string|null
     */
    public function execute(?string $imageName): ?string;

    /**
     * @param LabelInterface $label
     * @return string|null
     */
    public function getByLabel(LabelInterface $label): ?string;
}
