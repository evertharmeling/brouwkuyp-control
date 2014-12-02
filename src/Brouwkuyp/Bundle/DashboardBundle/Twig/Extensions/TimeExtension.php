<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Twig\Extensions;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class TimeExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('minutes', [$this, 'filterMinutes']),
        ];
    }

    /**
     * @param integer $seconds
     * @return integer
     */
    public function filterMinutes($seconds)
    {
        return (int) $seconds / 60;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'brouwkuyp_dashboard_time';
    }
}
