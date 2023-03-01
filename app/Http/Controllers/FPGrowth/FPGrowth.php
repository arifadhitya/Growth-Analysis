<?php
declare(strict_types=1);
namespace App\Http\Controllers\FPGrowth;

class FPGrowth
{
    // protected $support = 0;
    // protected $confidence = 0;
    private $transactions;
    private $patterns;
    private $rules;
    private $frequent;

    /**
     * @return mixed
     */
    public function getSupport(): int
    {
        return $this->support;
    }

    /**
     * @param mixed $support
     */
    public function setSupport($support): self
    {
        $this->support = $support;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @param mixed $confidence
     */
    public function setConfidence(float $confidence): self
    {
        $this->confidence = $confidence;
        return $this;
    }

    public function setTransaction($transactions): self
    {
        $this->transactions = $transactions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatterns()
    {
        return $this->patterns;
    }

    /**
     * @return mixed
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * FPGrowth constructor.
     * @param $support 1, 2, 3 ...
     * @param $confidence 0 ... 1
     */
    public function __construct(int $support, float $confidence)
    {
        $this->setSupport($support);
        $this->setConfidence($confidence);
    }

    /**
     * Do algorithm
     * @param $transactions
     */
    // public function run($transactions)
    // {
    //     $this->patterns = $this->findFrequentPatterns($transactions, $this->support);
    //     $this->rules = $this->generateAssociationRules($this->patterns, $this->confidence);
    // }

    public function run(array $transactions)
    {
        // dd($transactions);
        $this->setTransaction($transactions);
        $this->patterns = $this->findFrequentPatterns($transactions);
        $this->rules = $this->generateAssociationRules($this->patterns, $this->confidence);
    }

    // protected function findFrequentPatterns($transactions, $support_threshold)
    // {
    //     $tree = new FPTree($transactions, $support_threshold, null, null);
    //     return $tree->minePatterns($support_threshold);
    // }

    protected function findFrequentPatterns(array $transactions)
    {
        $tree = new FPTree($transactions, $this->support, null, 0);
        $miners = $tree->minePatterns($this->support);
        $prekuen = $tree->frequent;
        foreach ($prekuen as $key => $value){
            if(!in_array($key, $miners)){
                $miners[$key] = $value;
            }
        }
        // dd($miners);
        return $miners;
    }

    protected function generateAssociationRules(array $patterns, $confidence_threshold): array
    {
        implode($patterns);
        $rules = [];
        foreach (array_keys($patterns) as $itemsetStr) {
            if(is_int($itemsetStr)){
                $itemsetStr = strval($itemsetStr);
            }
            // dd($patterns);
            $itemset = explode(',', $itemsetStr);
            $upper_support = $patterns[$itemsetStr];
            for ($i = 1; $i < count($itemset); $i++) {
                foreach (self::combinations($itemset, $i) as $antecedent) {
                    sort($antecedent);
                    $antecedentStr = implode(',', $antecedent);
                    $consequent = array_diff($itemset, $antecedent);
                    sort($consequent);
                    $consequentStr = implode(',', $consequent);
                    if (isset($patterns[$antecedentStr])) {
                        $lower_support = $patterns[$antecedentStr];
                        $confidence = (floatval($upper_support) / $lower_support);
                        $lift = (floatval($confidence) / ($patterns[$consequentStr]/count($this->transactions)));
                        $B = $patterns[$consequentStr]/count($this->transactions) . "";
                        $sLift = $lift . "";
                        if ($confidence >= $confidence_threshold) {
                            // $rules[] = [$antecedentStr, $consequentStr, $confidence, strval($patterns[$consequentStr])];
                            $rules[] = [$antecedentStr, $consequentStr, $confidence, $B];
                            // $rules[] = [$antecedentStr, $consequentStr, $confidence, $lift];
                        }
                    }
                }
            }
        }
                // dd($rules);

        return $rules;

        // $rules = [];
        // foreach (array_keys($patterns) as $itemsetStr) {
        //     $itemset = explode(',', $itemsetStr);
        //     $upper_support = $patterns[$itemsetStr];
        //     for ($i = 1; $i < count($itemset); $i++) {
        //         foreach (self::combinations($itemset, $i) as $antecedent) {
        //             sort($antecedent);
        //             $antecedentStr = implode(',', $antecedent);
        //             $consequent = array_diff($itemset, $antecedent);
        //             sort($consequent);
        //             $consequentStr = implode(',', $consequent);
        //             if (isset($patterns[$antecedentStr])) {
        //                 $lower_support = $patterns[$antecedentStr];
        //                 $confidence = (floatval($upper_support) / $lower_support); // LOWER SUPPORT BERUBAH
        //                 if($upper_support <= $lower_support){
        //                     if ($confidence >= $confidence_threshold) {
        //                         $rules[] = [$antecedentStr, $consequentStr, $confidence];
        //                     }
        //                 }

        //             }
        //         }
        //     }

        // }
        //  dd($rules);

        // return $rules;
     }

    public static function iter($var)
    {

        switch (true) {
            case $var instanceof \Iterator:
                return $var;

            case $var instanceof \Traversable:
                return new \IteratorIterator($var);

            case is_string($var):
                $var = str_split($var);

            case is_array($var):
                return new \ArrayIterator($var);

            default:
                $type = gettype($var);
                throw new \InvalidArgumentException("'$type' type is not iterable");
        }

        return ;
    }

    //
    public static function combinations($iterable, $r)
    {
        $pool = is_array($iterable) ? $iterable : iterator_to_array(self::iter($iterable));
        $n = sizeof($pool);

        if ($r > $n) {
            return;
        }

        $indices = range(0, $r - 1);
        yield array_slice($pool, 0, $r);

        for (; ;) {
            for (; ;) {
                for ($i = $r - 1; $i >= 0; $i--) {
                    if ($indices[$i] != $i + $n - $r) {
                        break 2;
                    }
                }

                return;
            }

            $indices[$i]++;

            for ($j = $i + 1; $j < $r; $j++) {
                $indices[$j] = $indices[$j - 1] + 1;
            }

            $row = [];
            foreach ($indices as $i) {
                $row[] = $pool[$i];
            }

            yield $row;
        }
        // dd(combinations($iterable, $r));
    }

}
