<?php
namespace MRYM\AdBanner\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Conversion extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mrym_ad_conversion';

    protected function _construct()
    {
        $this->_init('MRYM\AdBanner\Model\ResourceModel\Conversion');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}