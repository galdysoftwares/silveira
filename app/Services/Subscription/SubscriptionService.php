<?php declare(strict_types = 1);

namespace App\Services\Subscription;

use App\Models\User;
use Exception;

class SubscriptionService
{
    /**
     * Iniciar uma nova assinatura para o usuário.
     *
     * @param User $user
     * @param string $plan
     * @param string $paymentMethod
     * @return void
     */
    public function createSubscription(User $user, string $plan, string $paymentMethod)
    {
        try {
            // Atualiza o método de pagamento do usuário
            $user->updateDefaultPaymentMethod($paymentMethod);

            // Cria a assinatura
            $user->newSubscription('default', $plan)->create($paymentMethod);
        } catch (Exception $e) {
            // Aqui você pode logar o erro ou lidar com o tratamento necessário
            throw new Exception("Erro ao criar assinatura: " . $e->getMessage());
        }
    }

    /**
     * Trocar o plano de assinatura do usuário.
     *
     * @param User $user
     * @param string $newPlan
     * @return void
     */
    public function changePlan(User $user, string $newPlan)
    {
        try {
            // Altera o plano atual do usuário
            $user->subscription('default')->swap($newPlan);
        } catch (Exception $e) {
            throw new Exception("Erro ao trocar de plano: " . $e->getMessage());
        }
    }

    /**
     * Cancelar a assinatura do usuário.
     *
     * @param User $user
     * @return void
     */
    public function cancelSubscription(User $user)
    {
        try {
            $user->subscription('default')->cancel();
        } catch (Exception $e) {
            throw new Exception("Erro ao cancelar assinatura: " . $e->getMessage());
        }
    }

    /**
     * Reativar uma assinatura cancelada.
     *
     * @param User $user
     * @return void
     */
    public function resumeSubscription(User $user)
    {
        try {
            $user->subscription('default')->resume();
        } catch (Exception $e) {
            throw new Exception("Erro ao reativar assinatura: " . $e->getMessage());
        }
    }
}
