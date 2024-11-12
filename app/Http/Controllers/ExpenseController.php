<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

/**
 * @OA\Tag(
 *     name="Expenses",
 *     description="API for managing expenses and their approvals"
 * )
 */
class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     tags={"Expenses"},
     *     summary="Create a new expense",
     *     description="Stores a new expense and returns the created expense data.",
     *     operationId="storeExpense",
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="amount", type="number", description="Jumlah pengeluaran dengan minimal value 1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense created successfully",
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
    public function store(StoreExpenseRequest $request)
    {
        try {
            $expense = $this->expenseService->createExpense($request->validated());
            return response()->json($expense, 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/expenses/{id}/approve",
     *     tags={"Expenses"},
     *     summary="Approve an expense",
     *     description="Approves a specified expense if the approver is authorized for the current stage.",
     *     operationId="approveExpense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to approve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="_method", type="string", example="PATCH", description="Method override for PATCH request"),
     *             @OA\Property(property="approver_id", type="integer", description="ID of the approver for the current stage")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense approved successfully",
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

    public function approve($id, ApproveExpenseRequest $request)
    {
        try {
            $approval = $this->expenseService->approveExpense($id, $request->approver_id);
            return response()->json($approval, 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/expenses/{id}",
     *     tags={"Expenses"},
     *     summary="Get an expense",
     *     description="Retrieve details of a specified expense by ID.",
     *     operationId="getExpense",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the expense to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense details retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found",
     *     ),
     * )
     */
    public function show($id)
    {
        try {
            $expense = $this->expenseService->getExpense($id);

            if (!$expense) {
                return response()->json(['error' => 'Expense not found'], 404);
            }

            return response()->json($expense, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
