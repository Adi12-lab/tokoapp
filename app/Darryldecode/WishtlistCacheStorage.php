<?php
namespace App\Darryldecode;

use Carbon\Carbon;
use Cookie;
use Darryldecode\Cart\CartCollection;

class WishlistCacheStorage
{
    private $data = [];
    private $wishlist_id;

    public function __construct()
    {
        $this->wishlist_id = \Cookie::get('wishlist');
        if ($this->wishlist_id) {
            $this->data = \Cache::get('wishlist_' . $this->wishlist_id, []);
        } else {
            $this->wishlist_id = uniqid();
        }
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function get($key)
    {
        return new CartCollection($this->data[$key] ?? []);
    }

    public function put($key, $value)
    {
        $this->data[$key] = $value;
        \Cache::put('wishlist_' . $this->wishlist_id, $this->data, Carbon::now()->addDays(30));
        if (!Cookie::hasQueued('wishlist')) {
            Cookie::queue(
                Cookie::make('wishlist', $this->wishlist_id, 60 * 24 * 30)
            );
        }
    }
}
