<?php

namespace Fruty\Voters;

use Fruty\Voters\Contracts\AdulterationVoterInterface;
use Fruty\Voters\Contracts\PollingInterface;
use Fruty\Voters\Contracts\VoterInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;

/**
 * Class Polling
 * @package Fruty\Voters
 */
class Polling implements PollingInterface
{
    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var array
     */
    protected $results = [
        VoterInterface::ACCESS_GRANTED => 0,
        VoterInterface::ACCESS_DENIED  => 0,
        VoterInterface::ACCESS_ABSTAIN => 0,
    ];

    /**
     * @var bool
     */
    protected $isOpened = true;

    /**
     * Apply voter vote.
     *
     * @param VoterInterface $voter
     * @param VoterScopeInterface $scope
     */
    public function apply(VoterInterface $voter, VoterScopeInterface $scope)
    {
        $weight = $this->getVoterWeight($voter);
        $vote = $voter->vote($scope);
        
        ++$this->count;

        switch (true) {
            case VoterInterface::ACCESS_GRANTED === $vote || $vote === true:
                $this->results[VoterInterface::ACCESS_GRANTED]+= $weight;
                break;

            case VoterInterface::ACCESS_DENIED === $vote || $vote === false:
                $this->results[VoterInterface::ACCESS_DENIED]+= $weight;
                break;

            default:
                $this->results[VoterInterface::ACCESS_ABSTAIN]+= $weight;
        }
    }

    /**
     * @param VoterInterface $voter
     * @return float|int
     */
    protected function getVoterWeight(VoterInterface $voter)
    {
        return $voter instanceof AdulterationVoterInterface
            ?   $voter->getWeight()
            :   VoterInterface::DEFAULT_WEIGHT;
    }

    /**
     * Check is polling opened.
     *
     * @return bool
     */
    public function isOpened()
    {
        return $this->isOpened;
    }

    /**
     * Close polling.
     *
     */
    public function close()
    {
        $this->isOpened = false;
    }

    /**
     * Check is exists votes for given type.
     *
     * Supported types:
     *      VoterInterface::ACCESS_GRANTED,
     *      VoterInterface::ACCESS_DENIED,
     *      VoterInterface::ACCESS_ABSTAIN
     *
     * @param int $type
     *
     * @return bool
     */
    public function has($type)
    {
        return isset($this->results[$type]) ? $this->results[$type] > 0 : false;
    }

    /**
     * Get votes summary for given type.
     *
     * Supported types:
     *      VoterInterface::ACCESS_GRANTED,
     *      VoterInterface::ACCESS_DENIED,
     *      VoterInterface::ACCESS_ABSTAIN
     *
     * @param int $type
     *
     * @return int|float
     */
    public function summary($type)
    {
        return isset($this->results[$type]) ? $this->results[$type] : 0;
    }

    /**
     * Get number of voted voters.
     *
     * @return int
     */
    public function count()
    {
        return $this->count;
    }
}