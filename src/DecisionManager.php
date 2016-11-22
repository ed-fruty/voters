<?php

namespace Fruty\Voters;

use CallbackFilterIterator;
use Fruty\Voters\Contracts\DecisionManagerInterface;
use Fruty\Voters\Contracts\DecisionStrategyInterface;
use Fruty\Voters\Contracts\VoterInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;
use Fruty\Voters\Strategies\MoreVotesDecisionStrategy;

/**
 * Class DecisionManager
 * @package Fruty\Voters
 */
class DecisionManager implements DecisionManagerInterface
{
    /**
     * @var DecisionStrategyInterface
     */
    protected $strategy;

    /**
     * @var \ArrayObject
     */
    protected $voters;

    /**
     * DecisionManager constructor.
     * @param DecisionStrategyInterface|null $strategy
     * @param bool $allowIfAllAbstain
     * @param bool $allowIfEqualGrantedDenied
     */
    public function __construct(
        DecisionStrategyInterface $strategy = null, 
        $allowIfAllAbstain = true,
        $allowIfEqualGrantedDenied = false
    )   {
        
        $this->strategy = $strategy ?: new MoreVotesDecisionStrategy();
        $this->strategy->allowIfAllAbstain($allowIfAllAbstain);
        $this->strategy->allowIfEqualGrantedDenied($allowIfEqualGrantedDenied);
        
        $this->voters = new VoterCollection();
    }

    /**
     * Set strategy.
     *
     * @param DecisionStrategyInterface $strategy
     */
    public function setStrategy(DecisionStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Get strategy.
     *
     * @return DecisionStrategyInterface
     */
    public function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * Add new voter.
     *
     * @param VoterInterface $voter
     * @return mixed
     */
    public function push(VoterInterface $voter)
    {
        $this->voters->push($voter);
    }

    /**
     * Make a decision.
     *
     * @param string $action
     * @param object $subject
     * @param object $candidate
     * @param array $parameters
     * 
     * @return bool
     */
    public function decide($action, $subject, $candidate = null, array $parameters = [])
    {
        $committee = $this->strategy->getCommittee();

        $scope   = $committee->newScope($action, $subject, $candidate, $parameters);
        $polling = $committee->newPolling();
            
        // Get only voters which supports given scope.
        $voters = $this->voters->filter(
            function(VoterInterface $voter) use ($scope) {
                return $voter->supports($scope); 
            }
        );

        return $this->strategy->decide($voters, $scope, $polling);
    }
}