<?php

namespace CL\Tissue\Model;

class Detection
{
    const TYPE_VIRUS = 1;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     * @param int    $type
     */
    public function __construct($path, $type = self::TYPE_VIRUS)
    {
        $this->type = $type;
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
