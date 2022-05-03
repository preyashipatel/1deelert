<?php

declare(strict_types=1);

namespace Amasty\Label\Model\Label\Text;

use Amasty\Label\Api\Data\LabelInterface;
use Magento\Catalog\Api\Data\ProductInterface;

interface ProcessorInterface
{
    const ALL_VARIABLES_FLAG = '*';

    /**
     * @return string[]
     */
    public function getAcceptableVariables(): array;

    public function getVariableValue(
        string $variable,
        LabelInterface $label,
        ProductInterface $product
    ): string;
}
