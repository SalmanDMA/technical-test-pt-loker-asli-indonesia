<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApproverRequest;
use App\Services\ApproverService;
use Illuminate\Database\QueryException;

/**
 * @OA\Tag(
 *     name="Approvers",
 *     description="API for managing approvers"
 * )
 */
class ApproverController extends Controller
{
    protected $approverService;

    public function __construct(ApproverService $approverService)
    {
        $this->approverService = $approverService;
    }

    /**
     * @OA\Post(
     *     path="/api/approvers",
     *     tags={"Approvers"},
     *     summary="Create a new approver",
     *     description="Stores a new approver and returns the created approver data.",
     *     operationId="storeApprover",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Ana")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approver created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Ana"),
     *         )
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Database error",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *     ),
     * )
     */
    public function store(StoreApproverRequest $request)
    {
        try {
            $approver = $this->approverService->createApprover($request->validated());
            return response()->json($approver, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
