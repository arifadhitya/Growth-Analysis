<?php


namespace App\Http\Controllers\FPGrowth;

use stdClass;

class FPNode extends stdClass
{
    /**
     * Membuat node
     */
    function __construct($value, $count, $parent)
    {
        $this->value = $value;
        $this->count = $count;
        $this->parent = $parent;
        $this->link = null;
        $this->children = [];
    }

    /**
     * cek jika sudah punya child node
     */
    function has_child($value)
    {
        foreach ($this->children as $node) {
            if (($node->value == $value)) {
                return true;
            }
        }
        return false;
    }

    /**
     * kembalikan child node jika ada
     */
    function get_child($value)
    {
        foreach ($this->children as $node) {
            if (($node->value == $value)) {
                return $node;
            }
        }
        return;
    }

    /**
     * tambahkan node sebagai child
     */
    function add_child($value)
    {
        $child = new FPNode($value, 1, $this);
        $this->children[] = $child;
        return $child;
    }
}
