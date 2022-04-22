<?php
/**
 * Copyright © Nathan W. Casebolt.
 * See LICENSE.txt for license details.
 */

namespace Nwcasebolt\OrderEmails\Ui\DataProvider\OrderEmails;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

/**
 * Provides collection of order data
 */
class Collection extends SearchResult
{
    /**
     * Override _initSelect to add custom columns
     *
     * @return void
     */
    protected function _initSelect() //phpcs:ignore
    {
        $this->addFilterToMap('entity_id', 'main_table.entity_id');
        parent::_initSelect();
    }
}
