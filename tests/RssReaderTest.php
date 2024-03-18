<?php declare(strict_types=1);

namespace Compolomus\RssReader\Tests;

use Compolomus\RssReader\RssReader;
use PHPUnit\Framework\TestCase;

class RssReaderTest extends TestCase
{
    private array $demo1 = [
        0 => [
            "guid"        => "https://habr.com/ru/companies/onlinepatent/articles/801085/",
            "link"        => "https://habr.com/ru/companies/onlinepatent/articles/801085/?utm_campaign=801085&utm_source=habrahabr&utm_medium=rss",
            "title"       => "Городской мозг: как Сингапур цифровизировал управление государством",
            "description" => "<img src='https://habrastorage.org/getpro/habr/upload_files/253/da2/dbb/253da2dbb6fb4cca85f4d4a45ab6045a.png' /><p>Сингапур — небольшое островное государство с площадью всего 734 кв. км и населением 5,9 млн человек. В 1960-х там не было ничего, кроме трущоб, а сейчас его называют одним из самых технологически продвинутых мест планеты.&nbsp;</p><p>Одно из самых впечатляющих преобразований — цифровизация госуправления. В то время, как в некоторых странах только начинают внедрять биометрическую идентификацию, «всевидящее око» Сингапура знает всех своих граждан в лицо в прямом смысле этого слова. А еще — следит за каждым их движением при помощи десятков тысяч камер и беспристрастных роботов-полицейских. Что это — концепция комфортного и безопасного города будущего или же цифровой ГУЛАГ? Понятное дело, что всё куда как сложнее. Разбираемся.&nbsp;</p><p></p> <a href='https://habr.com/ru/articles/801085/?utm_campaign=801085&amp;utm_source=habrahabr&amp;utm_medium=rss#habracut'>Читать далее</a>",
            "pubDate"     => "Mon, 18 Mar 2024 13:56:20 GMT",
            "category"    => [
                0 => "сингапур",
                1 => "цифровизация",
                2 => "искусственный интеллект",
            ],
            '_id'         => 3348373506,
            '_timestamp'  => 1710770180,
        ],
        1 => [
            "title"       => "ИИ в 3D: Где мы сейчас и какое будущее нас ждёт? (Часть 3)",
            "guid"        => "https://habr.com/ru/articles/800949/",
            "link"        => "https://habr.com/ru/articles/800949/?utm_campaign=800949&utm_source=habrahabr&utm_medium=rss",
            "description" => "<img src='https://habrastorage.org/getpro/habr/upload_files/38d/e12/f82/38de12f8263c75a27d6ae439631baf9e.png' /><p>Мир, в котором мы с вами живём и который непосредственно ощущаем, является объёмным: расположение любой точки в нём можно описать тремя координатами, и этот факт элементарно зашит в нашу природу. Чем больше “понимания” система искусственного интеллекта будет иметь относительно истинной сущности вещей, включая их расположение, форму и объем, тем легче она будет справляться с задачами, которые до сих пор мог выполнять только человек.&nbsp;</p><p>В этой статье разберём, как ИИ помогает решать одну из ключевых задач робототехники, а именно - понимание и ориентация в объёмных пространствах!</p><p></p> <a href='https://habr.com/ru/articles/800949/?utm_campaign=800949&amp;utm_source=habrahabr&amp;utm_medium=rss#habracut'>Читать далее</a>",
            "pubDate"     => "Mon, 18 Mar 2024 08:58:07 GMT",
            "category"    => [
                0 => "нейросети",
                1 => "машинное обучение",
                2 => "компьютерное зрение",
                3 => "робототехника",
                4 => "искусственный интеллект",
                5 => "беспилотный автомобиль",
                6 => "роботы",
                7 => "slam",
                8 => "реконструкция",
                9 => "локализация",
            ],
            '_id'         => 3767234243,
            '_timestamp'  => 1710752287,
        ],
        2 => [
            "title"       => "Симуляция миров: как работает нейросеть SORA",
            "guid"        => "https://habr.com/ru/companies/timeweb/articles/797999/",
            "link"        => "https://habr.com/ru/companies/timeweb/articles/797999/?utm_campaign=797999&utm_source=habrahabr&utm_medium=rss",
            "description" => "Видеоконтент стал неотъемлемой частью нашей жизни. ТикТок, Ютуб и прочие платформы с каждым днём всё больше используются людьми как способ отвлечься от повседневности и позволяют ненадолго предаться прокрастинации. Кто бы что ни говорил, но в 2024 году человек не представляет без него жизни, но создание качественного контента это довольно трудоемкая задача. В ней нам может помочь новая нейросеть OpenAI “SORA”.<br><br>В этой статье мы рассмотрим, как работает новая революционная нейросеть синтеза видео SORA, пофилософствуем на эту тему и, конечно, помечтаем о AGI. <br><br><div style='text-align:center;'><img src='https://habrastorage.org/webt/mu/ps/ar/mupsarjaby1ax4lkbmbb0kubtry.gif'></div> <a href='https://habr.com/ru/articles/797999/?utm_campaign=797999&amp;utm_source=habrahabr&amp;utm_medium=rss#habracut'>Читать дальше &rarr;</a>",
            "pubDate"     => "Mon, 18 Mar 2024 08:01:07 GMT",
            "category"    => [
                0 => "timeweb_статьи",
                1 => "искусственный интеллект",
                2 => "ии",
                3 => "нейросети",
                4 => "нейронные сети",
                5 => "видео",
            ],
            '_id'         => 2254168116,
            '_timestamp'  => 1710748867,
        ],
        3 => [
            "title"       => "Мозг промышленного масштаба или как воплотить мечту в реальность?",
            "guid"        => "https://habr.com/ru/articles/795985/",
            "link"        => "https://habr.com/ru/articles/795985/?utm_campaign=795985&utm_source=habrahabr&utm_medium=rss",
            "description" => "<img src='https://habrastorage.org/getpro/habr/upload_files/298/753/e7b/298753e7b1d2db1fe87860aeab623bee.png' /><p>В <a href='https://habr.com/ru/articles/785080/' rel='noopener noreferrer nofollow'>предыдущей статье</a> мы рассмотрели различные типы нейросетей и обсудили, какие задачи можно решать с их помощью. Теперь рассмотрим задачу искусственного интеллекта с организационной и технической точки зрения. </p><p>При работе над сложными проектами обычно вовлечена команда разработчиков и специалистов по обработке данных, у которых сразу возникают вопросы: как управлять проектом, совместно разрабатывать модель машинного обучения (Machine Learning model), проводить ее тестирование, каким образом синхронизировать код и результаты экспериментов? После разработки и оптимизации ML-модели возникает необходимость ее развертывания в промышленной среде. Все эти проблемы могут казаться менее увлекательными, чем решение самой задачи машинного обучения, но они имеют критическое значение для успешной реализации ML-проектов.&nbsp;</p><p>В этой статье мы подробно рассмотрим жизненный цикл ML-сервиса от идеи до разработки и внедрения, а также инструменты и принципы, используемые на каждом этапе.&nbsp; </p><p></p> <a href='https://habr.com/ru/articles/795985/?utm_campaign=795985&amp;utm_source=habrahabr&amp;utm_medium=rss#habracut'>Читать далее</a>",
            "pubDate"     => "Sun, 17 Mar 2024 11:30:15 GMT",
            "category"    => [
                0 => "mlflow",
                1 => "mlops",
                2 => "mlops tools",
                3 => "data analysis",
                4 => "data science",
                5 => "ml-модель",
                6 => "ml-инженер",
                7 => "docker",
                8 => "kubernetes",
                9 => "project management",
            ],
            '_id'         => 1118721103,
            '_timestamp'  => 1710675015,
        ],
        4 => [
            "title"       => "Художественные приемы и профессиональные термины для создания изображений с ИИ. Всё, что нужно знать",
            "guid"        => "https://habr.com/ru/articles/800703/",
            "link"        => "https://habr.com/ru/articles/800703/?utm_campaign=800703&utm_source=habrahabr&utm_medium=rss",
            "description" => "<img src='https://habrastorage.org/getpro/habr/upload_files/525/5f2/7fc/5255f27fc5e0d4c81357bac94cbb07b1.jpg' /><p>В этой статье собраны все основные понятия для написания текстовой подсказки для генерации изображений с помощью нейросети.</p><p>Если вы хотите создавать качественные изображения, нужно понимать (или просто запомнить) некоторые профессиональные термины и приемы, используемые художниками и фотографами.</p><p>В этой статье мы разберем такие ключевые факторы, как высокая детализация, освещение, стиль изображения и другое.</p> <a href='https://habr.com/ru/articles/800703/?utm_campaign=800703&amp;utm_source=habrahabr&amp;utm_medium=rss#habracut'>Читать далее</a>",
            "pubDate"     => "Sat, 16 Mar 2024 12:30:31 GMT",
            "category"    => [
                0 => "нейросети",
                1 => "нейроарт",
                2 => "иллюстрации",
                3 => "midjourney",
                4 => "stablediffusion",
                5 => "dalle-2",
                6 => "sdxl",
            ],
            '_id'         => 1000816785,
            '_timestamp'  => 1710592231,
        ],
    ];

