<?php

namespace Elsnertech\Flashsale\Model;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Elsnertech\Flashsale\Api\Data\FlashsaleSearchResultsInterface;
use Elsnertech\Flashsale\Api\Data\FlashsaleSearchResultsInterfaceFactory;
use Elsnertech\Flashsale\Api\Data\FlashsaleInterfaceFactory;
use Elsnertech\Flashsale\Api\FlashsaleRepositoryInterface;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale as ResourceFlashsale;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale\CollectionFactory as FlashsaleCollectionFactory;
use Elsnertech\Flashsale\Model\ResourceModel\Flashsale\Collection as FlashsaleCollection;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Reflection\DataObjectProcessor;

class FlashsaleRepository implements FlashsaleRepositoryInterface
{
   
    protected $resource;
    protected $flashsaleFactory;
    protected $flashsaleCollectionFactory;
    protected $searchResultsFactory;
    protected $dataObjectHelper;
    protected $dataObjectProcessor;
    protected $instances = [];

    public function __construct(
        ResourceFlashsale $resource,
        FlashsaleInterfaceFactory $flashsaleFactory,
        FlashsaleCollectionFactory $flashsaleCollectionFactory,
        FlashsaleSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->flashsaleFactory = $flashsaleFactory;
        $this->flashsaleCollectionFactory = $flashsaleCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    public function save(FlashsaleInterface $flashsale)
    {
        if (false === ($flashsale instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('Invalid Model'));
        }

        /** @var AbstractModel $flashsale */
        try {
            $this->resource->save($flashsale);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $flashsale;
    }
    public function getById($flashsaleId)
    {
        if (false === array_key_exists($flashsaleId, $this->instances)) {
            /** @var AbstractModel $flashsale */
            $flashsale = $this->flashsaleFactory->create();
            $this->resource->load($flashsale, $flashsaleId);
            if (!$flashsale->getId()) {
                throw new NoSuchEntityException(__('Flashsale with id "%1" does not exist.', $flashsaleId));
            }
            $this->instances[$flashsaleId] = $flashsale;
        }
        return $this->instances[$flashsaleId];
    }
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var FlashsaleSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var FlashsaleCollection $collection */
        $collection = $this->flashsaleCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $teaserGroups = [];
        /** @var Flashsale $flashsaleModel */
        foreach ($collection as $flashsaleModel) {
            $flashsaleData = $this->flashsaleFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $flashsaleData,
                $flashsaleModel->getData(),
                FlashsaleInterface::class
            );
            $galleries[] = $this->dataObjectProcessor->buildOutputDataArray(
                $flashsaleData,
                FlashsaleInterface::class
            );
        }
        $searchResults->setItems($teaserGroups);

        return $searchResults;
    }

    public function delete(FlashsaleInterface $flashsale)
    {
        if (false === ($flashsale instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('Invalid Model'));
        }
        /** @var AbstractModel $flashsale */
        try {
            $this->resource->delete($flashsale);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    public function deleteById($flashsaleId)
    {
        return $this->delete($this->getById($flashsaleId));
    }
}
