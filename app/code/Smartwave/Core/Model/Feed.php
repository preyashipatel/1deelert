<?php

namespace Smartwave\Core\Model;

class Feed extends \Magento\AdminNotification\Model\Feed
{
    public const SMARTWAVE_FEED_URL = 'www.portotheme.com/envato/porto2_notifications.rss';

    /**
     * Comment of getFeedUrl function
     *
     * @return void
     */
    public function getFeedUrl()
    {
        $httpPath = $this->_backendConfig->isSetFlag(self::XML_USE_HTTPS_PATH) ? 'https://' : 'http://';
        if ($this->_feedUrl === null) {
            $this->_feedUrl = $httpPath . self::SMARTWAVE_FEED_URL;
        }
        return $this->_feedUrl;
    }

    /**
     * Comment of getLastUpdate function
     *
     * @return void
     */
    public function getLastUpdate()
    {
        return $this->_cacheManager->load('smartwave_notifications_lastcheck');
    }

    /**
     * Comment of setLastUpdate function
     *
     * @return void
     */
    public function setLastUpdate()
    {
        $this->_cacheManager->save(time(), 'smartwave_notifications_lastcheck');
        return $this;
    }
}
