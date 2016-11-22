<?php

namespace Fruty\Voters\Strategies;

use Fruty\Voters\Contracts\PollingInterface;
use Fruty\Voters\Contracts\VoterInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;
use Fruty\Voters\VoterCollection;

/**
 * Class AllGrantedDecisionStrategy
 * @package Fruty\Voters\Strategies
 */
class AllGrantedDecisionStrategy extends AbstractDecisionStrategy
{
    /**
     * Make a decision.
     *
     * @param VoterCollection $voters
     * @param VoterScopeInterface $scope
     * @param PollingInterface $polling
     * 
     * @return bool
     */
    public function decide(VoterCollection $voters, VoterScopeInterface $scope, PollingInterface $polling)
    {
        $voters->each(function(VoterInterface $voter) use ($scope, $polling) {

            /*
             * Check is polling opened yet
             */
            if ($polling->isOpened()) {

                /*
                 * Accept voter vote
                 */ 
                $polling->apply($voter, $scope);

                /*
                 * Close polling if at least one voter gave denied access.
                 */
                if ($polling->has(VoterInterface::ACCESS_DENIED)) {
                    $polling->close();
                }
            }
        });
        
        /**
         * If exists at least one denied access - return false.
         */
        if ($polling->has(VoterInterface::ACCESS_DENIED)) {
            return false;
        }
        
        /**
         * If all voted voters gave granted access - return true.
         */
        if ($polling->has(VoterInterface::ACCESS_GRANTED)) {
            return true;
        }

        /**
         * If all voters gave an abstain vote - return configured boolen value (default true).
         */
        return $this->allowIfAllAbstain;
    }
}