    private array $demo2 = [
        0 => [
            "title"       => "Обзор видеокарты Palit GeForce RTX 4070 Ti SUPER JetStream OC: ничего лишнего",
            "link"        => "https://3dnews.ru/1101549",
            "guid"        => "https://3dnews.ru/1101549/#65ef9747742eec783c8b45cb",
            "enclosure"   => [
                "@attributes" => [
                    "url"    => "https://3dnews.ru/assets/external/illustrations/2024/03/12/1101549/sm.cover.800.jpg",
                    "length" => "232970",
                    "type"   => "image/jpeg",
                ],
            ],
            "description" => "<img align='left' hspace='10' src='https://3dnews.ru/assets/external/icons/2024/03/12/1101549.jpg' border='0' height='85' width='120' />GeForce RTX 4070 Ti SUPER в исполнении Palit отличается спартанским внешним видом без RGB-подсветки и почти незаметным заводским разгоном. Но эта видеокарта позаимствовала мощную систему охлаждения у RTX 4080 SUPER, а главное, стоит дешевле большинства аналогов",
            "pubDate"     => "Fri, 15 Mar 2024 00:00:00 +0300",
            "category"    => "Видеокарты - NVIDIA",
            '_id'         => 991860995,
            '_timestamp'  => 1710450000,
        ],
        1 => [
            "title"       => "Обзор видеокарты NVIDIA GeForce RTX 4080 SUPER: когда цена — это апгрейд",
            "link"        => "https://3dnews.ru/1101274",
            "guid"        => "https://3dnews.ru/1101274/#65e77f9e742eec3db88b45b0",
            "enclosure"   => [
                "@attributes" => [
                    "url"    => "https://3dnews.ru/assets/external/illustrations/2024/03/05/1101274/sm.cover.800.jpg",
                    "length" => "231730",
                    "type"   => "image/jpeg",
                ],
            ],
            "description" => "<img align='left' hspace='10' src='https://3dnews.ru/assets/external/icons/2024/03/05/1101274.jpg' border='0' height='85' width='120' />GeForce RTX 4080 SUPER стал ненамного быстрее оригинального RTX 4080, зато ощутимо дешевле (по крайней мере за рубежом), а вслед за ним упали в цене и видеокарты AMD. Самое время окинуть свежим взглядом лучшие предложения обеих компаний. Тестирование выполнено на примере ускорителя Palit JetStream OC",
            "pubDate"     => "Mon, 11 Mar 2024 00:00:00 +0300",
            "category"    => "Видеокарты - NVIDIA",
            '_id'         => 1808638200,
            '_timestamp'  => 1710104400,
        ],
        2 => [
            "title"       => "Обзор видеокарты NVIDIA GeForce RTX 4070 Ti SUPER: RTX 4080 на минималках",
            "link"        => "https://3dnews.ru/1100789",
            "guid"        => "https://3dnews.ru/1100789/#65db9269b4182e383e0b3310",
            "enclosure"   => [
                "@attributes" => [
                    "url"    => "https://3dnews.ru/assets/external/illustrations/2024/02/25/1100789/sm.cover.800.jpg",
                    "length" => "276171",
                    "type"   => "image/jpeg",
                ],
            ],
            "description" => "<img align='left' hspace='10' src='https://3dnews.ru/assets/external/icons/2024/02/25/1100789.jpg' border='0' height='85' width='120' />Выбранная маркетологами NVIDIA рекомендованная стоимость GeForce RTX 4070 Ti SUPER прямо говорит, что новинка призвана заменить уходящий на пенсию RTX 4070 Ti. А с технической точки зрения она является младшей разновидностью RTX 4080 и соперником Radeon RX 7900 XT. Посмотрим, как реализована эта задумка. Тестирование выполнено на примере видеокарты GIGABYTE AORUS MASTER",
            "pubDate"     => "Wed, 28 Feb 2024 00:00:00 +0300",
            "category"    => "Видеокарты - NVIDIA",
            '_id'         => 747857156,
            '_timestamp'  => 1709067600,

        ],
        3 => [
            "title"       => "Наныли: обзор видеокарты NVIDIA GeForce RTX 4070 SUPER",
            "link"        => "https://3dnews.ru/1099811",
            "guid"        => "https://3dnews.ru/1099811/#65bfbe89b4182e3067c04d67",
            "enclosure"   => [
                "@attributes" => [
                    "url"    => "https://3dnews.ru/assets/external/illustrations/2024/02/04/1099811/sm.cover.800.jpg",
                    "length" => "276951",
                    "type"   => "image/jpeg",
                ],
            ],
            "description" => "<img align='left' hspace='10' src='https://3dnews.ru/assets/external/icons/2024/02/04/1099811.jpg' border='0' height='85' width='120' />GeForce RTX 4070 SUPER удостоился самого щедрого апгрейда среди трех моделей 40-й серии — все для того, чтобы переманить покупателей у более доступного Radeon RX 7800 XT. Рассмотрим новинку на примере ускорителя GIGABYTE AORUS MASTER",
            "pubDate"     => "Tue, 06 Feb 2024 00:00:00 +0300",
            "category"    => "Видеокарты - NVIDIA",
            '_id'         => 1133702940,
            '_timestamp'  => 1707166800,
        ],
    ];

    /**
     * @return void
     * @throws \Exception
     */
    public function test_getPostsFromChannel_v1(): void
    {
        $rssReader = new RssReader();

        // Fetch all posts
        $result = $rssReader->getPostsFromChannel(__DIR__ . '/demo1.rss');

        // Compare expected data with the result
        static::assertEquals($this->demo1, $result);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function test_getPostsFromChannel_v2(): void
    {
        $rssReader = new RssReader();

        // Fetch all posts
        $result = $rssReader->getPostsFromChannel(__DIR__ . '/demo2.rss');

        // Compare expected data with the result
        static::assertEquals($this->demo2, $result);
    }
}
