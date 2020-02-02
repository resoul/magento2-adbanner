<?php
namespace MRYM\AdBanner\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Permission implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'all', 'label' => __('For All')],
            ['value' => 'onlyCustomer', 'label' => __('Only For Customers')],
            ['value' => 'onlyVisitor', 'label' => __('Only For Visitors')],
        ];
    }
}