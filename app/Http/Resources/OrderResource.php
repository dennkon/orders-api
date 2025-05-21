<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="OrderResource",
 *     title="Order Resource",
 *     description="Order resource representation",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="customer_name", type="string", example="Ivan Ivanov"),
 *     @OA\Property(property="customer_email", type="string", format="email", example="ivan@example.com"),
 *     @OA\Property(property="total_price", type="number", format="decimal", example=400.00),
 *     @OA\Property(
 *         property="items",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="product_id", type="integer", example=1),
 *             @OA\Property(property="product_name", type="string", example="Product 1"),
 *             @OA\Property(property="quantity", type="integer", example=2),
 *             @OA\Property(property="unit_price", type="number", format="decimal", example=100.00)
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'total_price' => $this->total_price,
            'items' => $this->products->map(fn($product) => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->price,
            ]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 