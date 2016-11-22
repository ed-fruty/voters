<?php
namespace Fruty\Voters\Contracts;

/**
 * Interface VoterInterface
 * @package Fruty\Voters\Contracts
 */
interface VoterInterface
{
    const DEFAULT_WEIGHT = 1;

    const ACCESS_GRANTED = 1;
    const ACCESS_ABSTAIN = 0;
    const ACCESS_DENIED = -1;

    /**
     * Check is action for subject is supports.
     *
     * @param VoterScopeInterface $scope
     * 
     * @return bool
     */
    public function supports(VoterScopeInterface $scope);

    /**
     * Make a vote.
     *
     * @param VoterScopeInterface $scope
     * 
     * @return int
     */
    public function vote(VoterScopeInterface $scope);
}