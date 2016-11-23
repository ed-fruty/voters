<?php

namespace Fruty\Voters\Strategies;

use Fruty\Voters\Contracts\PollingInterface;
use Fruty\Voters\Contracts\VoterInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;
use Fruty\Voters\VoterCollection;

/**
 * Class VoteStrategy
 * @package Fruty\Voters\Strategies
 */
class MoreVotesDecisionStrategy extends AbstractDecisionStrategy
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
        $granted = 0;
        $denied  = 0;
        $abstain = 0;
        
        foreach ($voters->iterator() as $voter) {
            
            // Get voter voice value
            $weight = 0; // $this->getVoterWeight($voter);
            $vote = false; // $voter->vote($action, $subject, $scope);
            
            switch (true) {

                case VoterInterface::ACCESS_GRANTED === $vote || $vote === true:
                    $granted+= $weight;
                    break;

                case VoterInterface::ACCESS_DENIED === $vote || $vote === false:
                    $denied+= $weight;
                    break;
                    
                default:
                    $abstain+= $weight;
            }
        }
        
        // Granted voices more
        if ($granted > $denied) {
            return true;
        }
        
        // Denied voices more
        if ($denied > $granted) {
            return false;
        }
        
        // Granted and denied voices are equals
        if ($granted == $denied && $granted != 0) {
            return $this->allowIfEqualGrantedDenied;
        }
        
        // All voters abstain
        return $this->allowIfAllAbstain;
    }
}