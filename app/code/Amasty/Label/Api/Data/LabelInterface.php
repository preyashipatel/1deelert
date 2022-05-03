<?php

declare(strict_types=1);

namespace Amasty\Label\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * @api
 */
interface LabelInterface extends ExtensibleDataInterface
{
    public const LABEL_ID = 'label_id';
    public const NAME = 'name';
    public const STATUS = 'status';
    public const PRIORITY = 'priority';
    public const IS_SINGLE = 'is_single';
    public const USE_FOR_PARENT = 'use_for_parent';
    public const CONDITION_SERIALIZED = 'conditions_serialized';
    public const ACTIVE_FROM = 'active_from';
    public const ACTIVE_TO = 'active_to';

    /**
     * @return int
     */
    public function getLabelId(): int;

    /**
     * @param int $labelId
     * @return void
     */
    public function setLabelId(int $labelId): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return void
     */
    public function setStatus(int $status): void;

    /**
     * @return int
     */
    public function getPriority(): int;

    /**
     * @param int $priority
     * @return void
     */
    public function setPriority(int $priority): void;

    /**
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     *
     * @return bool
     */
    public function getIsSingle(): bool;

    /**
     * @param bool $isSingle
     * @return void
     */
    public function setIsSingle(bool $isSingle): void;

    /**
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     *
     * @return bool
     */
    public function getUseForParent(): bool;

    /**
     * @param bool $useForParent
     * @return void
     */
    public function setUseForParent(bool $useForParent): void;

    /**
     * @return string
     */
    public function getConditionSerialized(): string;

    /**
     * @param string $conditionSerialized
     * @return void
     */
    public function setConditionSerialized(string $conditionSerialized): void;

    /**
     * @return string|null
     */
    public function getActiveFrom(): ?string;

    /**
     * @param string|null $activeFrom
     * @return void
     */
    public function setActiveFrom(?string $activeFrom): void;

    /**
     * @return string|null
     */
    public function getActiveTo(): ?string;

    /**
     * @param string|null $activeTo
     * @return void
     */
    public function setActiveTo(?string $activeTo): void;

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Amasty\Label\Api\Data\LabelExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param LabelExtensionInterface $extensionAttributes
     * @return void
     */
    public function setExtensionAttributes(\Amasty\Label\Api\Data\LabelExtensionInterface $extensionAttributes): void;
}
