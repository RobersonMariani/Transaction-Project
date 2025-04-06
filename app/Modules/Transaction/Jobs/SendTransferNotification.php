<?php

namespace App\Modules\Transaction\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTransferNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5; // Quantidade de tentativas
    public int $backoff = 10; // Tempo de espera entre tentativas (em segundos)

    public function __construct(
        protected string $to,
        protected string $message
    ) {}

    public function handle(): void
    {
        try {
            $response = Http::post('https://util.devi.tools/api/v1/notify', [
                'to' => $this->to,
                'message' => $this->message,
            ]);

            $data = $response->json();

            /** @var array{status?: string} $data */
            if (($data['status'] ?? '') !== 'success') {
                Log::warning('Falha no envio de notificação', [
                    'to' => $this->to,
                    'message' => $this->message,
                    'response' => $data,
                ]);

                throw new \Exception('Falha ao enviar notificação');
            }
        } catch (\Throwable $e) {
            Log::error("Exceção ao enviar notificação: {$e->getMessage()}", [
                'to' => $this->to,
                'message' => $this->message,
            ]);

            // Lança novamente para acionar retry
            throw $e;
        }
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
