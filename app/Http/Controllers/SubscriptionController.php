<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\Subscription\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected SubscriptionService $subscriptionService
    ) {
    }

    public function subscribe(Request $request)
    {
        // $user          = $request->user(); // Usuário autenticado
        // $plan          = $request->input('plan'); // ID do plano selecionado
        // $paymentMethod = $request->input('payment_method'); // ID do método de pagamento

        // $this->subscriptionService->createSubscription($user, $plan, $paymentMethod);

        return redirect()->route('subscription.success');
    }

    public function changePlan(Request $request)
    {
        $user    = $request->user();
        $newPlan = $request->input('new_plan'); // Novo plano

        $this->subscriptionService->changePlan($user, $newPlan);

        return redirect()->route('subscription.success');
    }

    public function cancel(Request $request)
    {
        $user = $request->user();
        $this->subscriptionService->cancelSubscription($user);

        return redirect()->route('subscription.canceled');
    }
}
