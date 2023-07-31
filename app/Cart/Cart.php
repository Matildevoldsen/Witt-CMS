<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use App\Models\Cart as ModelsCart;
use App\Models\User;
use Illuminate\Session\SessionManager;

class Cart implements CartInterface
{
    protected $instance;

    public function __construct(protected SessionManager $session) { }

    public function add($id, $quantity)
    {
        // TODO: Implement add() method.
    }

    public function update($id, $quantity)
    {
        // TODO: Implement update() method.
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }

    public function items()
    {
        // TODO: Implement items() method.
    }

    public function has($id)
    {
        // TODO: Implement has() method.
    }

    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    public function total()
    {
        // TODO: Implement total() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }

    public function create(?User $user = null): void
    {
        $instance = ModelsCart::make();

        if ($user) {
            $instance->user()->associate($user);
        }

        $instance->save();

        $this->session->put(config('cart.session.key'), $instance->uuid);
    }

    protected function clearInstanceCache(): void
    {
        $this->instance = null;
    }

    public function destroy()
    {
        // TODO: Implement destroy() method.
    }

    public function instance()
    {
        if ($this->instance) {
            return $this->instance;
        }

        return $this->instance = ModelsCart::query()
//            ->with(
//                'variations.product',
//                'variations.ancestorsAndSelf',
//                'variations.descendantsAndSelf.stocks',
//                'variations.media'
//            )
            ->whereUuid($this->session->get(config('cart.session.key')))
            ->first();
    }
}
