<?php

namespace Elsnertech\Homeslider\Api\Data;

interface HomesliderInterface
{
    const ID = 'id';
    const Image_Text = 'image_text';
	const I_LINK = 'link';
    const IMAGE = 'image';
  
  
    public function getId();

    public function setId($id);

    public function getImageText();

    public function setImageText($imageText);
	
	public function setLink($link);
	public function getLink();
}
