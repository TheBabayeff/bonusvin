<?php

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\DTO\Contact;
use App\Models\User;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Log;

class Handler extends WebhookHandler
{
    public function start()
    {
        $this->reply('🎉 777 TL Deneme Bonusu! 🎉Yeter bu kadar, diğerleri sizi aldattı. En güvenli siteye başvurun ve bu müthiş fırsatı kaçırmayın!✅ %100 güvenli və hızlı ödeme✅Şimdi katılın ve 777 TL deneme bonusunuzu alın! Tek yapmanız gereken aşağıdaki adımları izlemek:  Bonusunuzu almak için linke tıklayın.👉 /get_bonus')
          ;
    }

    public function get_bonus()
    {

        $bonusLink = 'https://cutt.ly/ReywDeRg';


        $keyboard = Keyboard::make()
            ->row([Button::make('Bonusunuzu almaq üçün buraya tıklayın')->url($bonusLink)]);

        // İstifadəçiyə inline keyboard ilə mesaj göndərin
        $this->chat->message('777 TL Deneme Bonusunuzu almak için  Tıkla:')
            ->keyboard($keyboard)
            ->send();

    }

}
