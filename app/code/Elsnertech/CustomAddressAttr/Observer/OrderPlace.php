<?php
namespace Elsnertech\CustomAddressAttr\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\AddressRepositoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Quote\Model\QuoteRepository;


class OrderPlace implements ObserverInterface
{
    protected $logger;
    /**
     * @var QuoteRepository
     */
    private $quoteRepository;
    protected $addressRepository;

    public function __construct(
        LoggerInterface $logger,
        QuoteRepository $quoteRepository,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
    )
    {
        $this->logger = $logger;
        $this->quoteRepository = $quoteRepository;
        $this->addressRepository = $addressRepository;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
    $order = $observer->getEvent()->getOrder();
    $quote = $this->quoteRepository->get($order->getQuoteId());
    $shippingAddress = $quote->getShippingAddress();
    $customerAddressID = $shippingAddress->getCustomerAddressId();
    $address = $this->addressRepository->getById($customerAddressID);
    $address->setCustomAttribute('sub_distric',$shippingAddress->getSubDistric());
    $address->setCustomAttribute('distric',$shippingAddress->getDistric());
    
    // update what ever you want
    $this->addressRepository->save($address);
    $this->logger->debug('get Distric name --->'.$shippingAddress->getDistric()); 
    $this->logger->debug('getSubDistric name  --->'.$shippingAddress->getSubDistric()); 
    }
    
}