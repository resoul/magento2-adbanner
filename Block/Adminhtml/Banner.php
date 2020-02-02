<?php
namespace MRYM\AdBanner\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Admin banner
 */
class Banner extends Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml';
        $this->_blockGroup = 'MRYM_AdBanner';
        $this->_headerText = __('Banner');
        $this->_addButtonLabel = __('Add New Banner');

        parent::_construct();
    }
}