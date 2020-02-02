<?php
namespace MRYM\AdBanner\Block\Adminhtml\Banner\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Container;
use Magento\Framework\UrlInterface;

class ConversionButton extends Container
{
    protected $url;

    public function __construct(Context $context, UrlInterface $url, array $data = [])
    {
        $this->url = $url;
        parent::__construct($context, $data);
    }

    /**
     * Block constructor adds buttons
     *
     */
    protected function _construct()
    {
        $this->addButton(
            'update_conversion',
            $this->getButtonData()
        );

        parent::_construct();
    }

    public function getButtonData()
    {
        return [
            'label' => __('Update Conversion'),
            'on_click' => sprintf("setLocation('%s')", $this->_getConversionUrl()),
            'class' => 'view disable',
            'sort_order' => 20
        ];
    }

    protected function _getConversionUrl()
    {
        $sourceUrl = $this->getUrl('adbanner/banner/conversion');

        return $sourceUrl;
    }
}