<?php declare(strict_types = 1);

namespace App\Http\Controllers\Webhooks;

use App\Models\Webhook;
use Illuminate\Http\{JsonResponse, Request};

class HotmartWebhookController
{
    public function __invoke(Request $request): JsonResponse
    {
        Webhook::query()->create([
            'provider' => 'hotmart',
            'headers'  => json_encode($request->header()),
            'payload'  => json_encode($request->all()),
        ]);

        return response()->json('success', 201);
    }

}
