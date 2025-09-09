<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class NotificationSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gün sonu veya stok girişi yapılmadı bildirimini gönderir';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $tokens = User::whereNotNull('notification_token')->get();
        $expoPushTokens = [];

        foreach ($tokens as $key => $value) {
            $this->info($value->notification_token);
            array_push($expoPushTokens, ['ExponentPushToken[' . $value->notification_token . ']']);
        }

        $messages = [];

        foreach ($expoPushTokens as $token) {
            $messages[] = [
                'to' => $token,
                'sound' => 'default',
                'title' => 'Uyarı',
                'body' => 'Bugüne ait Stok girişi veya gün sonu işlemi yapılmadı',
                'data' => ['type' => 'stock_endofday_alert'],
            ];
        }

        // Expo Push API endpoint
        $response = Http::post('https://exp.host/--/api/v2/push/send', $messages);

        if ($response->successful()) {
            $this->info('Bildirimler başarıyla gönderildi!');
        } else {
            $this->error('Bildirim gönderilirken hata oluştu: ' . $response->body());
        }
    }
}
