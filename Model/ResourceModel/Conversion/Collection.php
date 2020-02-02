<?php
namespace MRYM\AdBanner\Model\ResourceModel\Conversion;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialization here
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MRYM\AdBanner\Model\Conversion', 'MRYM\AdBanner\Model\ResourceModel\Conversion');
    }

    public function setRecord($key, $count, $unique = false)
    {
        $connection = $this->getConnection();

        if ($unique) {
            $sql = "update mg_mrym_ad_banners set clicks_unique = '" . (int) $count . "' where identifier = '" . $key . "'";
        } else {
            $sql = "update mg_mrym_ad_banners set clicks = '" . (int) $count . "' where identifier = '" . $key . "'";
        }

        $connection->query($sql);
    }

    public function getUniqueRecords()
    {
        $select = "select count(m.key) as uniqueCount, m.key from (SELECT mr.key FROM mg_mrym_ad_conversion mr group by mr.key, mr.session_id) m group by m.key";

        $connection = $this->getConnection();
        $result = $connection->fetchAssoc($select);

        if ($result) {
            return $result;
        }

        return [];
    }

    public function getRecords()
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from(
            ['mr' => $this->getTable('mrym_ad_conversion')],
            ['COUNT(mr.session_id) as count', 'mr.key'])->group('mr.key');

        $result = $connection->fetchAssoc($select);

        if ($result) {
            return $result;
        }

        return [];
    }
}