<?php

namespace OWC\PDC\Base\UPL\Enrichment\Models;

use OWC\PDC\Base\Models\Item;

class ViewModel 
{
    protected Item $item;
    
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public function getTitleRow(): string
    {
        return sprintf('<td>%s</td>', $this->item->getTitle());
    }

    public function getEditLinkRow(): string
    {
        return sprintf('<td><a href="%s">Bekijk</a></td>', $this->item->getEditURL());
    }

    public static function makeFrom(Item $item)
    {
        return new static($item);
    }
}