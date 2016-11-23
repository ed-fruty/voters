<?php

namespace Fruty\Voters\Strategies;

use Fruty\Voters\Contracts\PollingInterface;
use Fruty\Voters\Contracts\VoterInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;
use Fruty\Voters\VoterCollection;

class OneGrantedEnoughDecisionStrategy extends AbstractDecisionStrategy
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
        $abstain = 0;
        $denied  = 0;
        
        foreach ($voters->iterator() as $voter) {
            
            $weight = 0; //$this->getVoterWeight($voter);
            $vote = false; //$voter->vote($action, $subject, $scope);
            
            switch (true) {
                case VoterInterface::ACCESS_GRANTED === $vote || $vote === true:

                    return true;
                
                case VoterInterface::ACCESS_DENIED === $vote || $vote === false:
                    $denied+= $weight;
                    break;
                
                default:
                    $abstain+= $weight;
            }
        }
        
        if ($denied > 0) {
            return false;
        }
        
        return $this->allowIfAllAbstain;
    }
}