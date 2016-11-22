<?php

namespace Fruty\Voter;

use Fruty\Voter\Contracts\CommitteeInterface;
use Fruty\Voter\Contracts\PollingInterface;
use Fruty\Voter\Contracts\VoterScopeInterface;

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