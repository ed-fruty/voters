<?php

namespace Fruty\Voters;

use ArrayObject;
use CallbackFilterIterator;
use Countable;
use Fruty\Voters\Contracts\VoterInterface;
use Traversable;

/**
 * Class VoterCollection
 * @package Fruty\Voters
 */
class VoterCollection implements Countable
{
    /**
     * @var ArrayObject
     */
    protected $voters;

    /**
     * VoterCollection constructor.
     *
     * @param array|Traversable $voters
     */
    public function __construct($voters = [])
    {
        $this->voters = new ArrayObject();

        /*
         * Check is all input elements implements VoterInterface instance.
         */
        foreach ($voters as $voter) {
            $this->push($voter);
        }
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
        return (new static())->forceFill(new CallbackFilterIterator($this->iterator(), $callback));
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

    /**
     * Force filling.
     *
     * Using only for internal needs, when you exactly know that all given voters implements of VoterInterface.
     * 
     * @param array|Traversable $voters
     */
    private function forceFill($voters)
    {
        $this->voters = $voters;
    }
}