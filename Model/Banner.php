<?php
namespace MRYM\AdBanner\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Banner model
 *
 * @method Banner setStoreId(array $storeId)
 * @method array getStoreId()
 */
class Banner extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mrym_ad_banner';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ad_banner';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'adbanner_banner';

    /**
     * Retrieve model title
     * @param  boolean $plural
     * @return string
     */
    public function getOwnTitle($plural = false)
    {
        return $plural ? 'Banner' : 'Banners';
    }

    protected function _construct()
    {
        $this->_init('MRYM\AdBanner\Model\ResourceModel\Banner');
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