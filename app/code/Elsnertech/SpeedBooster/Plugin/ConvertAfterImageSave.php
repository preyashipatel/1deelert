<?php
/**
 * @author Elsner Team
 * @copyright Copyright © Elsner Technologies Pvt. Ltd (https://www.elsner.com/)
 * @package Elsnertech_SpeedBooster
 */
declare(strict_types=1);

namespace Elsnertech\SpeedBooster\Plugin;

use Magento\Framework\Image;
use Elsnertech\SpeedBooster\Config\Config;
use Elsnertech\SpeedBooster\Convertor\ConvertorListing;
use Elsnertech\SpeedBooster\Exception\ConvertorException;
use Elsnertech\SpeedBooster\Image\ImageFactory;

class ConvertAfterImageSave
{
    /**
     * @var ConvertorListing
     */
    private $convertorListing;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var ImageFactory
     */
    private $imageFactory;

    /**
     * ConvertAfterImageSave constructor.
     * @param ConvertorListing $convertorListing
     * @param Config $config
     */
    public function __construct(
        ConvertorListing $convertorListing,
        Config $config,
        ImageFactory $imageFactory
    ) {
        $this->convertorListing = $convertorListing;
        $this->config = $config;
        $this->imageFactory = $imageFactory;
    }

    /**
     * @param Image $subject
     * @param mixed $return
     * @param null $destination
     * @return void
     */
    public function afterSave(Image $subject, $return, $destination = null)
    {
        if (!$this->config->enablednext()) {
            return;
        }

        if (!$this->config->convertImagesOnSave()) {
            return;
        }

        $image = $this->imageFactory->createFromPath((string)$destination);
        foreach ($this->convertorListing->getConvertors() as $convertor) {
            try {
                $convertor->convertImage($image);
            } catch (ConvertorException $e) {
            }
        }
    }
}
