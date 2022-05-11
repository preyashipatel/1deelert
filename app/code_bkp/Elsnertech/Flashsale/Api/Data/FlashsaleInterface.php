<?php

namespace Elsnertech\Flashsale\Api\Data;

interface FlashsaleInterface
{
    public const ID = 'id';
    public const NAME = 'name';
    public const START_DATE = 'start_date';
    public const END_DATE = 'end_date';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Retrieve id
     *
     * @return int
     */
    public function getId();

    /**
     * Retrieve name
     *
     * @return string
     */
    public function getName();

    /**
     * Retrieve startdate
     *
     * @return string
     */
    public function getStartDate();
    
    /**
     * Retrieve enddate
     *
     * @return string
     */
    public function getEndDate();

    /**
     * Retrieve status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Retrieve created at
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Retrieve updated at
     *
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Set Start date
     *
     * @param date $startDate
     * @return $this
     */
    public function setStartDate($startDate);

    /**
     * Set End Date
     *
     * @param date $endDate
     * @return $this
     */
    public function setEndDate($endDate);

    /**
     * Set status
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Set created at
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Set updated at
     *
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
