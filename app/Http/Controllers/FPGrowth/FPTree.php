<?php
declare(strict_types=1);
namespace App\Http\Controllers\FPGrowth;

use stdClass;
use drupol\phpermutations\Generators\Combinations;

class FPTree extends stdClass
{
    public array $frequent;
    private array $headers;
    private FPNode $root;
    /**
     * inisialisasi tree.
     */
    public function __construct(array $transactions, int $threshold, $root_value, int $root_count)
    {
        // dd($root_value);
        // dd($root_count);

        $this->frequent = $this->findFrequentItems($transactions, $threshold);
        // $this->transactionsX = self::pruneTransaction($transactions, $this->frequent);
        // dd($this->frequent);
        // $this->headers = self::buildHeaderTable($this->frequent);
        $this->headers = $this->buildHeaderTable();
        // $this->root = $this->buildFPTree($this->transactionsX, $root_value, $root_count, $this->frequent, $this->headers);
        // dd($this->transactionsX);
        $this->root = $this->buildFPTree($transactions, $root_value, $root_count, $this->frequent);
    }
// PERHATIKAN FUNGSI DIATAS
    /**
     * Mencari nilai frekuensi produk dalam transaksi,
     * pruning dan sorting dari besar ke kecil.
     */
    protected function findFrequentItems(array $transactions, int $threshold): array
    {
        // SUPPORT!!!!!
        // frekuensi dari produk yang terbeli
        $items = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $item) {
                // $item = ;
                if (array_key_exists($item, $items)) {
                    $items[$item] += 1;
                } else {
                    $items[$item] = 1;
                }
            }
        }

        // foreach(array_keys($items) as $item){
        //     if (is_int($item)){
        //         $item
        //     }
        // }

        // hilangkan jika frekuensi produk kurang dari minimum support dan urutkan
        foreach (array_keys($items) as $key) {
            if (($items[$key] < $threshold)) {
                unset($items[$key]);
            }
            // if (is_int($key)){
            //     $items = strval($items);
            // }
        }



        // krsort($items);
        // arsort($items);
        arsort($items);
        // dd($items);
        return $items;
    }


    /*
        Menghapus transaksi yang hanya mengandung 1 jenis produk.
    */
    // protected static function pruneTransaction($transactions, $frequent)
    // {
    //     // dd($transactions);
    //     $transactionsX = [];
    //     foreach ($transactions as $transaction) {
    //         $y = [];
    //         foreach ($transaction as $item) {
    //             if (isset($frequent[$item])) {
    //                 $y[] = $item;
    //             }
    //         }
    //         // $transactionsX[]=$y;
    //         if(count($y)>1){
    //             $transactionsX[]=$y;
    //         }

    //     }
    //     // dd($transactionsX);
    //     return $transactionsX;
    // }


    /**
     * Membuat header
     */
    // protected static function buildHeaderTable($frequent)
    // {
    //     // menghapus value dari key array frequent
    //     $headers = [];
    //     foreach (array_keys($frequent) as $key) {
    //         $headers[$key] = null;
    //     }
    //     // dd($headers);
    //     return $headers;
    // }
