<?php

namespace Elsnertech\Homeslider\Api\Data;

interface HomesliderInterface
{
    public const ID = 'id';
    public const IMAGE_TEXT = 'image_text';
    public const I_LINK = 'link';
    public const IMAGE = 'image';
  
    /**
     * Commet getId function
     *
     * @return void
     */
    public function getId();
    /**
     * Comment setId function
     *
     * @param int $id
     * @return void
     */
    public function setId($id);
    /**
     * Comment getImageText function
     *
     * @return void
     */
    public function getImageText();
    /**
     * Comment setImageText function
     *
     * @param string $imageText
     * @return void
     */
    public function setImageText($imageText);
    /**
     * Comment setLink function
     *
     * @param string $link
     * @return void
     */
    public function setLink($link);
    /**
     *  Comment getLink function
     *
     * @return void
     */
    public function getLink();
}
