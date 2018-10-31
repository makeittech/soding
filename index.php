<?php

function isPrime($n)
{
    if ($n == 2)
        return true;
    if ($n % 2 == 0)
        return false;
    $i = 3;
    $maxFactor = (int)sqrt($n);
    while ($i <= $maxFactor) {
        if ($n % $i == 0)
            return false;
        $i += 2;
    }

    return true;
}

//Eratosthene sieve
function getPrimes($maxNumber)
{
    $primes = [];
    $isComposite = [];

    for ($i = 4; $i <= $maxNumber; $i += 2) {
        $isComposite[$i] = true;
    }

    $nextPrime = 3;

    while ($nextPrime <= (int)sqrt($maxNumber)) {
        for ($i = $nextPrime * 2; $i <= $maxNumber; $i += $nextPrime) {
            $isComposite[$i] = true;
        }
        $nextPrime += 2;
        while ($nextPrime <= $maxNumber && isset($isComposite[$nextPrime])) {
            $nextPrime += 2;
        }
    }

    for ($i = 2; $i <= $maxNumber; $i++) {
        if (!isset($isComposite[$i]))
            $primes[] = $i;
    }

    return $primes;
}

const LIMIT = 1000000;

$result = 0;
$terms = 1;

$primes = getPrimes(LIMIT);
$primesLength = count($primes);
$primeSum = [0];

for ($i = 0; $i < $primesLength; $i++) {
    $primeSum[$i + 1] = $primeSum[$i] + $primes[$i];

    if ($primeSum[$i + 1] >= LIMIT) break;
}

$primeSumLength = count($primeSum);

for ($i = 0; $i < $primeSumLength; $i++) {
    for ($j = $primeSumLength - 1; $j > ($i + $terms); $j--) {
        $n = $primeSum[$j] - $primeSum[$i];
        if ($j - $i > $terms && isPrime($n)) {
            $terms = $j - $i;
            $result = $n;

            break;
        }
    }
}

echo "Result of " . LIMIT . " = " . $result . " with " . $terms . " terms";