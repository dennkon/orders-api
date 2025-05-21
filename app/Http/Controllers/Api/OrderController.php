<?php

namespace App\Http\Controllers\Api;

use App\DTO\OrderData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Orders API Documentation",
 *     description="API documentation for managing customer orders",
 *     @OA\Contact(
 *         email="dennlon@github.com"
 *     )
 * )
 */
class OrderController extends Controller
{
    public function __construct(
        protected OrderService $service
    ) {}

    /**
     * Create a new order
     * 
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"customer_name","customer_email","products"},
     *             @OA\Property(property="customer_name", type="string", example="Ivan Ivanov"),
     *             @OA\Property(property="customer_email", type="string", format="email", example="ivan@example.com"),
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"product_id","quantity"},
     *                     @OA\Property(property="product_id", type="integer", example=1),
     *                     @OA\Property(property="quantity", type="integer", minimum=1, example=2)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $orderData = OrderData::fromRequest($request);
        $order = $this->service->createOrder($orderData);

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get order by ID
     * 
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Get order information by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order details",
     *         @OA\JsonContent(ref="#/components/schemas/OrderResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $order = $this->service->getOrderById($id);
        
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    protected function transformOrder($order): array
    {
        return [
            'id' => $order->id,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'total_price' => $order->total_price,
            'items' => $order->products->map(fn($product) => [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->price,
            ])->toArray(),
        ];
    }
}
