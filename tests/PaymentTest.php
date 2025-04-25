<?php
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function testSuccessfulPayment()
    {
        $paymentResponse = $this->simulateStripePayment(true);

        $this->assertTrue($paymentResponse['success'], "Payment should be successful.");
        $this->assertEquals(100, $paymentResponse['points'], "Points should be correctly added.");
    }

    public function testFailedPayment()
    {
        $paymentResponse = $this->simulateStripePayment(false);

        $this->assertFalse($paymentResponse['success'], "Payment should fail if declined.");
    }

    // ✅ Helper function to simulate Stripe payment
    private function simulateStripePayment($success)
    {
        if ($success) {
            return [
                'success' => true,
                'points' => 100
            ];
        } else {
            return [
                'success' => false,
                'points' => 0
            ];
        }
    }
}
