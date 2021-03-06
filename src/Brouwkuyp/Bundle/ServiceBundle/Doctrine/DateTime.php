<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Doctrine;

/**
 * Custom DateTime class to support having a datetime as primary key
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class DateTime extends \DateTime
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format('U');
    }
}
