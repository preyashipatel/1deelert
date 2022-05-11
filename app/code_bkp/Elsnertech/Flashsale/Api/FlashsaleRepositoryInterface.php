<?php

namespace Elsnertech\Flashsale\Api;

use Elsnertech\Flashsale\Api\Data\FlashsaleInterface;
use Elsnertech\Flashsale\Api\Data\FlashsaleSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface FlashsaleRepositoryInterface
{
    /**
     * Save Flashsale
     *
     * @param FlashsaleInterface $flashsale
     * @return FlashsaleInterface
     * @throws CouldNotSaveException
     */
    public function save(FlashsaleInterface $flashsale);

    /**
     * Retrieve Flashsale
     *
     * @param int $flashsaleId
     * @return FlashsaleInterface
     * @throws NoSuchEntityException
     */
    public function getById($flashsaleId);

    /**
     * Retrieve galleries matching the specified criteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return FlashsaleSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete image
     *
     * @param FlashsaleInterface $flashsale
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(FlashsaleInterface $flashsale);

    /**
     * Delete Flashsale by ID.
     *
     * @param int $flashsaleId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($flashsaleId);
}
