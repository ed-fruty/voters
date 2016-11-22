<?php
namespace Fruty\Voters\Contracts;

/**
 * Interface HasRateInterface
 * @package Fruty\Voters\Contracts
 */
interface AdulterationVoterInterface
{
    /**
     * Get rate value.
     * 
     * @return float|int
     */
    public function getWeight();
}
