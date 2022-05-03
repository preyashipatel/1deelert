<?php
namespace Elsnertech\Flashsale\Model;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Elsnertech\Flashsale\Model\Flashsale\Source\Status;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale\Collection;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale as FlashsaleResource;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

class Flashsale extends AbstractModel implements FlashsaleInterface, IdentityInterface
{
    const CACHE_TAG = 'flashsale';
    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = 'flashsale';
    protected $_eventObject = 'flashsale';
    public function __construct(
        Context $context,
        Registry $registry,
        FlashsaleResource $resource,
        Collection $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    protected function _construct()
    {
        $this->_init(FlashsaleResource::class);
    }


    public function getAvailableStatuses()
    {
        return [
            Status::ENABLED => __('Enabled'),
            Status::DISABLED => __('Disabled')
        ];
    }
    public function getId()
    {
        return $this->getData(static::ID);
    }
    public function getName()
    {
        return $this->getData(static::NAME);
    }
    public function getStartDate()
    {
        return $this->getData(static::START_DATE);
    }
    public function getEndDate()
    {
        return $this->getData(static::END_DATE);
    }
    public function getStatus()
    {
        return $this->getData(static::STATUS);
    }
    public function getCreatedAt()
    {
        return $this->getData(static::CREATED_AT);
    }
    public function getUpdatedAt()
    {
        return $this->getData(static::UPDATED_AT);
    }
    public function setId($id)
    {
        $this->setData(static::ID, $id);
        return $this;
    }
    public function setName($name)
    {
        $this->setData(static::NAME, $name);
        return $this;
    }
    public function setStartDate($start_date)
    {
        $this->setData(static::START_DATE, $start_date);
        return $this;
    }
    public function setEndDate($end_date)
    {
        $this->setData(static::END_DATE, $end_date);
        return $this;
    }
    public function setStatus($status)
    {
        $this->setData(static::STATUS, $status);
        return $this;
    }
    public function setCreatedAt($createdAt)
    {
        $this->setData(static::CREATED_AT, $createdAt);
        return $this;
    }
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(static::UPDATED_AT, $updatedAt);
        return $this;
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
