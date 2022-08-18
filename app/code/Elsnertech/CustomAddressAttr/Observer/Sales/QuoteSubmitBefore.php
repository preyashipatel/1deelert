<?php
/**
 * Copyright © 2017 EaDesign by Eco Active S.R.L. All rights reserved.
 * See LICENSE for license details.
 */

namespace Elsnertech\CustomAddressAttr\Observer\Sales;

// use Elsnertech\CustomAddressAttr\Block\Checkout\Address\Fields\LayoutProcessor;
use Elsnertech\CustomAddressAttr\Model\Plugin\Checkout\LayoutProcessor;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;

class QuoteSubmitBefore implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var QuoteRepository
     */
    private $quoteRepository;

    /**
     * QuoteSubmitBefore constructor.
     * @param QuoteRepository $quoteRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        QuoteRepository $quoteRepository,
        LoggerInterface $logger
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->logger = $logger;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(
        Observer $observer
    ) {

        /** @var Order $order */
        $order = $observer->getOrder();

        $quote = $this->quoteRepository->get($order->getQuoteId());

        try {
            $this->orderBillingAddressFields($order, $quote);

            $this->orderShippingAddressFields($order, $quote);
            $this->logger->debug('distric name'.$quote->getBillingAddress()->getData(LayoutProcessor::DISTRIC)); 
            $this->logger->debug('sub distric name'.$quote->getBillingAddress()->getData(LayoutProcessor::SUB_DISTRIC)); 
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }

    /**
     * @param $order
     * @param $quote
     * @return $this
     */
    private function orderBillingAddressFields($order, $quote)
    {
        $order->getBillingAddress()->setData(
            LayoutProcessor::DISTRIC,
            $quote->getBillingAddress()->getData(LayoutProcessor::DISTRIC)
        );

        $order->getBillingAddress()->setData(
            LayoutProcessor::SUB_DISTRIC,
            $quote->getBillingAddress()->getData(LayoutProcessor::SUB_DISTRIC)
        )->save();

        return $this;
    }

    /**
     * @param $order
     * @param $quote
     * @return $this
     */
    private function orderShippingAddressFields($order, $quote)
    {
        $order->getShippingAddress()->setData(
            LayoutProcessor::DISTRIC,
            $quote->getShippingAddress()->getData(LayoutProcessor::DISTRIC)
        );

        $order->getShippingAddress()->setData(
            LayoutProcessor::SUB_DISTRIC,
            $quote->getShippingAddress()->getData(LayoutProcessor::SUB_DISTRIC)
        )->save();

        return $this;
    }
}
