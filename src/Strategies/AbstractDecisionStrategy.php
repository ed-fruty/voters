<?php

namespace Fruty\Voters\Strategies;

use Fruty\Voters\Contracts\CommitteeInterface;
use Fruty\Voters\Contracts\DecisionStrategyInterface;
use Fruty\Voters\Committee;

/**
 * Class AbstractDecisionStrategy
 * 
 * @package Fruty\Voters\Strategies
 */
abstract class AbstractDecisionStrategy implements DecisionStrategyInterface
{
    /**
     * @var bool
     */
    protected $allowIfAllAbstain = false;

    /**
     * @var bool
     */
    protected $allowIfEqualGrantedDenied = false;

    /**
     * @var Committee
     */
    protected $committee;

    /**
     * AbstractDecisionStrategy constructor.
     * 
     * @param CommitteeInterface $committee
     */
    public function __construct(CommitteeInterface $committee = null)
    {
        $this->committee = $committee ?: new Committee();
    }

    /**
     * Get strategy name.
     *
     * @return string
     */
    public function getName()
    {
        return get_called_class();
    }

    /**
     * Set is allow if all abstain decisions.
     *
     * @param bool $value
     */
    public function allowIfAllAbstain($value)
    {
        $this->allowIfAllAbstain = (bool) $value;
    }

    /**
     * Set is allow if equals granted and denied decisions.
     *
     * @param bool $value
     */
    public function allowIfEqualGrantedDenied($value)
    {
        $this->allowIfEqualGrantedDenied = (bool) $value;
    }

    /**
     * Get committee instance.
     * 
     * @return CommitteeInterface
     */
    public function getCommittee()
    {
        return $this->committee;
    }

    /**
     * Set committee instance.
     * 
     * @param CommitteeInterface $committee
     */
    public function setCommittee(CommitteeInterface $committee)
    {
        $this->committee = $committee;
    }
}
