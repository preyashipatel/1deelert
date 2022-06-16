<?php
namespace Elsner\Pwa\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

class Manifest extends \Magento\Framework\Model\AbstractModel
{
	protected $_helper;

    protected $_objectmanager;

	public function __construct(
        \Magento\Framework\Model\Context $context,
        \Elsner\Pwa\Helper\Data $helper,
        \Magento\Framework\ObjectManagerInterface $objectmanager
    ) {
       
        $this->_helper = $helper;
        $this->_objectmanager = $objectmanager;
    }

    public function createFile()
    {
        $scopeConfigInterface = $this->_objectmanager
            ->get('\Magento\Framework\App\Config\ScopeConfigInterface');
        $icon = $this->_helper->getIconUrl();

        $content = "

        'use strict';
         
        const cacheName = '".$this->_helper->getBaseUrl()."-superpwa-2.0.2';
        const startPage = '".$this->_helper->getBaseUrl()."';
        const offlinePage = '".$this->_helper->getBaseUrl()."';
        const filesToCache = [startPage, offlinePage];
        const neverCacheUrls = [/\/checkout/,/\/customer\/account\/login/,/preview=true/];

        self.addEventListener('install', function(e) {
            console.log('SuperPWA service worker installation');
            e.waitUntil(
                caches.open(cacheName).then(function(cache) {
                    console.log('SuperPWA service worker caching dependencies');
                    filesToCache.map(function(url) {
                        return cache.add(url).catch(function (reason) {
                            return console.log('SuperPWA: ' + String(reason) + ' ' + url);
                        });
                    });
                })
            );
        });

        self.addEventListener('activate', function(e) {
            console.log('SuperPWA service worker activation');
            e.waitUntil(
                caches.keys().then(function(keyList) {
                    return Promise.all(keyList.map(function(key) {
                        if ( key !== cacheName ) {
                            console.log('SuperPWA old cache removed', key);
                            return caches.delete(key);
                        }
                    }));
                })
            );
            return self.clients.claim();
        });

       
        self.addEventListener('fetch', function(e) {
        
            if ( ! neverCacheUrls.every(checkNeverCacheList, e.request.url) ) {
              console.log( 'SuperPWA: Current request is excluded from cache.' );
              return;
            }
            
            if ( ! e.request.url.match(/^(http|https):\/\//i) )
                return;
            
            if ( new URL(e.request.url).origin !== location.origin )
                return;
            
            if ( e.request.method !== 'GET' ) {
                e.respondWith(
                    fetch(e.request).catch( function() {
                        return caches.match(offlinePage);
                    })
                );
                return;
            }
            
            if ( e.request.mode === 'navigate' && navigator.onLine ) {
                e.respondWith(
                    fetch(e.request).then(function(response) {
                        return caches.open(cacheName).then(function(cache) {
                            cache.put(e.request, response.clone());
                            return response;
                        });  
                    })
                );
                return;
            }

            e.respondWith(
                caches.match(e.request).then(function(response) {
                    return response || fetch(e.request).then(function(response) {
                        return caches.open(cacheName).then(function(cache) {
                            cache.put(e.request, response.clone());
                            return response;
                        });  
                    });
                }).catch(function() {
                    return caches.match(offlinePage);
                })
            );
        });

        function checkNeverCacheList(url) {
            if ( this.match(url) ) {
                return false;
            }
            return true;
        }
        ";
        try {
            $fileToSave = $this->_objectmanager
                    ->get('\Magento\Framework\App\Filesystem\DirectoryList')
                    ->getPath(DirectoryList::ROOT) . \DIRECTORY_SEPARATOR . 'superpwa-sw.js';
            if (file_exists($fileToSave)) {
                $this->_objectmanager
                    ->get('\Magento\Framework\Filesystem\Io\File')
                    ->rm($fileToSave);
            }
            file_put_contents($fileToSave, $content);
            chmod($fileToSave, 0777);

        } catch (\Exception $exception) {

        }

        if ($scopeConfigInterface->getValue('elsner/homescreen/homescreen_enable')) {
            $appName = $this->_helper->getAppname();
            $appShortName = $this->_helper->getAppSortName();
            $themeColor = $this->_helper->getThemeColor();
            $backgroundColor = $this->_helper->getBackgroundColor();

            $manifestContent = '{
              "short_name": "' . $appShortName . '",
              "name": "' . $appName . '",
              "icons": [
                {
                  "src": "' . $icon . '",
                  "sizes": "192x192",
                  "type": "image/png"
                },
                {
                  "src": "' . $icon . '",
                  "sizes": "256x256",
                  "type": "image/png"
                },
                {
                  "src": "' . $icon . '",
                  "sizes": "384x384",
                  "type": "image/png"
                },
                {
                  "src": "' . $icon . '",
                  "sizes": "512x512",
                  "type": "image/png"
                }
              ],
              "start_url": "'.$this->_helper->getBaseUrl().'",
              "display": "standalone",
              "theme_color": "' . $themeColor . '",
              "background_color": "'.$backgroundColor.'"
            }';
            $fileToSave = $this->_objectmanager
                    ->get('\Magento\Framework\App\Filesystem\DirectoryList')
                    ->getPath(DirectoryList::ROOT) . \DIRECTORY_SEPARATOR . 'manifest.json';
            if (file_exists($fileToSave)) {
                $this->_objectmanager
                    ->get('\Magento\Framework\Filesystem\Io\File')
                    ->rm($fileToSave);
            }
            file_put_contents($fileToSave, $manifestContent);
            chmod($fileToSave, 0777);
        } else {
            $fileToSave = $this->_objectmanager
                    ->get('\Magento\Framework\App\Filesystem\DirectoryList')
                    ->getPath(DirectoryList::ROOT) . \DIRECTORY_SEPARATOR . 'manifest.json';
            if (file_exists($fileToSave)) {
                $this->_objectmanager
                    ->get('\Magento\Framework\Filesystem\Io\File')
                    ->rm($fileToSave);
            }
        }
    }

}