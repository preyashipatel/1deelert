<?php

namespace Elsnertech\Customisation\Plugin;

class FormPost
{
    public function afterExecute(\Magento\Customer\Controller\Address\FormPost $subject, $result){
        if($subject->_request->getParam('checkout') == true){
            $url = $this->_buildUrl('checkout', ['_secure' => true]);
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->success($url));  
        }else{
            $url = $this->_buildUrl('*/*/index', ['_secure' => true]);
            return $this->resultRedirectFactory->create()->setUrl($this->_redirect->success($url));
        }
    }
}