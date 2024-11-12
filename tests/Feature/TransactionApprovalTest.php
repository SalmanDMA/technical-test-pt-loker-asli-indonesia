<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_approval_flow()
    {
        // 1. Add 3 approvers using the endpoint
        $approvers = ['Ana', 'Ani', 'Ina'];
        $approverIds = [];
        foreach ($approvers as $approverName) {
            $response = $this->postJson('/api/approvers', ['name' => $approverName]);
            $response->assertStatus(201);
            $approverIds[] = $response->json('id');
        }

        // 2. Create 'menunggu persetujuan' and 'disetujui' statuses
        Status::create(['name' => 'menunggu persetujuan']);
        Status::create(['name' => 'disetujui']);

        // 3. Create 3 approval stages using the approver IDs we just created
        foreach ($approverIds as $approverId) {
            $response = $this->postJson('/api/approval-stages', [
                'approver_id' => $approverId,
            ]);
            $response->assertStatus(201);
        }

        // 4. Create 4 expense records through the endpoint
        $expenses = [];
        for ($i = 1; $i <= 4; $i++) {
            $response = $this->postJson('/api/expenses', [
                'amount' => 100 * $i,
            ]);
            $response->assertStatus(201);
            $expenses[] = $response->json('id');
        }

        // 5. Process the approval for each expense

        // 5.1 First Expense - Approved by all approvers
        foreach ($approverIds as $approverId) {
            $this->patchJson("/api/expenses/{$expenses[0]}/approve", [
                'approver_id' => $approverId,
            ])->assertStatus(200);
        }
        // Ensure the status of the expense is now 'disetujui'
        $response = $this->getJson("/api/expenses/{$expenses[0]}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => ['name' => 'disetujui']
            ]);

        // 5.2 Second Expense - Approved by 2 approvers only
        foreach (array_slice($approverIds, 0, 2) as $approverId) {
            $this->patchJson("/api/expenses/{$expenses[1]}/approve", [
                'approver_id' => $approverId,
            ])->assertStatus(200);
        }
        // The status is still 'menunggu persetujuan' because not all approvers have approved
        $response = $this->getJson("/api/expenses/{$expenses[1]}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => ['name' => 'menunggu persetujuan']
            ]);

        // 5.3 Third Expense - Approved by 1 approver only
        $this->patchJson("/api/expenses/{$expenses[2]}/approve", [
            'approver_id' => $approverIds[0],
        ])->assertStatus(200);
        // The status is still 'menunggu persetujuan'
        $response = $this->getJson("/api/expenses/{$expenses[2]}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => ['name' => 'menunggu persetujuan']
            ]);

        // 5.4 Fourth Expense - No approver has approved yet
        // The status remains 'menunggu persetujuan' by default
        $response = $this->getJson("/api/expenses/{$expenses[3]}");
        $response->assertStatus(200)
            ->assertJson([
                'status' => ['name' => 'menunggu persetujuan']
            ]);
    }
}
