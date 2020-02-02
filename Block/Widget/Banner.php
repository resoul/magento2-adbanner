<?php
namespace MRYM\AdBanner\Block\Widget;

use Magento\Customer\Model\Session;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use MRYM\AdBanner\Model\BannerFactory;

class Banner extends Template implements BlockInterface, IdentityInterface
{
    protected $_template = "widget/banner/default.phtml";

    protected static $_widgetUsageMap = [];

    protected $_blockFactory;

    private $block;

    private $customerSession;

    public function __construct(Context $context, BannerFactory $blockFactory, Session $session, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_blockFactory = $blockFactory;
        $this->customerSession = $session;
    }

    public function getBannerSettings()
    {
        $title = $this->getData('title_text');
        $height = $this->getData('height');
        if (empty($height)) {
            $height = 350;
        }

        $css = [
            'all' => 'isAll',
            'desktop' => 'isOnlyDesktop',
            'mobile' => 'isOnlyMobile',
        ];

        $settings = [
            'title' => !empty($title) ? '<h2 class="image-widget-headline">'.$title.'</h2>' : '',
            'blockClass' => $this->getData('is_parallax') ? 'block-widget block-with-parallax' : 'block-widget block-with-out-parallax',
            'imgClass' => $this->getData('is_parallax') ? 'img-parallax' : 'img',
            'style' => $css[$this->getData('view')],
            'height' => $height,
            'url-key' => $this->generateUrlKey(),
        ];

        return $settings;
    }

    public function canView()
    {
        $permission = $this->getData('permission');
        $customer = $this->customerSession->isLoggedIn();

        if ($permission == 'all') {
            return true;
        } else if ($permission == 'onlyCustomer' && $customer) {
            return true;
        } else if ($permission == 'onlyVisitor' && !$customer) {
            return true;
        }

        return false;
    }

    public function getImage($class)
    {
        $banner = $this->getBlock();
        $image = $banner->getData('image');
        $media_folder = $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        return '<img src="' . $media_folder . $image . '" class="'.$class.'" data-speed="-1" alt="'.$banner->getData('alt').'" />';
    }

    protected function generateUrlKey()
    {
        $banner = $this->getBlock();
        $url = $banner->getData('url');
        $key = http_build_query(['adId' => $banner->getData('identifier')]);

        if (strpos($url, '?') === false) {
            return $url . '?' . $key;
        } else {
            return $url . '&' . $key;
        }
    }

    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $blockId = $this->getData('banner_id');
        $blockHash = get_class($this) . $blockId;

        if (isset(self::$_widgetUsageMap[$blockHash])) {
            return $this;
        }
        self::$_widgetUsageMap[$blockHash] = true;

        unset(self::$_widgetUsageMap[$blockHash]);
        return $this;
    }

    private function getBlock()
    {
        if ($this->block) {
            return $this->block;
        }

        $blockId = $this->getData('banner_id');

        if ($blockId) {
            try {
                $storeId = $this->_storeManager->getStore()->getId();
                /** @var \MRYM\AdBanner\Model\Banner $block */
                $block = $this->_blockFactory->create();
                $block->setStoreId($storeId)->load($blockId);
                $this->block = $block;

                return $block;
            } catch (NoSuchEntityException $e) {
            }
        }

        return null;
    }

    public function getIdentities()
    {
        $block = $this->getBlock();

        if ($block) {
            return $block->getIdentities();
        }

        return [];
    }
}