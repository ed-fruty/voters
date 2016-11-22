<?php
namespace Fruty\Voters\Contracts;

use Fruty\Voters\VoterCollection;
use Fruty\Voters\Contracts\CommitteeInterface;

/**
 * Interface DecisionStrategyInterface
 * @package Fruty\Voters\Contracts
 */
interface DecisionStrategyInterface
{
    /**
     * Get strategy name.
     * 
     * @return string
     */
    public function getName();

    /**
     * Set is allow if all abstain decisions.
     * 
     * @param bool $value
     */
    public function allowIfAllAbstain($value);

    /**
     * Set is allow if equals granted and denied decisions.
     * 
     * @param bool $value
     */
    public function allowIfEqualGrantedDenied($value);

    /**
     * Make a decision.
     *
     * @param VoterCollection $voters
     * @param VoterScopeInterface $scope
     * @param PollingInterface $polling
     * 
     * @return bool
     */
    public function decide(VoterCollection $voters, VoterScopeInterface $scope, PollingInterface $polling);

    /**
     * Get committee instance.
     * 
     * @return CommitteeInterface
     */
    public function getCommittee();

    /**
     * Set committee instance.
     *
     * @param CommitteeInterface $committee
     */
    public function setCommittee(CommitteeInterface $committee);
}
