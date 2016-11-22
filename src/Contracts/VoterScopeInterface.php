<?php
namespace Fruty\Voters\Contracts;

/**
 * Interface VoterScopeInterface
 * @package Fruty\Voters\Contracts
 */
interface VoterScopeInterface
{
    /**
     * Get scope action.
     *
     * @return string
     */
    public function getAction();

    /**
     * Get scope subject.
     * 
     * @return mixed|object 
     */
    public function getSubject();

    /**
     * Get scope candidate.
     * 
     * @return mixed|object
     */
    public function getCandidate();

    /**
     * Get scope parameters.
     * 
     * @return array 
     */
    public function getParameters();

    /**
     * Get parameter.
     * 
     * @param string $name 
     * @param mixed $default
     * 
     * @return mixed
     */
    public function getParameter($name, $default = null);
}
