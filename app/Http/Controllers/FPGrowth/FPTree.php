<?php

namespace App\Http\Controllers\FPGrowth;

use stdClass;

class FPTree extends stdClass
{
    /**
     * Initialize the tree.
     */
    public function __construct($transactions, $threshold, $root_value, $root_count)
    {
        $this->frequent = self::findFrequentItems($transactions, $threshold);
        $this->headers = self::buildHeaderTable($this->frequent);
        $this->root = $this->buildFPTree($transactions, $root_value, $root_count, $this->frequent, $this->headers);
    }

    /**
     * Mencari frekuensi produk dalam transaksi, pruning, dan sorting dari besar ke kecil
     */
    protected static function findFrequentItems($transactions, $threshold)
    {

        // frekuensi dari produk yang terbeli
        $items = [];
        foreach ($transactions as $transaction) {
            foreach ($transaction as $item) {
                if (array_key_exists($item, $items)) {
                    $items[$item] += 1;
                } else {
                    $items[$item] = 1;
                }
            }
        }

        // hilangkan jika frekuensi produk kurang dari minimum support dan urutkan
        foreach (array_keys($items) as $key) {
            if (($items[$key] < $threshold)) {
                unset($items[$key]);
            }
        }
        arsort($items);

        return $items;
    }

    /**
     * Membuat header
     */
    protected static function buildHeaderTable($frequent)
    {
        // menghapus value dari key array frequent
        $headers = [];
        foreach (array_keys($frequent) as $key) {
            $headers[$key] = null;
        }

        return $headers;
    }

    /**
     * Membuat fptree dan mengembalikan node root
     */
    protected function buildFPTree(&$transactions, &$root_value, &$root_count, &$frequent, &$headers)
    {
        // membuat node null
        $root = new FPNode($root_value, $root_count, null);

        arsort($frequent);

        // memasukkan ke dalam tree
        foreach ($transactions as $transaction) {
            $sorted_items = [];
            foreach ($transaction as $item) {
                if (isset($frequent[$item])) {
                    $sorted_items[] = $item;
                }
            }

            // membandingkan a dan b dan mengembalikan nilai true atau false
            usort($sorted_items, function ($a, $b) use ($frequent) {
                return $frequent[$a] == $frequent[$b] ? 0 : (
                $frequent[$a] > $frequent[$b] ? -1 : 1
                );
            });

            // jika jumlah sorted_item lebih besar dari 0 maka kirimkan dan jalankan insertTree
            if (count($sorted_items) > 0) {
                $this->insertTree($sorted_items, $root, $headers);
            }
        }
        return $root;
    }

    /**
     * FP tree rekursif
     */
    protected function insertTree(&$items, &$node, &$headers)
    {
        // memasukkan items pertama ke first
        $first = $items[0];

        // memasukkan child dari first ke dalam $child
        $child = $node->get_child($first);

        // jika child tidak kosong maka child->count +1 atau membuat child baru dari first
        if (($child != null)) {
            $child->count += 1;
        } else {
            // menambah child baru dari first
            $child = $node->add_child($first);
            // menyambungkan ke header
            if ($headers[$first] == null) {
                $headers[$first] = $child;
            } else {
                $current = $headers[$first];
                while ($current->link != null) {
                    $current = $current->link;
                }
                $current->link = $child;
            }
        }

        $remaining_items = array_slice($items, 1, null);

        // jika item yang tertinggal lebih besar dari 0 maka masukkan dan jalankan insertTree
        if (count($remaining_items) > 0) {
            $this->insertTree($remaining_items, $child, $headers);
        }
    }

    /**
     * Mengecek apakah tree cuma punya 1 jalur dibawahnya
     * return true, else return false.
     */
    protected function treeHasSinglePath($node)
    {
        $num_children = count($node->children);
        if (($num_children > 1)) {
            return false;
        } else if (($num_children == 0)) {
            return true;
        } else {
            return true && $this->treeHasSinglePath($node->children[0]);
        }
    }

    /**
     * Mine fp-tree
     */
    public function minePatterns($threshold)
    {
        // jika tree hanya punya 1 jalur dibawahnya atau hanya punya 1 child
        if ($this->treeHasSinglePath($this->root)) {
            return $this->generatePatternList();
        } else {
            return $this->zipPatterns($this->mineSubTrees($threshold));
        }
    }

    /**
     * Tambahkan suffix menuju node,
     * conditional fptree.
     */
    protected function zipPatterns($patterns)
    {
        $suffix = $this->root->value;
        if ($suffix != null) {
            // We are in a conditional tree.
            $new_patterns = [];
            foreach (array_keys($patterns) as $strKey) {
                $key = explode(',', $strKey);
                $key[] = $suffix;
                sort($key);
                $new_patterns[implode(',', $key)] = $patterns[$strKey];
            }
            return $new_patterns;
        }
        return $patterns;
    }

    /**
     * Generate patterns dengan nilai support.
     */
    protected function generatePatternList()
    {
        $patterns = [];
        $items = array_keys($this->frequent);
        // Mengecek apakah dalam conditional fptree, maka suffix adalah dirinya sendiri.
        if ($this->root->value == null) {
            $suffix_value = [];
        } else {
            $suffix_value = [$this->root->value];
            sort($suffix_value);
            $patterns[implode(',', $suffix_value)] = $this->root->count;
        }
        for ($i = 1; $i <= count($items); $i++) {
            foreach (FPGrowth::combinations($items, $i) as $subset) {
                $pattern = array_merge($subset, $suffix_value);
                sort($pattern);
                $min = PHP_INT_MAX;
                foreach ($subset as $x) {
                    if ($this->frequent[$x] < $min) {
                        $min = $this->frequent[$x];
                    }
                }
                $patterns[implode(',', $pattern)] = $min;
            }
        }
        return $patterns;
    }

    /**
     * Generate subtrees and mine them for patterns.
     */
    protected function mineSubTrees($threshold)
    {
        $patterns = [];
        $mining_order = $this->frequent;
        asort($mining_order);
        $mining_order = array_keys($mining_order);
        // Get items in tree in reverse order of occurrences.
        foreach ($mining_order as $item) {
            $suffixes = [];
            $conditional_tree_input = [];
            $node = $this->headers[$item];
            // Follow node links to get a list of all occurrences of a certain item.
            while (($node != null)) {
                $suffixes[] = $node;
                $node = $node->link;
            }
            // For each currence of the item, trace the path back to the root node.
            foreach ($suffixes as $suffix) {
                $frequency = $suffix->count;
                $path = [];
                $parent = $suffix->parent;
                while (($parent->parent != null)) {
                    $path[] = $parent->value;
                    $parent = $parent->parent;
                }
                for ($i = 0; $i < $frequency; $i++) {
                    $conditional_tree_input[] = $path;
                }
            }
            // Now we have the input for a subtree, so construct it and grab the patterns.
            $subtree = new FPTree($conditional_tree_input, $threshold, $item, $this->frequent[$item]);
            $subtree_patterns = $subtree->minePatterns($threshold);
            // Insert subtree patterns into main patterns dictionary.
            foreach (array_keys($subtree_patterns) as $pattern) {
                if (in_array($pattern, $patterns)) {
                    $patterns[$pattern] += $subtree_patterns[$pattern];
                } else {
                    $patterns[$pattern] = $subtree_patterns[$pattern];
                }
            }
        }
        return $patterns;
    }
}
