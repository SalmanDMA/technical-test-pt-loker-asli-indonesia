<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApproverController;
use App\Http\Controllers\ApprovalStageController;
use App\Http\Controllers\ExpenseController;

Route::post('/approvers', [ApproverController::class, 'store'])->name('api.approvers.store');
Route::post('/approval-stages', [ApprovalStageController::class, 'store'])->name('api.approval-stages.store');
Route::put('/approval-stages/{id}', [ApprovalStageController::class, 'update'])->name('api.approval-stages.update');
Route::post('/expenses', [ExpenseController::class, 'store'])->name('api.expense.store');
Route::patch('/expenses/{id}/approve', [ExpenseController::class, 'approve'])->name('api.expense.approve');
Route::get('/expenses/{id}', [ExpenseController::class, 'show'])->name('api.expense.show');