// ================================
    protected function buildHeaderTable(): array
    {
        // menghapus value dari key array frequent
        $headers = [];
        foreach (array_keys($this->frequent) as $key) {
            $headers[$key] = null;
        }
        // dd($headers);
        return $headers;
    }


    /**
     * Membuat fptree dan mengembalikan node root
     */
    // protected function buildFPTree(&$transactionsX, &$root_value, &$root_count, &$frequent, &$headers)
    // {
    //     // membuat node null
    //     $root = new FPNode($root_value, $root_count, null);
    //     arsort($frequent);
    //     // memasukkan ke dalam tree
    //     // dd($transactionsX);
    //     foreach ($transactionsX as $transaction) {
    //         // dd($transaction);
    //         sort($transaction);
    //         // dd($transactions);
    //         $sorted_items = [];
    //         foreach ($transaction as $item) {
    //             if (isset($frequent[$item])) {
    //                 $sorted_items[] = $item;
    //             }
    //         }

    //         // membandingkan a dan b dan mengembalikan nilai true atau false
    //         usort($sorted_items, function ($a, $b) use ($frequent) {
    //             return $frequent[$a] == $frequent[$b] ? 0 : (
    //                 $frequent[$a] > $frequent[$b] ? -1 : 1
    //             );
    //         });

    //         // dd($frequent);
    //         // jika jumlah sorted_item lebih besar dari 0 maka kirimkan dan jalankan insertTree
    //         if (count($sorted_items) > 0) {
    //             $this->insertTree($sorted_items, $root, $headers);
    //         }
    //     }



    //     // $x = [];
    //     // foreach ($transactions as $transaction) {
    //     //     $y = [];
    //     //     foreach ($transaction as $item) {
    //     //         if (isset($frequent[$item])) {
    //     //             $y[] = $item;
    //     //         }
    //     //     }
    //     //     if(count($y)>1){
    //     //         $x[]=$y;
    //     //     }

    //     // }
    //     // dd($x);
    //     return $root;
    // }

    protected function buildFPTree($transactions, $root_value, $root_count, &$frequent): FPNode
    {
        $root = new FPNode($root_value, $root_count, null);
        arsort($frequent);
        foreach ($transactions as $transaction) {
            sort($transaction);
            $sorted_items = [];
            foreach ($transaction as $item) {
                if (isset($frequent[$item])) {
                    $sorted_items[] = $item;
                }
            }

            // print_r($transaction);
            usort($sorted_items, function ($a, $b) use ($frequent) {
                return $frequent[$b] <=> $frequent[$a];
            });

            if (count($sorted_items) > 0) {
                $this->insertTree($sorted_items, $root);
            }
        }
        return $root;
    }

    /**
     * FP tree rekursif
     */
    // protected function insertTree(&$items, &$node, &$headers)
    // {
    //     // memasukkan items pertama ke first
    //     $first = $items[0];
    //     // memasukkan child dari first ke dalam $child
    //     $child = $node->get_child($first);

    //     // jika child tidak kosong maka child->count +1 atau membuat child baru dari first
    //     if (($child != null)) {
    //         $child->count += 1;
    //     } else {
    //         // menambah child baru dari first
    //         $child = $node->add_child($first);
    //         // menyambungkan ke header
    //         if ($headers[$first] == null) {
    //             $headers[$first] = $child;
    //         } else {
    //             $current = $headers[$first];
    //             while ($current->link != null) {
    //                 $current = $current->link;
    //             }
    //             $current->link = $child;
    //         }
    //     }

    //     $remaining_items = array_slice($items, 1, null);
    //     // dd($remaining_items);
    //     // dd($remaining_items);
    //     // jika item yang tertinggal lebih besar dari 0 maka masukkan dan jalankan insertTree
    //     if (count($remaining_items) > 0) {
    //         $this->insertTree($remaining_items, $child, $headers);
    //         // dd($first);
    //     }
    // }

    protected function insertTree(array $items, FPNode $node): void
    {
        $first = $items[0];
        $child = $node->get_child($first);

        if ($child !== null) {
            $child->count += 1;
        } else {
            // Add new child
            $child = $node->add_child($first);
            // Link it to header structure.
            if ($this->headers[$first] === null) {
                $this->headers[$first] = $child;
            } else {
                $current = $this->headers[$first];
                while ($current->link !== null) {
                    $current = $current->link;
                }
                $current->link = $child;
            }
        }

        // Call function recursively.
        $remaining_items = array_slice($items, 1, null);

        if (count($remaining_items) > 0) {
            $this->insertTree($remaining_items, $child);
        }
    }

    /**
     * Mengecek apakah tree cuma punya 1 jalur dibawahnya
     * return true, else return false.
     */
    // protected function treeHasSinglePath($node)
    // {
    //     $num_children = count($node->children);

    //     if (($num_children > 1)) {
    //         return false;
    //     } else if (($num_children == 0)) {
    //         return true;
    //     } else {
    //         return true && $this->treeHasSinglePath($node->children[0]);
    //     }
    // }

    protected function treeHasSinglePath(FPNode $node): bool
    {
        $num_children = count($node->children);

        if ($num_children > 1) {
            return false;
        }

        if ($num_children === 0) {
            return true;
        }

        return $this->treeHasSinglePath(current($node->children));
    }

    /**
     * Mine fp-tree
     */
    // public function minePatterns($threshold)
    // {
    //     // jika tree hanya punya 1 jalur dibawahnya atau hanya punya 1 child
    //     if ($this->treeHasSinglePath($this->root)) {
    //         return $this->generatePatternList();
    //     } else {
    //         return $this->zipPatterns($this->mineSubTrees($threshold));
    //         // dd($threshold);
    //     }
    // }

    public function minePatterns(int $threshold): array
    {
        // $threshold = 2;
        // print_r(($this->treeHasSinglePath($this->root)));
        if ($this->treeHasSinglePath($this->root)) {
            return $this->generatePatternList();
        } else {

            return $this->zipPatterns($this->mineSubTrees($threshold));
        }
        // dd(($this->mineSubTrees($threshold)));
// PERAHTIKAN MINESUBTREE
// dd($this->mineSubTrees($threshold));

    }

    /**
     * Tambahkan suffix menuju node,
     * conditional fptree.
     */
    // protected function zipPatterns($patterns)
    // {

    //     $suffix = $this->root->value;
    //     if ($suffix != null) {
    //         // kondisional tree
    //         $new_patterns = [];
    //         foreach (array_keys($patterns) as $strKey) {
    //             $key = explode(',', $strKey);
    //             $key[] = $suffix;
    //             sort($key);
    //             $new_patterns[implode(',', $key)] = $patterns[$strKey];
    //         }

    //         return $new_patterns;
    //     }
    //     return $patterns;
    // }
    protected function zipPatterns(array $patterns): array
    {
        if ($this->root->value === null) {
            return $patterns;
        }

        // We are in a conditional tree.
        $new_patterns = [];
        // print_r(array_keys($patterns));
        foreach (array_keys($patterns) as $strKey) {
            if (is_int($strKey)){
                $strKey = strval($strKey);
            }
            $key = explode(',', $strKey);
            $key[] = $this->root->value;
            sort($key);
            $new_patterns[implode(',', $key)] = $patterns[$strKey];
        }

        return $new_patterns;
    }

    /**
     * Generate patterns dengan nilai support.
     */
    protected function generatePatternList(): array
    {
        $sv=[];
        $patterns = [];
        $items = array_keys($this->frequent);
        // print_r($this->frequent);
        // Mengecek apakah dalam conditional fptree, maka suffix adalah dirinya sendiri.
        // if ($this->root->value == null) {
        //     $suffix_value = [];
        // } else {
        //     $suffix_value = [$this->root->value];
        //     sort($suffix_value);
        //     $patterns[implode(',', $suffix_value)] = $this->root->count;
        // }
        // dd(($this->root->value !== null));

        if ($this->root->value !== null) {
            $patterns[$this->root->value] = $this->root->count;
        }

        for ($i = 1; $i <= count($items); $i++) {
            foreach (FPGrowth::combinations($items, $i) as $subset) {
                // $pattern = array_merge($subset, $suffix_value);
                $pattern = $this->root->value !== null ? array_merge($subset, [$this->root->value]) : $subset;
                sort($pattern);
                $min = PHP_INT_MAX;
                foreach ($subset as $x) {
                    if ($this->frequent[$x] < $min) {
                        $min = $this->frequent[$x];
                    }
                }
                $patterns[implode(',', $pattern)] = $min;
                // array_push($sv, $suffix_value);
                // print_r($min);
            }
                // dd($patterns);
        }
        //  dd($patterns);

        // dd($this->frequent);
        return $patterns;
    }

    // protected function generatePatternList(): array
    // {
    //     $patterns = [];
    //     $items = array_keys($this->frequent);
    //     print_r($this->frequent);

    //     // If we are in a conditional tree, the suffix is a pattern on its own.
    //     if ($this->root->value !== null) {
    //         $patterns[$this->root->value] = $this->root->count;
    //     }

    //     for ($i = 1; $i <= count($items); $i++) {
    //         $combinations = new Combinations($items,$i);
    //         foreach (FPGrowth::combinations($items, $i as $subset) {
    //             $pattern = $this->root->value !== null ? array_merge($subset, [$this->root->value]) : $subset;
    //             sort($pattern);
    //             $min = PHP_INT_MAX;
    //             /** @var string $x */
    //             foreach ($subset as $x) {
    //                 if ($this->frequent[$x] < $min) {
    //                     $min = $this->frequent[$x];
    //                 }
    //             }
    //             $patterns[implode(',', $pattern)] = $min;
    //         }
    //     }
    //     return $patterns;
    // }

    /**
     * Generate subtree dan cari PATTERN BASE !!!!!!!!!!!
     */
    // protected function mineSubTrees($threshold)
    // {
    //     $patterns = [];
    //     $mining_order = $this->frequent;
    //     asort($mining_order);
    //     $mining_order = array_keys($mining_order);
    //     // Mengambil item dalam tree dengan urutan terbalik
    //     foreach ($mining_order as $item) {
    //         $suffixes = [];
    //         $conditional_tree_input = [];
    //         $node = $this->headers[$item];
    //         // Melihat tree untuk beberapa item
    //         while (($node != null)) {
    //             $suffixes[] = $node;
    //             $node = $node->link;
    //         }
    //         // dd($suffixes);

    //         // trace jalan menuju root
    //         foreach ($suffixes as $suffix) {
    //             $frequency = $suffix->count;
    //             $path = [];
    //             $parent = $suffix->parent;
    //             while (($parent->parent != null)) {
    //                 $path[] = $parent->value;
    //                 $parent = $parent->parent;
    //             }
    //             for ($i = 0; $i < $frequency; $i++) {
    //                 $conditional_tree_input[] = $path;
    //                 // print_r($conditional_tree_input);
    //             }
    //         }
    //         // print_r($conditional_tree_input);

    //         // DIATAS MENCARI KONDISIONAL PATTERN BASE


    //         // !!!Melihat FPTree !!!
    //         //  dd($parent->children);

    //         // mencari pattern dari subtree (conditional fp-tree)
    //         $subtree = new FPTree($conditional_tree_input, $threshold, $item, $this->frequent[$item]);
    //         // dari kondisional fp-tree ke pattern
    //         $subtree_patterns = $subtree->minePatterns($threshold);
    //         // print_r($subtree_patterns);
    //         // masukkan pattern

    //         // print_r($subtree);
    //         // print_r($subtree_patterns);
    //         foreach (array_keys($subtree_patterns) as $pattern) {
    //             if (in_array($pattern, $patterns)) {
    //                 // dd($patterns[$pattern]);
    //                 $patterns[$pattern] += $subtree_patterns[$pattern];
    //             } else {
    //                 $patterns[$pattern] = $subtree_patterns[$pattern];
    //             }
    //         }
    //         // print_r($subtree_patterns);
    //     }
    //     // dd($patterns);
    //     return $patterns;
    // }

    protected function mineSubTrees(int $threshold): array
    {
        $patterns = [];
        $mining_order = $this->frequent;
        asort($mining_order);
        $mining_order = array_keys($mining_order);
        // dd($mining_order);
        // Get items in tree in reverse order of occurrences.

        foreach ($mining_order as $item) {
            // dd($item);
            /** @var FPNode[] $suffixes */
            $suffixes = [];
            $conditional_tree_input = [];
            $node = $this->headers[$item];

            // Follow node links to get a list of all occurrences of a certain item.
            while ($node !== null) {
                $suffixes[] = $node;
                // print_r($suffixes);
                $node = $node->link;
            }

            // For each currence of the item, trace the path back to the root node.
            foreach ($suffixes as $suffix) {
                $frequency = $suffix->count;
                $path = [];
                $parent = $suffix->parent;
                while ($parent->parent !== null) {
                    $path[] = $parent->value;
                    // dd($path);
                    $parent = $parent->parent;
                }

                for ($i = 0; $i < $frequency; $i++) {
                    $conditional_tree_input[] = array_reverse($path);
                }

            }

            //  MELIHAT KONDISIONAL PATTERN BASE YG AKAN DIJADIKAN SEBAGAI TRANSAKSI PADA SUBTREE
            $conditional_tree_input = array_filter($conditional_tree_input);
            // print_r($conditional_tree_input);





            //  dd($frequency);

            // SUBTREE (TREE DARI CONDITIONAL FP-TREE)!!!!!!!!!!!!!!!!!
            // Now we have the input for a subtree, so construct it and grab the patterns.
            $subtree = new FPTree($conditional_tree_input, $threshold, $item, $this->frequent[$item]);
            // print_r($subtree);

            $subtreePatterns = $subtree->minePatterns($threshold);
            // print_r($subtreePatterns);


            // Insert subtree patterns into main patterns dictionary.
            foreach (array_keys($subtreePatterns) as $pattern) {
                // print_r($subtreePatterns);
                if (in_array($pattern, $patterns)) {

                    $patterns[$pattern] += $subtreePatterns[$pattern];
                } else {
                    $patterns[$pattern] = $subtreePatterns[$pattern];
                }
            }


        }

        // print_r($mining_order);
        return $patterns;
    }
}
