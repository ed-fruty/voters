<?php

namespace Fruty\Voters;

use Fruty\Voters\Contracts\CommitteeInterface;
use Fruty\Voters\Contracts\PollingInterface;
use Fruty\Voters\Contracts\VoterScopeInterface;

/**
 * Class Committee
 * @package Fruty\Voter
 */
class Committee implements CommitteeInterface
{

    /**
     * Create a new voter scope instance.
     *
     * @param string $action
     * @param object $subject
     * @param object $candidate
     * @param array $parameters
     * 
     * @return VoterScopeInterface
     */
    public function newScope($action, $subject, $candidate = null, array $parameters = [])
    {
        return new VoterScope($action, $subject, $candidate, $parameters);
    }

    /**
     * Create a new polling instance.
     *
     * @return PollingInterface
     */
    public function newPolling()
    {
        return new Polling();
    }
}