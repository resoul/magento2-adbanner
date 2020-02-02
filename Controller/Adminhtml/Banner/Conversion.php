<?php
namespace MRYM\AdBanner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;

class Conversion extends Action
{
    private $conversion;

    protected $resultPageFactory;

    public function execute()
    {
        $conversion = $this->_objectManager->create(\MRYM\AdBanner\Model\ResourceModel\Conversion\Collection::class);

        $records = $conversion->getRecords();
        $uniqueRecords = $conversion->getUniqueRecords();
        /** @var ConversionCollection $records */
        foreach ($records as $record) {
            $conversion->setRecord($record['key'], $record['count'],false);
        }

        foreach ($uniqueRecords as $record) {
            $conversion->setRecord($record['key'], $record['uniqueCount'],true);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $this->messageManager->addSuccessMessage(__('The conversion has been updated.'));

        return $resultRedirect->setPath('*/*/');
    }
}