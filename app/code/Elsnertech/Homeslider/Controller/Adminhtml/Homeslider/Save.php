<?php
namespace Elsnertech\Homeslider\Controller\Adminhtml\Homeslider;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * $HomesliderFactory variable
     *
     * @var [type]
     */
    protected $HomesliderFactory;
    /**
     * $_storeManager variable
     *
     * @var [type]
     */
    protected $_storeManager;
    /**
     * $_filesystem variable
     *
     * @var [type]
     */
    protected $_filesystem;

    /**
     * Comment of __construct function
     *
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Elsnertech\Homeslider\Model\ResourceModel\Homeslider\CollectionFactory $mymodulemodelFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Backend\App\Action\Context $context,
        \Elsnertech\Homeslider\Model\HomesliderFactory $HomesliderFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Elsnertech\Homeslider\Model\ResourceModel\Homeslider\CollectionFactory $mymodulemodelFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->HomesliderFactory = $HomesliderFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_storeManager = $storeManager;
        $this->_filesystem = $filesystem;
        $this->_mymodulemodelFactory = $mymodulemodelFactory;
        $this->messageManager = $messageManager;
    }

    /**
     * Comment of execute function
     *
     * @return void
     */
    public function execute()
    {
        $id = '';
        $abc = " ";
        $data = $this->getRequest()->getPostValue();
        $newsku = $data['image_text'];
        $link = $data['link'];
        $n = $this->getRequest()->getfiles('image');
        if (isset($data['id'])) {
            $id = $data['id'];
        }
        $files = $this->getRequest()->getFiles()->toArray();
        $filename = $files['image']['name'];
        $coll = $this->_mymodulemodelFactory->create();
        $col1 = $coll->getdata();
        $camweara_images = '/theme/';
        $rowData = $this->HomesliderFactory->create();
        if (!isset($data['id'])) {
            foreach ($coll as $key) {
                $a = $key['image_text'];
                if ($newsku==$a) {
                    $abc = 1;
                    $c=$abc;
                } else {
                    $abc = 0;
                }
            }
            if ($abc==0) {
                if (!empty($n["name"])) {
                            $pathurl = $this->_storeManager->getStore()
                            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                            $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                            $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');
                            // if (!file_exists($mediapath.$camweara_images)) {
                            //     mkdir($mediapath.'slider_images/', 0777, true);
                            // }
                            $path = $mediapath.$camweara_images;
                            move_uploaded_file($files['image']['tmp_name'], $path.$filename);
                            $data['image'] = 'theme/'.$filename;
                } else {
                    $data['image'] = $rowData->getimage();
                }
                    $rowData->setData($data);
                if ($rowData->save()) {
                    $this->messageManager->addSuccessMessage(__('You saved the data.'));

                } else {
                    $this->messageManager->addErrorMessage(__('Data was not saved.'));
                }
                    $this->_redirect('homeslider/homeslider/index');
            } else {
                $this->messageManager->addErrorMessage(__('sku is same please add different SKU'));
                $this->_redirect('homeslider/homeslider/addrow');
            }
        } else {
            $c = " ";
            $rowData->load($id);
            $oldsku = $rowData->getproduct_sku();
            if ($oldsku==$newsku) {
                if (!empty($n["name"])) {
                    $pathurl = $this->_storeManager->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                    $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                    $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');
                    $path = $mediapath.$camweara_images;
                    move_uploaded_file($files['image']['tmp_name'], $path.$filename);
                    $data['image'] = 'homeslider/'.$filename;
                } else {
                    $data['image'] = $rowData->getImage();
                }
                if (!empty($n1["name"])) {
                    $pathurl = $this ->_storeManager->getStore()
                    ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                    $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                    $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');
                    $path = $mediapath.$camweara_images;
                    move_uploaded_file($files['image2']['tmp_name'], $path.$filename1);
                    $data['image2'] = $camweara_images.$filename1;
                } else {
                    if (isset($data['image2']['delete'])) {
                           $data['image2'] = '';
                    } else {
                           $data['image2'] = $rowData->getData('image2');
                    }
                }
                $rowData->addData($data);
                if ($rowData->save()) {
                    $this->messageManager->addSuccessMessage(__('You saved the data.'));
                } else {
                    $this->messageManager->addErrorMessage(__('Data was not saved.'));
                }
                $this->_redirect('homeslider/homeslider/index');
            } else {
                foreach ($coll as $key) {
                    $a = $key['product_sku'];
                    if ($newsku==$a) {
                        $abc = 1;
                        $c=$abc;
                    } else {
                        $abc = 0;
                        $d = 0;
                    }
                }

                if ($c==1 && $d ==0) {
                    $this->messageManager->addErrorMessage(__('sku is same please add different SKU'));
                    $this->_redirect('homeslider/homeslider/addrow');
                } else {
                    if (!empty($n["name"])) {
                              $pathurl = $this ->_storeManager->getStore()
                              ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
                              $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
                              $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');
                             $path = $mediapath.$camweara_images;
                              move_uploaded_file($files['image']['tmp_name'], $path.$filename);
                             $data['image'] = 'theme/'.$filename;
                    } else {
                        $data['image'] = $rowData->getImage();
                    }
                    $rowData->addData($data);
                    if ($rowData->save()) {
                        $this->messageManager->addSuccessMessage(__('You saved the data.'));
                    } else {
                        $this->messageManager->addErrorMessage(__('Data was not saved.'));
                    }
                    $this->_redirect('homeslider/homeslider/index');
                }
            }
        }
    }
}
