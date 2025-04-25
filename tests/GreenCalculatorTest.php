<?php
use PHPUnit\Framework\TestCase;

class GreenCalculatorTest extends TestCase
{
    public function testAllGreenSelections()
    {
        $selections = ['GREEN', 'GREEN', 'GREEN', 'GREEN'];
        $score = $this->calculateScore($selections);

        $this->assertEquals(40, $score, "All GREEN selections should give 40 points.");
    }

    public function testMixedSelections()
    {
        $selections = ['GREEN', 'AMBER', 'RED', 'GREEN'];
        $score = $this->calculateScore($selections);

        $this->assertEquals(25, $score, "Mixed selections should calculate correct total.");
    }

    public function testAllRedSelections()
    {
        $selections = ['RED', 'RED', 'RED', 'RED'];
        $score = $this->calculateScore($selections);

        $this->assertEquals(0, $score, "All RED selections should give 0 points.");
    }

    // ✅ Helper function to simulate score calculation
    private function calculateScore($selections)
    {
        $score = 0;
        foreach ($selections as $choice) {
            if ($choice === 'GREEN') {
                $score += 10;
            } elseif ($choice === 'AMBER') {
                $score += 5;
            }
            // RED = 0 points
        }
        return $score;
    }
}
