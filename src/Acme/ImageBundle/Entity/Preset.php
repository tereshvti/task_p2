<?php

namespace Acme\ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Preset
 */
class Preset
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $preset_name;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set preset-name
     *
     * @param string $presetName
     * @return Preset
     */
    public function setPresetName($presetName)
    {
        $this->preset_name = $presetName;
    
        return $this;
    }

    /**
     * Get preset-name
     *
     * @return string 
     */
    public function getPresetName()
    {
        return $this->preset-name;
    }

    /**
     * Set mode
     *
     * @param string $mode
     * @return Preset
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    
        return $this;
    }

    /**
     * Get mode
     *
     * @return string 
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Preset
     */
    public function setWidth($width)
    {
        $this->width = $width;
    
        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Preset
     */
    public function setHeight($height)
    {
        $this->height = $height;
    
        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }
}
