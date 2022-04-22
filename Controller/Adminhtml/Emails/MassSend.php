<?php
/**
 * Copyright © Nathan W. Casebolt.
 * See LICENSE.txt for license details.
 */
namespace Nwcasebolt\OrderEmails\Controller\Adminhtml\Emails;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

/**
 * Mass Send action for order emails
 */
class MassSend extends Action
{
    /**
     * Redirect url
     */
    const REDIRECT_URL = 'orderemails/orders';

    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;

    /**
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @var OrderSender
     */
    protected OrderSender $orderSender;

    /**
     * @param CollectionFactory $collectionFactory
     * @param Context $context
     * @param Filter $filter
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderSender $orderSender
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Context $context,
        Filter $filter,
        OrderRepositoryInterface $orderRepository,
        OrderSender $orderSender
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->orderSender = $orderSender;
        $this->filter = $filter;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $orderIds = $collection->getAllIds();
        try {
            $this->processItems($orderIds);
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                __('An error occurred during mass sending of order confirmation emails. Please review log and try again.') //phpcs:ignore
            );
        }
        $this->messageManager->addSuccessMessage(
            __(count($orderIds) . ' order confirmation emails sent.')
        );

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath(static::REDIRECT_URL);
    }

    /**
     * Process mass deletion of selected or excluded items
     *
     * @param array|null $orderIds
     * @return void
     */
    protected function processItems(?array $orderIds)
    {
        foreach ($orderIds as $orderId) {
            /** @var Order $order */
            $order = $this->orderRepository->get($orderId);
            $this->orderSender->send($order, true);
        }
    }
}
