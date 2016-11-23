<?php

namespace Fruty\Voters;

/**
 * Class VoterScope
 * @package Voter
 */
class VoterScope implements Contracts\VoterScopeInterface
{
    /**
     * @var string
     */
    private $action;
    
    /**
     * @var object
     */
    private $subject;
    
    /**
     * @var object
     */
    private $candidate;
    
    /**
     * @var array
     */
    private $parameters;

    /**
     * VoterScope constructor.
     *
     * @param string $action
     * @param object $subject
     * @param object $candidate
     * @param array $parameters
     */
    public function __construct($action, $subject, $candidate, array $parameters = [])
    {
        $this->action = $action;
        $this->subject = $subject;
        $this->candidate = $candidate;
        $this->parameters = $parameters;
    }

    /**
     * Get action.
     * 
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get subject.
     * 
     * @return object
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get candidate.
     * 
     * @return object
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Get parameters.
     * 
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get parameter value.
     * 
     * @param  string $name    
     * @param  mixed $default 
     * 
     * @return mixed          
     */
    public function getParameter($name, $default = null)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : $default;
    }
}