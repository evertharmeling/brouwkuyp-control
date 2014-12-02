<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Twig\Extensions;

use Brouwkuyp\Bundle\LogicBundle\Model\Phase;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class S88Extension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('renderPhaseValue', [$this, 'renderPhaseValue']),
        ];
    }

    /**
     * @param Phase $phase
     * @return string
     */
    public function renderPhaseValue(Phase $phase)
    {
        switch ($phase->getType()) {
            case Phase::CONTROL_TEMP:
                return $phase->getValue() . ' °C';
            case Phase::ADD_INGREDIENTS:
                // @todo is this always in grams?
                return number_format($phase->getValue(), 0, ',', '.') . ' gram';
            default:
                return $phase->getValue();
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'brouwkuyp_dashboard_s88';
    }
}
