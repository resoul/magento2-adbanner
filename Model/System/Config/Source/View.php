<?php
namespace MRYM\AdBanner\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class View implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'all', 'label' => __('All')],
            ['value' => 'desktop', 'label' => __('Only Desktop')],
            ['value' => 'mobile', 'label' => __('Only Mobile')],
        ];
    }
}