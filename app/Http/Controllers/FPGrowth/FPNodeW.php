<?php

// declare(strict_types=1);

namespace App\Http\Controllers\FPGrowth;

class FPNode
{
    public $value;
    public int $count;
    public ?FPNode $parent = null;
    public ?FPNode $link = null;
    /** @var FPNode[] */
    public array $children = [];

    /**
     * Membuat node
     *
     * @param mixed $value
     * @param int $count
     * @param FPNode|null $parent
     */
    public function __construct($value, int $count, ?FPNode $parent)
    {
        $this->value = $value;
        $this->count = $count;
        $this->parent = $parent;
        $this->link = null;
        $this->children = [];
    }

    /**
     * cek jika sudah punya child node
     * @param mixed $value
     * @return bool
     */
    public function hasChild($value): bool
    {
        foreach ($this->children as $node) {
            if ($node->value == $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * kembalikan child node jika ada
     * @param $value
     * @return FPNode|null
     */
    public function getChild($value): ?FPNode
    {
        foreach ($this->children as $node) {
            if ($node->value == $value) {
                return $node;
            }
        }
        return null;
    }

    /**
     * tambahkan node sebagai child
     * @param $value
     * @return FPNode
     */
    public function addChild($value): FPNode
    {
        $child = new FPNode($value, 1, $this);
        $this->children[] = $child;
        return $child;
    }
}

