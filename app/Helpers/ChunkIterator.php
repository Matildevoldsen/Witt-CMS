<?php

namespace App\Helpers;

use Iterator;

class ChunkIterator
{
    public function __construct(protected Iterator $iterator, protected int $chunks) {}

    public function get()
    {
        $chunk = [];

        for ($i = 0; $this->iterator->valid(); $i++){
            $chunk[] = $this->iterator->current();
            $this->iterator->next();

            if(count($chunk) == $this->chunks){
                yield $chunk;
                $chunk = [];
            }
        }

        if (count($chunk)){
            yield $chunk;
        }
    }
}
