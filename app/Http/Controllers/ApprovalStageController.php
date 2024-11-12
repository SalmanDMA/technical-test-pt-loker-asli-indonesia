<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApprovalStageRequest;
use App\Http\Requests\UpdateApprovalStageRequest;
use App\Services\ApprovalStageService;
use Illuminate\Database\QueryException;

/**
 * @OA\Tag(
 *     name="Approval Stages",
 *     description="API for managing approval stages"
 * )
 */
class ApprovalStageController extends Controller
{
    protected $approvalStageService;

    public function __construct(ApprovalStageService $approvalStageService)
    {
        $this->approvalStageService = $approvalStageService;
    }

    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     tags={"Approval Stages"},
     *     summary="Create a new approval stage",
     *     description="Stores a new approval stage and returns the created data.",
     *     operationId="storeApprovalStage",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="approver_id", type="int", description="tersedia di tabel approvers, unik satu sama lain"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approval stage created successfully",
     *         @OA\Response(response=201, description="Tahap approval berhasil ditambahkan"),
     *     ),
     *     @OA\Response(
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
    public function store(StoreApprovalStageRequest $request)
    {
        try {
            $approvalStage = $this->approvalStageService->createApprovalStage($request->validated());
            return response()->json($approvalStage, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     tags={"Approval Stages"},
     *     summary="Update an existing approval stage",
     *     description="Updates an approval stage by ID and returns the updated data.",
     *     operationId="updateApprovalStage",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the approval stage to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="_method", type="string", example="PUT", description="HTTP method override"),
     *             @OA\Property(property="approver_id", type="int", description="tersedia di tabel approvers, unik satu sama lain"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Approval stage updated successfully",
     *     ),
     *     @OA\Response(
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
    public function update($id, UpdateApprovalStageRequest $request)
    {
        try {
            $approvalStage = $this->approvalStageService->updateApprovalStage($id, $request->validated());
            return response()->json($approvalStage, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
