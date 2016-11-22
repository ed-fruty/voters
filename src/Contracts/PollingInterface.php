<?php
namespace Fruty\Voters\Contracts;

/**
 * Interface PollingInterface
 * @package Fruty\Voters\Contracts
 */
interface PollingInterface
{
    /**
     * Apply voter vote.
     * 
     * @param VoterInterface $voter
     * @param VoterScopeInterface $scope
     */
    public function apply(VoterInterface $voter, VoterScopeInterface $scope);

    /**
     * Check is polling opened.
     * 
     * @return bool
     */
    public function isOpened();

    /**
     * Close polling.
     *
     */
    public function close();

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
    public function has($type);

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
    public function summary($type);

    /**
     * Get number of voted voters.
     * 
     * @return int
     */
    public function count();
}