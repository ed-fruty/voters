<?php
namespace Fruty\Voters\Contracts;

/**
 * Interface CommitteeInterface
 * @package Fruty\Voters\Contracts
 */
interface CommitteeInterface
{
    /**
     * Create a new voter scope instance.
     *
     * @param $action
     * @param $subject
     * @param $candidate
     * @param array $parameters
     * 
     * @return VoterScopeInterface
     */
    public function newScope($action, $subject, $candidate, array $parameters = []);

    /**
     * Create a new polling instance.
     *
     * @return PollingInterface
     */
    public function newPolling();
}