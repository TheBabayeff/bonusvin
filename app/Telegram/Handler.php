<?php

namespace App\Telegram;

use App\Models\TelegramUser;
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


        $this->reply('🎉 777 TL Deneme Bonusu!  En güvenli siteye başvurun ve bu müthiş fırsatı kaçırmayın!   ✅ %100 güvenli və hızlı ödeme✅Şimdi katılın ve 777 TL deneme bonusunuzu alın!  /bonusu_al')
          ;

    }

    public function bonusu_al()
    {
        $chatId = $this->chat->chat_id;
        $memberInfo = $this->chat->memberInfo($chatId);
        $userId = $memberInfo->user()->id();
        $userName = $memberInfo->user()->username() ?? 'Unknown';

        $bonusLink = 'https://cutt.ly/uex11MEc';


        $keyboard = Keyboard::make()
            ->row([Button::make('Deneme Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')]);
        ;

        // İstifadəçiyə inline keyboard ilə mesaj göndərin
        $this->chat->photo('https://bonus.vin/assets/kilic2.png')

            ->send();


        $this->chat->html("🎉 Tebrikler !  Bonusunuz Aktivleştirildi ! Sitemize üye olarak  \n💬Canlı Destek hattına yaz \n✅ 777 ₺  Deneme Bonusu anında hesabına eklensin !  \n✅ KOD: ZbahisBot")
            ->keyboard($keyboard)
            ->send();

        TelegramUser::updateOrCreate(
            ['telegram_id' => $userId],
            ['username' => $userName, 'clicked_at' => now()]
        );

    }

    public function show_other_bonuses()
    {
        $bonusLink = 'https://cutt.ly/uex11MEc';
        $keyboard = Keyboard::make()
            ->row([Button::make('🎁 İlk Yatırıma Özel %40 Nakit Bonus')->action('show_bonus_details1')])
            ->row([Button::make('🎁 Haftalık Kayıp Bonusu')->action('kayip_bonusu')])
            ->row([Button::make('🎁 Sadakat Bonusu')->action('sadakat_bonusu')]);

        $this->chat->html("🎁 Diğer Bonuslar:")
            ->keyboard($keyboard)
            ->send();
    }

    public function show_bonus_details1()
    {
        $this->chat->photo('https://bonus.vin/assets/40nakit.png')

            ->send();
        $bonusLink = 'https://cutt.ly/uex11MEc';
        $this->chat->html("İlk Yatırıma Özel %40 Nakit Bonus\n\n" .
            "• Bu bonusumuzdan sitemize yapacağınız ilk ve minimum 50 TL yatırımınız için faydalanabilirsiniz.\n" .
            "• Bu bonustan maksimum 1000 TL olarak yararlanabilirsiniz.\n" .
            "• Bonustan yararlanabilmek için yatırım esnasında \"%40 İlk Yatırım Bonusu\" kutucuğunu işaretlemeniz yeterlidir.\n" .
            "• Tüm yatırım yöntemleri üzerinden yapacağınız ilk yatırımınız için bu bonustan faydalanabilirsiniz.\n" .
            "• Kaybınız durumunda kayıp bonuslarımızdan yararlanamamaktadır.\n" .
            "• Bonustan yararlanabilmek için tüm bilgilerinizin eksiksiz ve doğru olması gerekmektedir.\n" .
            "• Bağlı bulunduğunuz İP adresinden , aile üyesine ait farklı bir hesaptan daha önce üyelik açılmış ve bonustan yararlanılmış ise bu bonusunmuzdan yararlanamazsınız.\n\n" .
            "BONUS KURALLARI\n\n" .
            "• Spor bahislerinde anapara ve bonus tutarının 2 katı kadar minimum 2 maç kombine ve her maç ayrı ayrı en az 1.55 oran olacak şekilde katılım sağlamalısınız.\n" .
            "• İki ihtimalli bahisler, iadeli bahisler, çifte şans bahisleri çevrim şartlarına uygun değildir.\n" .
            "• Yatırım + Yatırım bonusunu tek kuponda kullanmanız durumunda bahis kazancınız geçersiz sayılacaktır.\n" .
            "• Canlı Casino, Slot, Sanal Bahisler ve Canlı oyunlarda anapara + yatırım bonusunun 8 katı kadar oyunlara katılım sağlanması gerekmektedir.\n" .
            "• Tombala, Zeplin, Plinko, Spribe oyunlarında anapara + bonus tutarının 10 katı kadar oyunlara katılım sağlamanız gerekmektedir.\n\n" .
            "GENEL ŞARTLAR\n\n" .
            "• Herhangi bir bonusun güncel kural ve şartlarını takip etme yükümlülüğü oyuncunun kendisine aittir.\n" .
            "• ZBAHIS herhangi bir bonustaki kural ve şartları değiştirme ya da hiçbir gerekçe göstermeden iptal etme hakkını saklı tutar.\n" .
            "• Herhangi bir anlaşmazlık durumunda ZBAHIS tarafından alınan kararlar bağlayıcı nitelikte olacaktır."
        )->send();

        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')]);

        $this->chat->html("Bu bonusu almak için aşağıdakı buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }


    public function kayip_bonusu()
    {
        $this->chat->photo('https://bonus.vin/assets/kayipbonusu.png')

            ->send();
        $bonusLink = 'https://cutt.ly/ReywDeRg';
        $this->chat->html("ZBahis Haftalık Kayıp Bonusu\n\n" .
            "Tüm Üyelerimize Özel Haftalık Kayıplarına Ek Olarak %10 Kayıp Bonusu Sizlerle\n\n" .
            "- Haftalık 1000-2000 TL Arası Kayıplarınıza %5 Discount\n" .
            "- Haftalık 2001-5000 TL Arası Kayıplarınıza %6 Discount\n" .
            "- Haftalık 5001-10000 TL Arası Kayıplarınıza %7 Discount\n" .
            "- Haftalık 10001-20000 TL Arası Kayıplarınıza %8 Discount\n" .
            "- Haftalık 20001-30000 TL Arası Kayıplarınıza %9 Discount\n" .
            "- Haftalık 30001-50000 TL ve üzeri Kayıplarınıza %10 Discount\n\n" .
            "BONUS KURALLARI\n\n" .
            "● Pazartesi gününden Pazar gününe kadar toplam kaybınız minimum 1.000 TL ve üzeri ise bir sonraki Pazartesi günü \"HAFTALIK KAYIP BONUSU AL\" butonuna tıklayarak faydalanabilirsiniz.\n" .
            "● Bu promosyondan yararlanabilmeniz için haftalık minimum 1000 TL kaybınız olmalıdır.\n" .
            "● Discount hesaplaması yapılırken Haftalık; (Pazartesi 00:00 - Pazar 23:59) saatleri arasındaki net kayıp miktarınız üzerinden hesaplanmaktadır.\n" .
            "● Canlı destek hattından herhangi bir işlem yapılamamaktadır. Hakkınız olması durumunda otomatik olarak eklenmektedir.\n" .
            "● Anlık Kayıp bonusu haftalık kayıp bonusu almanıza engel değildir. Bu bonus üyelerimiz için ekstra bir bonustur.\n" .
            "● Haftalık Kayıp bonusunuzu, Pazartesi günleri site anasayfamızda sağ üst köşede bulunan hediye kutusu butonundan talep edebilirsiniz.\n" .
            "● Haftalık kayıp bonusundan yararlanabilmeniz için açık bahisiniz, bekleyen çekim talebiniz ve bakiyenizin 5 TL altında olması gereklidir.\n" .
            "● Bu promosyondan maksimum 5000₺'ye kadar yararlanabilir.\n" .
            "● Haftalık kayıp bonuslarınızın herhangi bir çevrim şartı bulunmamaktadır.\n" .
            "● Haftalık Kayıp bonusuyla ile almış olduğunuz bonusun 7 katı kazanç elde edebilirsiniz. Üst kazançlar silinmektedir.\n" .
            "● Haftalık Kayıp bonusu ile kazanç sağladığınız takdirde, aktif bonusunuz çekim sırasında bakiyenizden düşecektir.\n" .
            "● Haftalık kayıp bonuslarınız herhangi bir yatırımınız ve/veya yatırım bonuslarınız ile birleştirilemez.\n\n" .
            "GENEL ŞARTLAR\n\n" .
            "• Herhangi bir bonusun güncel kural ve şartlarını takip etme yükümlülüğü oyuncunun kendisine aittir.\n" .
            "• ZBAHIS herhangi bir bonustaki kural ve şartları değiştirme ya da hiçbir gerekçe göstermeden iptal etme hakkını saklı tutar.\n" .
            "• Herhangi bir anlaşmazlık durumunda ZBAHIS tarafından alınan kararlar bağlayıcı nitelikte olacaktır."
        )->send();

        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')]);

        $this->chat->html("Bu bonusu almak için aşağıdaki buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }

    public function sadakat_bonusu()
    {
        $this->chat->photo('https://bonus.vin/assets/kilic2.png')

            ->send();
        $bonusLink = 'https://cutt.ly/ReywDeRg';
        $this->chat->html("Zbahis'le Sadakat Bonusu\n\n" .
            "Ağustos ayı boyunca gün içerisinde yapmış olduğunuz 4 yatırımdan sonraki yatırım bizler tarafından hediye.\n" .
            "Ağustos Ayı boyunca yapacağınız art arda 4 para yatırımlarınızda 5. Yatırımınızı biz Hediye ediyoruz.\n\n" .
            "5. Yatırım Hakkınızı Canlı Destek hattına bağlanarak talep edebilirsiniz.\n\n" .
            "5. Yatırım Hediye Kampanyası, gün içerisinde minimum 100 TL, maksimum 3.000 TL olarak eklenmektedir.\n\n" .
            "Bonus Hesaplama yöntemi: Gün içerisinde üst üste yapmış olduğunuz 4 yatırım miktarı dikkate alınır ve en düşük yaptığınız yatırım miktarı 5. bonus olarak hesabınıza aktarılır.\n\n" .
            "Örnek: İlk Yatırımınız 1000 TL, 2. Yatırımınız 500 TL ve 3. Yatırımınız 600 TL'dir. Gün içerisinde yaptığınız en düşük yatırım miktarı 500 TL olduğu için 500 TL bonus hakkınız olur.\n\n" .
            "NOT: 4 yatırımdaki en düşük yatırım miktarı 3000 TL üzerinde olduğunda faydalanabildiğiniz miktar en yüksek 3.000 TL olarak belirlenmiştir.\n\n" .
            "5. Yatırım Hediyenizi aldıktan sonra sıradaki 4 para yatırım işleminiz için aynı gün içinde yeniden 5. yatırım hediyenizi alabilirsiniz.\n\n" .
            "5. Yatırım Hediye Bonusu'ndan, yatırımı için dilediği bonusu alan her üye faydalanabilir.\n\n" .
            "5. Yatırım Hediye Kampanyası'ndan yararlanabilmek için, ilgili yatırımlarınızdan çekim yapmamış ve herhangi bir alanda açık bakiyenizin ve aktif kuponunuzun olmaması gerekmektedir.\n\n" .
            "Bu promosyon ile yapılabilecek maksimum çekim miktarı eklenen bonusun 5 katıdır.\n\n" .
            "Bonusun çekilebilir olması için:\n\n" .
            "SPOR BAHİSLERİ: Bonusunuzun 7 Katını her bir maçın minimum 1.55 oranlı minimum 2 maçlı kombine kupon yaparak çevirim yapılmalıdır.\n\n" .
            "CANLI CASİNO: Bonusunuzun 15 Katı Kadar çevirim yapılmalıdır. Rulet Oyunlarında Maksimum 17 sayıya bahisler yapılarak çevirim tamamlanmalıdır. Baccarat %0, Rulet Oyunlarında Kırmızı-Siyah Bahisleri %0 olarak değerlendirilmektedir.\n\n" .
            "SLOT OYUNLARI: Bonusunuzun 20 Katı Kadar çevirim yapılması yeterlidir.\n\n" .
            "UÇAK OYUNLARI: Uçak Oyunlarından da bonus tutarının 25 katı kadar çevirim tamamlamanız gerekmektedir.\n\n" .
            "Minimum 1.50 Oranında atlamalar çevirime dahil edilmektedir.\n\n" .
            "Eklenen Hediye Bonusun kayıp bonus hakkı bulunmamaktadır.\n\n" .
            "ÖNEMLİ BİLGİLENDİRME: Belirtilen promosyondan yararlanabilmek için gün içerisindeki yatırımlarınız dikkate alınmaktadır, geçmişe dönük işlemler bu bonustan yararlanamamaktadır."
        )->send();
        // Sonra bonusu almaq üçün bir düymə göstəririk
        $keyboard = Keyboard::make()
            ->row([Button::make('Bu Bonusu Al')->url($bonusLink)])
            ->row([Button::make('Diğer Bonuslar')->action('show_other_bonuses')]);

        $this->chat->html("Bu bonusu almak için aşağıdaki buttona basın:")
            ->keyboard($keyboard)
            ->send();
    }

}
