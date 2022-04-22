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
 * Prepares data source for Send Email action column
 */
class SendEmail extends Column
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $url;

    /**
     * @var string
     */
    protected string $sendConfEmail;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param string $sendConfEmail
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        $sendConfEmail = '',
        array $components = [],
        array $data = []
    ) {
        $this->url = $urlBuilder;
        $this->sendConfEmail = $sendConfEmail;
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
                    $item[$name]['view'] = [
                        'href'  => $this->url->getUrl(
                            $this->sendConfEmail,
                            ['order_id' => $item['entity_id']]
                        ),
                        'target' => '_blank',
                        'label' => __('Send Email')
                    ];
                }
            }
        }
        return $dataSource;
    }
}
