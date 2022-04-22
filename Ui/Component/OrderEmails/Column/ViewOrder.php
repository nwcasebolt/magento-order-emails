<?php
/**
 * Copyright © Nathan W. Casebolt.
 * See LICENSE.txt for license details.
 */

namespace Nwcasebolt\OrderEmails\Ui\Component\OrderEmails\Column;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Prepares data source for View Order action column
 */
class ViewOrder extends Column
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

    /**
     * @var string
     */
    protected string $viewOrder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param string $viewOrder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        $viewOrder = '',
        array $components = [],
        array $data = []
    ) {
        $this->url = $urlBuilder;
        $this->viewOrder    = $viewOrder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name]['view']   = [
                        'href'  => $this->url->getUrl(
                            $this->viewOrder,
                            ['order_id' => $item['entity_id']]
                        ),
                        'target' => '_blank',
                        'label' => __('View Order')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
