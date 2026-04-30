<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected OrderService $orderService;
    protected string $paystackSecretKey;
    protected string $paystackPublicKey;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->paystackSecretKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY'));
        $this->paystackPublicKey = config('services.paystack.public_key', env('PAYSTACK_PUBLIC_KEY'));
    }

    /**
     * Initialize payment with Paystack
     */
    public function initializePayment(Order $order, string $gateway = 'paystack'): array
    {
        if ($gateway === 'paystack') {
            return $this->initializePaystackPayment($order);
        }

        throw new \Exception("Unsupported payment gateway: {$gateway}");
    }

    /**
     * Initialize Paystack payment
     */
    protected function initializePaystackPayment(Order $order): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->paystackSecretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transaction/initialize', [
            'email' => $order->user->email,
            'amount' => $order->total * 100, // Convert to kobo
            'currency' => 'NGN',
            'reference' => $this->generatePaymentReference($order),
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->user->name,
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Paystack initialization failed', [
                'order_id' => $order->id,
                'response' => $response->json(),
            ]);
            throw new \Exception('Payment initialization failed');
        }

        $data = $response->json()['data'];

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'gateway' => 'paystack',
            'gateway_reference' => $data['reference'],
            'amount' => $order->total,
            'currency' => 'NGN',
            'status' => 'pending',
        ]);

        return [
            'authorization_url' => $data['authorization_url'],
            'access_code' => $data['access_code'],
            'reference' => $data['reference'],
        ];
    }

    /**
     * Verify payment from Paystack webhook
     */
    public function verifyPayment(string $reference, string $gateway = 'paystack'): Payment
    {
        if ($gateway === 'paystack') {
            return $this->verifyPaystackPayment($reference);
        }

        throw new \Exception("Unsupported payment gateway: {$gateway}");
    }

    /**
     * Verify Paystack payment
     */
    protected function verifyPaystackPayment(string $reference): Payment
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->paystackSecretKey,
        ])->get("https://api.paystack.co/transaction/verify/{$reference}");

        if (!$response->successful()) {
            throw new \Exception('Payment verification failed');
        }

        $data = $response->json()['data'];

        $payment = Payment::where('gateway_reference', $reference)->firstOrFail();

        if ($data['status'] === 'success') {
            $this->handlePaymentSuccess($payment, $data);
        } else {
            $this->handlePaymentFailure($payment, $data);
        }

        return $payment->fresh();
    }

    /**
     * Handle successful payment
     */
    public function handlePaymentSuccess(Payment $payment, array $gatewayResponse): void
    {
        $payment->update([
            'status' => 'paid',
            'gateway_response' => $gatewayResponse,
            'paid_at' => now(),
        ]);

        // Update order status
        $this->orderService->updateStatus($payment->order, 'processing');

        // Fire event
        // event(new PaymentReceived($payment));

        Log::info('Payment successful', [
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'amount' => $payment->amount,
        ]);
    }

    /**
     * Handle failed payment
     */
    public function handlePaymentFailure(Payment $payment, array $gatewayResponse): void
    {
        $payment->update([
            'status' => 'failed',
            'gateway_response' => $gatewayResponse,
        ]);

        Log::warning('Payment failed', [
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'reason' => $gatewayResponse['gateway_response'] ?? 'Unknown',
        ]);
    }

    /**
     * Process refund
     */
    public function processRefund(Payment $payment, ?float $amount = null, ?string $reason = null): bool
    {
        if ($payment->status !== 'paid') {
            throw new \Exception('Can only refund paid payments');
        }

        $refundAmount = $amount ?? $payment->amount;

        if ($payment->gateway === 'paystack') {
            return $this->processPaystackRefund($payment, $refundAmount, $reason);
        }

        throw new \Exception("Refund not supported for gateway: {$payment->gateway}");
    }

    /**
     * Process Paystack refund
     */
    protected function processPaystackRefund(Payment $payment, float $amount, ?string $reason): bool
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->paystackSecretKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/refund', [
            'transaction' => $payment->gateway_reference,
            'amount' => $amount * 100, // Convert to kobo
            'currency' => 'NGN',
            'customer_note' => $reason,
        ]);

        if ($response->successful()) {
            $payment->update(['status' => 'refunded']);
            
            Log::info('Refund processed', [
                'payment_id' => $payment->id,
                'amount' => $amount,
            ]);

            return true;
        }

        Log::error('Refund failed', [
            'payment_id' => $payment->id,
            'response' => $response->json(),
        ]);

        return false;
    }

    /**
     * Get payment by reference
     */
    public function getPaymentByReference(string $reference): ?Payment
    {
        return Payment::where('gateway_reference', $reference)
            ->with('order')
            ->first();
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(Order $order): ?string
    {
        return $order->payment?->status;
    }

    /**
     * Generate unique payment reference
     */
    protected function generatePaymentReference(Order $order): string
    {
        return 'BH-' . $order->order_number . '-' . time();
    }

    /**
     * Verify webhook signature (Paystack)
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $hash = hash_hmac('sha512', $payload, $this->paystackSecretKey);
        return hash_equals($hash, $signature);
    }

    /**
     * Handle Paystack webhook
     */
    public function handlePaystackWebhook(array $payload): void
    {
        $event = $payload['event'];
        $data = $payload['data'];

        switch ($event) {
            case 'charge.success':
                $payment = $this->getPaymentByReference($data['reference']);
                if ($payment && $payment->status === 'pending') {
                    $this->handlePaymentSuccess($payment, $data);
                }
                break;

            case 'charge.failed':
                $payment = $this->getPaymentByReference($data['reference']);
                if ($payment) {
                    $this->handlePaymentFailure($payment, $data);
                }
                break;

            default:
                Log::info('Unhandled webhook event', ['event' => $event]);
        }
    }

    /**
     * Get Paystack public key for frontend
     */
    public function getPublicKey(): string
    {
        return $this->paystackPublicKey;
    }
}
