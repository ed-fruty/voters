<?php
namespace Fruty\Voters\Contracts;

/**
 * Interface DecisionManagerInterface
 * @package Fruty\Voters\Contracts
 */
interface DecisionManagerInterface
{
    /**
     * Set strategy.
     * 
     * @param DecisionStrategyInterface $strategy
     */
    public function setStrategy(DecisionStrategyInterface $strategy);

    /**
     * Get strategy.
     * 
     * @return DecisionStrategyInterface
     */
    public function getStrategy();

    /**
     * Add new voter.
     * 
     * @param VoterInterface $voter
     */
    public function push(VoterInterface $voter);

    /**
     * Make a decision.
     *
     * @param string $action
     * @param object $subject
     * @param object $candidate
     * @param array  $parameters
     * 
     * @return bool
     */
    public function decide($action, $subject, $candidate = null, array $parameters = []);
}
