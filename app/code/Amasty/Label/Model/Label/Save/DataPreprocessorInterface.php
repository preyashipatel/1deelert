<?php

declare(strict_types=1);

namespace Amasty\Label\Model\Label\Save;

interface DataPreprocessorInterface
{
    /**
     * Prepare and validate data before save
     *
     * @param array $data
     * @return array
     */
    public function process(array $data): array;
}
