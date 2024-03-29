<?php

declare(strict_types=1);
namespace App\Http\Controllers\FPGrowth;

use stdClass;

class FPNode extends stdClass
{
    public $value;
    public int $count;
    public ?FPNode $parent = null;
    public ?FPNode $link = null;
    /** @var FPNode[] */
    public array $children = [];
    /**
     * Membuat node
     */
    function __construct($value, int $count, ?FPNode $parent)
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
    function get_child($value): ?FPNode
    {
        foreach ($this->children as $node) {
            if (($node->value == $value)) {
                return $node;
            }
        }
        return null;
    }

    /**
     * tambahkan node sebagai child
     */
    function add_child($value): FPNode
    {
        $child = new FPNode($value, 1, $this);
        $this->children[] = $child;
        return $child;
    }
}
