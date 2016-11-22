<?php

namespace Voter\Strategies;

use Voter\Contracts\VoterInterface;
use Voter\Contracts\VoterScopeInterface;
use Voter\VoterCollection;

/**
 * Class VoteStrategy
 * @package Voter\Strategies
 */
class MoreVotesDecisionStrategy extends AbstractDecisionStrategy
{
    /**
     * Make a decision.
     *
     * @param VoterCollection $voters
     * @param string $action
     * @param object $subject
     * @param VoterScopeInterface $scope
     * @return bool
     */
    public function decide(VoterCollection $voters, $action, $subject, VoterScopeInterface $scope)
    {
        $granted = 0;
        $denied  = 0;
        $abstain = 0;
        
        foreach ($voters->iterator() as $voter) {
            
            // Get voter voice value
            $weight = $this->getVoterWeight($voter);
            $vote = $voter->vote($action, $subject, $scope);
            
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