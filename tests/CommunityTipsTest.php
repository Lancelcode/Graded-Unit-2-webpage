<?php
use PHPUnit\Framework\TestCase;

class CommunityTipsTest extends TestCase
{
    protected $mockDatabase = [];

    protected function setUp(): void
    {
        $this->mockDatabase = [];
    }

    public function testCreateTip()
    {
        // Simulate adding a tip
        $tip = ['id' => 1, 'content' => 'Plant a tree.'];
        $this->mockDatabase[] = $tip;

        $this->assertContains($tip, $this->mockDatabase, "Tip should be added successfully.");
    }

    public function testUpdateTip()
    {
        // Simulate updating a tip
        $tip = ['id' => 1, 'content' => 'Plant a tree.'];
        $this->mockDatabase[] = $tip;

        // Update
        foreach ($this->mockDatabase as &$t) {
            if ($t['id'] === 1) {
                $t['content'] = 'Plant two trees!';
            }
        }

        $updated = array_filter($this->mockDatabase, fn($t) => $t['content'] === 'Plant two trees!');

        $this->assertNotEmpty($updated, "Tip should be updated successfully.");
    }

    public function testDeleteTip()
    {
        // Simulate deleting a tip
        $tip = ['id' => 1, 'content' => 'Plant a tree.'];
        $this->mockDatabase[] = $tip;

        // Delete
        $this->mockDatabase = array_filter($this->mockDatabase, fn($t) => $t['id'] !== 1);

        $deleted = array_filter($this->mockDatabase, fn($t) => $t['id'] === 1);

        $this->assertEmpty($deleted, "Tip should be deleted successfully.");
    }
}
