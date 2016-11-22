<?php

namespace Fruty\Voters\Strategies;

use Fruty\Voters\Contracts\VoterInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;
use Fruty\Voters\VoterCollection;

class OneGrantedEnoughDecisionStrategy extends AbstractDecisionStrategy
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
        $abstain = 0;
        $denied  = 0;
        
        foreach ($voters->iterator() as $voter) {
            
            $weight = $this->getVoterWeight($voter);
            $vote = $voter->vote($action, $subject, $scope);
            
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