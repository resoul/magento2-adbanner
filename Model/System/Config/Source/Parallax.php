<?php
namespace MRYM\AdBanner\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Parallax implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('No')],
            ['value' => 1, 'label' => __('Yes')],
        ];
    }
}