<?php

declare(strict_types=1);

namespace Amasty\Label\Model\Label\Parts\FrontendSettings;

use Amasty\Label\Api\Data\LabelInterface;
use Amasty\Label\Api\Label\GetLabelImageUrlInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class GetLabelImageUrl implements GetLabelImageUrlInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ImagePathFormatter
     */
    private $imagePathFormatter;

    public function __construct(
        StoreManagerInterface $storeManager,
        ImagePathFormatter $imagePathFormatter
    ) {
        $this->storeManager = $storeManager;
        $this->imagePathFormatter = $imagePathFormatter;
    }

    public function execute(?string $imageName): ?string
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        $imageUrl = null;

        if ($imageName) {
            $imagePath = $this->imagePathFormatter->execute($imageName);
            $imageUrl = sprintf('%s%s', $baseUrl, $imagePath);
        }

        return $imageUrl;
    }

    public function getByLabel(LabelInterface $label): ?string
    {
        return $this->execute($label->getExtensionAttributes()->getFrontendSettings()->getImage());
    }
}
