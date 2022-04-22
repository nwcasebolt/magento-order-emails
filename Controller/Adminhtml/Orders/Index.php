<?php
/**
 * Copyright © Nathan W. Casebolt.
 * See LICENSE.txt for license details.
 */
namespace Nwcasebolt\OrderEmails\Controller\Adminhtml\Orders;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Controller for orderemails/orders/index
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Sales::sales_order_emails');
        $resultPage->addBreadcrumb(__('Order Emails'), __('Order Emails'));
        $resultPage->addBreadcrumb(__('Order Emails'), __('Order Emails'));
        $resultPage->getConfig()->getTitle()->prepend(__('Order Emails'));

        return $resultPage;
    }
}
