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
    public const CACHE_TAG = 'flashsale';
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $_cacheTag = self::CACHE_TAG;
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $_eventPrefix = 'flashsale';
    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $_eventObject = 'flashsale';
    // /**
    //  * Comment of __construct function
    //  *
    //  * @param Context $context
    //  * @param Registry $registry
    //  * @param FlashsaleResource $resource
    //  * @param Collection|null $resourceCollection
    //  * @param array $data
    //  */
    // public function __construct(
    //     Context $context,
    //     Registry $registry,
    //     FlashsaleResource $resource,
    //     Collection $resourceCollection = null,
    //     array $data = []
    // ) {
    //     parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    // }
    /**
     * Comment of _construct function
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(FlashsaleResource::class);
    }
    /**
     * Comment of getAvailableStatuses function
     *
     * @return void
     */
    public function getAvailableStatuses()
    {
        return [
            Status::ENABLED => __('Enabled'),
            Status::DISABLED => __('Disabled')
        ];
    }
    /**
     * Comment of getId function
     *
     * @return void
     */
    public function getId()
    {
        return $this->getData(static::ID);
    }
    /**
     * Comment of getName function
     *
     * @return void
     */
    public function getName()
    {
        return $this->getData(static::NAME);
    }
    /**
     * Comment of getStartDate function
     *
     * @return void
     */
    public function getStartDate()
    {
        return $this->getData(static::START_DATE);
    }
    /**
     * Comment of getEndDate function
     *
     * @return void
     */
    public function getEndDate()
    {
        return $this->getData(static::END_DATE);
    }
    /**
     * Comment of getStatus function
     *
     * @return void
     */
    public function getStatus()
    {
        return $this->getData(static::STATUS);
    }
    /**
     * Comment of getCreatedAt function
     *
     * @return void
     */
    public function getCreatedAt()
    {
        return $this->getData(static::CREATED_AT);
    }
    /**
     * Comment of getUpdatedAt function
     *
     * @return void
     */
    public function getUpdatedAt()
    {
        return $this->getData(static::UPDATED_AT);
    }
    /**
     * Comment of setId function
     *
     * @param [type] $id
     * @return void
     */
    public function setId($id)
    {
        $this->setData(static::ID, $id);
        return $this;
    }
    /**
     * Comment of setName function
     *
     * @param [type] $name
     * @return void
     */
    public function setName($name)
    {
        $this->setData(static::NAME, $name);
        return $this;
    }
    /**
     * Comment of setStartDate function
     *
     * @param [type] $start_date
     * @return void
     */
    public function setStartDate($start_date)
    {
        $this->setData(static::START_DATE, $start_date);
        return $this;
    }
    /**
     * Comment of setEndDate function
     *
     * @param [type] $end_date
     * @return void
     */
    public function setEndDate($end_date)
    {
        $this->setData(static::END_DATE, $end_date);
        return $this;
    }
    /**
     * Comment of setStatus function
     *
     * @param [type] $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->setData(static::STATUS, $status);
        return $this;
    }
    /**
     * Comment of setCreatedAt function
     *
     * @param [type] $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->setData(static::CREATED_AT, $createdAt);
        return $this;
    }
    /**
     * Comment of setUpdatedAt function
     *
     * @param [type] $updatedAt
     * @return void
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->setData(static::UPDATED_AT, $updatedAt);
        return $this;
    }
    /**
     * Comment of getIdentities function
     *
     * @return void
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
