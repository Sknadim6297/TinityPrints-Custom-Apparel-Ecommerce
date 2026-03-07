<?php

namespace App\Support;

use App\Models\Order;
use App\Models\ProductSize;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class InventoryManager
{
    public static function decrementForCartItems(Collection $cartItems): void
    {
        foreach ($cartItems as $cartItem) {
            $size = self::normalizeSize($cartItem->size);

            if (!$cartItem->product_id || !$size) {
                continue;
            }

            $sizeRow = ProductSize::query()
                ->where('product_id', $cartItem->product_id)
                ->where('size', $size)
                ->lockForUpdate()
                ->first();

            if (!$sizeRow) {
                throw ValidationException::withMessages([
                    'stock' => 'Size ' . strtoupper($size) . ' is no longer available for ' . ($cartItem->product?->name ?? 'this product') . '.',
                ]);
            }

            if ((int) $sizeRow->stock_quantity < (int) $cartItem->quantity) {
                throw ValidationException::withMessages([
                    'stock' => 'Insufficient stock for ' . ($cartItem->product?->name ?? 'this product') . ' size ' . strtoupper($size) . '. Remaining: ' . $sizeRow->stock_quantity . '.',
                ]);
            }

            $newQty = (int) $sizeRow->stock_quantity - (int) $cartItem->quantity;
            $sizeRow->stock_quantity = $newQty;
            $sizeRow->is_available = $newQty > 0;
            $sizeRow->save();
        }
    }

    public static function restoreForOrder(Order $order): void
    {
        $order->loadMissing('items.product');

        foreach ($order->items as $item) {
            if (!$item->product_id || !$item->stock_deducted || $item->stock_restored) {
                continue;
            }

            $size = self::normalizeSize($item->size);
            if (!$size) {
                continue;
            }

            $sizeRow = ProductSize::query()
                ->where('product_id', $item->product_id)
                ->where('size', $size)
                ->lockForUpdate()
                ->first();

            if (!$sizeRow) {
                continue;
            }

            $sizeRow->stock_quantity = (int) $sizeRow->stock_quantity + (int) $item->quantity;
            $sizeRow->is_available = $sizeRow->stock_quantity > 0;
            $sizeRow->save();

            $item->stock_restored = true;
            $item->save();
        }
    }

    private static function normalizeSize(?string $size): ?string
    {
        $normalized = $size ? strtolower(trim($size)) : null;

        return in_array($normalized, ['xs', 's', 'm', 'l', 'xl', 'xxl'], true) ? $normalized : null;
    }
}
