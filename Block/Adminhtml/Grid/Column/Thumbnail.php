<?php
namespace MRYM\AdBanner\Block\Adminhtml\Grid\Column;

use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Framework\UrlInterface;

/**
 * Admin blog grid statuses 
 */
class Thumbnail extends Column
{
    protected $storeManager;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeManager = $context->getStoreManager();
    }

    /**
     * Add to column decorated status
     *
     * @return array
     */
    public function getFrameCallback()
    {
        return [$this, 'decorateImage'];
    }

    /**
     * Decorate image column values
     *
     * @param string $value
     * @param  \Magento\Framework\Model\AbstractModel $row
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @param bool $isExport
     * @return string
     */
    public function decorateImage($value, $row, $column, $isExport)
    {
        if ($row->getImage()) {
            $media_folder = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

            $value = '<img src="' . $media_folder . $value . '" />';
        }

        return $value;
    }
}
