<?php

namespace App\Traits;

trait HandlesDynamicFields
{
    public function addTableRow($slug)
    {
        $this->data[$slug]['fields'][] = []; // You can clone the last row if needed
    }

    public function removeTableRow($slug, $index)
    {
        unset($this->data[$slug]['fields'][$index]);
        $this->data[$slug]['fields'] = array_values($this->data[$slug]['fields']); // Reindex
    }
}