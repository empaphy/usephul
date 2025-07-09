<?php

/**
 * @author    Alwin Garside <alwin@garsi.de>
 * @copyright 2025 The Empaphy Project
 * @license   MIT
 * @package   Iterables
 */

declare(strict_types=1);

namespace empaphy\usephul;

/**
 * Interface for external iterators or objects that can be iterated themselves
 * internally, for a finite number of iterations.
 */
interface FiniteIterator extends \Iterator, \Countable {}
