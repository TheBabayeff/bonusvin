<?php

namespace App\Telegram;

use App\Models\TelegramUser;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\DTO\Contact;
use App\Models\User;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;

class HandlerWorking extends WebhookHandler
{
    public function start()
    {
        $this->reply('🎉 777 TL Deneme Bonusu! 🎉Yeter bu kadar, diğerleri sizi aldattı. En güvenli siteye başvurun ve bu müthiş fırsatı kaçırmayın!✅ %100 güvenli və hızlı ödeme✅Şimdi katılın ve 777 TL deneme bonusunuzu alın! Tek yapmanız gereken aşağıdaki adımları izlemek:  Bonusunuzu almak için linke tıklayın.👉 /get_bonus')
          ;
    }

    public function get_bonus()
    {
        Log::info('get_bonus metodu çağırıldı.');

        // Tam məlumat strukturunu log faylına yazdırın
        $data = $this->data->all();
        Log::info('Tam məlumat: ' . print_r($data, true));

        // Gələn məlumatın tam strukturunu yoxlayın və log faylına yazdırın
        foreach ($data as $key => $value) {
            Log::info("Açar: $key, Dəyər: " . json_encode($value));
        }

        // Istifadəçi məlumatlarını memberInfo metodu ilə əldə edin
        if ($this->chat) {
            $chatId = $this->chat->chat_id;
            $memberInfo = $this->chat->memberInfo($chatId);
            $userId = $memberInfo->user()->id();
            $userName = $memberInfo->user()->username() ?? 'Unknown';
            Log::info("İstifadəçi ID: $userId, İstifadəçi adı: $userName");

            // Bonus linkini təyin edin
            $bonusLink = 'https://cutt.ly/ReywDeRg';
            // Inline keyboard yaratmaq
            $keyboard = Keyboard::make()
                ->row([Button::make('Bonusunuzu almaq üçün buraya tıklayın')->url($bonusLink)]);

            // İstifadəçiyə inline keyboard ilə mesaj göndərin
            $this->chat->message('Bonusunuzu almaq üçün düyməyə tıklayın:')
                ->keyboard($keyboard)
                ->send();

            // İstifadəçi məlumatını verilənlər bazasında saxlayın
            TelegramUser::updateOrCreate(
                ['telegram_id' => $userId],
                ['username' => $userName, 'clicked_at' => now()]
            );

            Log::info('Mesaj və düymə göndərildi.');
        } else {
            Log::error('Chat məlumatları alınamadı.');
        }
    }



}
