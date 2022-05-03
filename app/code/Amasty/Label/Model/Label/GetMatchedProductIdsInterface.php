<?php

declare(strict_types=1);

namespace Amasty\Label\Model\Label;

use Amasty\Label\Api\Data\LabelInterface;

interface GetMatchedProductIdsInterface
{
    /**
     * @param LabelInterface $label
     * @param array|null $productIds
     *
     * @return int[]
     */
    public function execute(LabelInterface $label, ?array $productIds): array;
}
