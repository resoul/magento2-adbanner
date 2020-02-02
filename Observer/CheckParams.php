<?php
namespace MRYM\AdBanner\Observer;

use Magento\Customer\Model\Session;
use MRYM\AdBanner\Helper\Config;
use Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MRYM\AdBanner\Model\Conversion;
use MRYM\AdBanner\Model\ConversionFactory;
use MRYM\AdBanner\Model\ResourceModel\Banner\Collection;

class CheckParams implements ObserverInterface
{
    /**
     * @var Config $config
    */
    private $config;

    /**
     * @var StoreManagerInterface $storeManager
    */
    private $storeManager;

    /**
     * @var RequestInterface $request
    */
    private $request;

    /**
     * @var Conversion $conversion
    */
    private $conversion;

    private $collection;

    /**
     * @var Session $session
    */
    private $session;

    /**
     * @param RequestInterface $request
     * @return void
     */
    public function __construct(
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        Config $config,
        Collection $collection,
        ConversionFactory $conversion,
        Session $session
    ) {
        $this->request = $request;
        $this->config = $config;
        $this->collection = $collection;
        $this->conversion = $conversion;
        $this->storeManager = $storeManager;
        $this->session = $session;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->config->getConfig('adbanner/general/status') && ($adId = $this->request->getParam('adId'))) {
            if ($this->collection->checkIdentity($adId)) {
                /** @var Conversion $conversion */
                $conversion = $this->conversion->create();
                $conversion->addData([
                    'store_id' => $this->storeManager->getStore()->getId(),
                    'session_id' => $this->session->getSessionId(),
                    'key' => $adId
                ]);
                $conversion->save();
            }
        }
    }
}