<?php

namespace App\Cart\Contracts;

use App\Models\User;

interface CartInterface
{
    public function add($id, $quantity);

    public function update($id, $quantity);

    public function remove($id);

    public function clear();

    public function items();

    public function has($id);

    public function isEmpty();

    public function total();

    public function count();

    public function create();

    public function destroy();
}
