<?php

namespace Elsnertech\Customisation\Controller\Address;

class FormPost extends \Magento\Customer\Controller\Address\FormPost
{
    public function execute()
    {
        $redirectUrl = null;
        if (!$this->_formKeyValidator->validate($this->getRequest())) {
            return $this->resultRedirectFactory->create()->setPath('*/*/');
        }

        if (!$this->getRequest()->isPost()) {
            $this->_getSession()->setAddressFormData($this->getRequest()->getPostValue());
            return $this->resultRedirectFactory->create()->setUrl(
                $this->_redirect->error($this->_buildUrl('*/*/edit'))
            );
        }
        
        try {
            $address = $this->_extractAddress();
            if ($this->_request->getParam('delete_attribute_value')) {
                $address = $this->deleteAddressFileAttribute($address);
            }
            $this->_addressRepository->save($address);
            $this->messageManager->addSuccessMessage(__('You saved the address.'));
            $url = $this->_buildUrl('*/*/index', ['_secure' => true]);
            if($this->_request->getParam('checkout') == true){
                $url = $this->_buildUrl('checkout', ['_secure' => true]);
                return $this->resultRedirectFactory->create()->setUrl($this->_redirect->success($url));  
            }else{
                $url = $this->_buildUrl('*/*/index', ['_secure' => true]);
                return $this->resultRedirectFactory->create()->setUrl($this->_redirect->success($url));
            }
        } catch (InputException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            foreach ($e->getErrors() as $error) {
                $this->messageManager->addErrorMessage($error->getMessage());
            }
        } catch (\Exception $e) {
            $redirectUrl = $this->_buildUrl('*/*/index');
            $this->messageManager->addExceptionMessage($e, __('We can\'t save the address.'));
        }

        $url = $redirectUrl;
        if (!$redirectUrl) {
            $this->_getSession()->setAddressFormData($this->getRequest()->getPostValue());
            $url = $this->_buildUrl('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $this->resultRedirectFactory->create()->setUrl($this->_redirect->error($url));
    }
}