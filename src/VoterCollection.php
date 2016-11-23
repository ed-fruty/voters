<?php

namespace Fruty\Voters;

use ArrayObject;
use CallbackFilterIterator;
use Fruty\Voters\Contracts\VoterInterface;

/**
 * Class VoterCollection
 * @package Fruty\Voters
 */
class VoterCollection
{
    /**
     * @var ArrayObject
     */
    protected $voters;

    /**
     * VoterCollection constructor.
     *
     * @param mixed $input
     */
    public function __construct($input = null)
    {
        $this->voters = new ArrayObject($input);
    }

    /**
     * Count voters.
     *
     * @return int
     */
    public function count()
    {
        return $this->voters->count();
    }

    /**
     * Add a new voter.
     * 
     * @param VoterInterface $voter
     */
    public function push(VoterInterface $voter)
    {
        $this->voters->append($voter);
    }

    /**
     * Get voters iterator.
     * 
     * @return \Iterator|VoterInterface[]
     */
    public function iterator()
    {
        return $this->voters->getIterator();
    }

    /**
     * @param callable $callback
     * @return int
     */
    public function each(callable $callback)
    {
        return iterator_apply($this->iterator(), $callback);
    }

    /**
     * Filter voters by given callback.
     *
     * @param callable $callback
     * @return VoterCollection
     */
    public function filter(callable $callback)
    {
        return new static(new CallbackFilterIterator($this->iterator(), $callback));
    }

    /**
     * Map voters.
     *
     * Note, that callback MUST return a VoterInterface.
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        /*
         * From the box, iterators doesn't have "map" method
         * Simplest solution would be convert voters to array and use "array_map" function, like
         * 
         *  return new static(array_map($callback, $this->voters->getArrayCopy()));
         * 
         * But we don't trust to array size of memory usage
         * So emulate array_map for iterators
         */
        
        $map = new static();

        foreach ($this->iterator() as $voter) {
            $map->push($callback($voter));
        }

        return $map;
    }
}