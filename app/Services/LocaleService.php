<?php

namespace App\Services;

use Illuminate\Http\Request;
use URL;
use App;

class LocaleService
{
    /**
     * @var string
     *
     * Код визначеної мови
     */
    private $locale = '';

    /**
     * @var string
     *
     * Префікс для роутера
     */
    private $prefix = '';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     *
     * Мова за замовчуванням
     */
    private $default = '';

    /**
     * @var array
     *
     * Підтримувані мови
     */
    private $support = [];

    /**
     * @var bool
     *
     * Приховувати префікс для дефолтної мови
     */
    private $hide_default = true;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->default = config('locale.default');
        $this->support = config('locale.support');
        $this->hide_default = config('locale.hide_default');
        $this->locale = config('locale.default');

        $this->boot($request);
    }

    private function boot(Request $request): void
    {
        $lang = $request->segment(1);

        if (!in_array($lang, $this->support)) $lang = $this->default;

        config()->set('app.locale', $lang);
        config()->set('locale.current', $lang);
        config()->set('locale.prefix', ($lang == $this->default && $this->hide_default) ? '' : $lang);

        App::setLocale($lang);

        $this->locale = $lang;
        $this->prefix = config('locale.prefix');
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function localizeUrl(string $locale, string $url = ''): string
    {
        // парсимо адресу
        $url = parse_url($url != '' ? $url : URL::previous());

        // Протокол
        $scheme = $url['scheme'];

        // Хост
        $host = $url['host'];

        // УРІ запрос
        $path = trim($url['path'] ?? '', '/') ?? '';

        // Запрос
        $query = $url['query'] ?? '';
        $query = $query == '' ? '' : "?$query";

        // якщо локаль не підтримується то дефолт, защита від дурака
        $locale = in_array($locale, $this->support) ? $locale : $this->default;

        // Префікс, якщо локаль дефолтна і необхвдно приховувати пуста строка інакше получена локаль
        $prefix = (($locale == $this->default) && $this->hide_default) ? '' : $locale;

        // якщо uri не порожній
        if ($path != '') {

            // розбиваємо на сегменти uri
            $segments = explode('/', trim($path, '/'));

            // якщо получений префікс не підтримується то вставляємо в початок новий
            if (!in_array($segments[0], $this->support)) array_unshift($segments, $prefix);

            // інакше заміняємо існуючий
            else $segments[0] = $prefix;


            // склеюємо новий uri
            $path = trim(implode('/', $segments), '/');
        } else {
            // якщо uri порожній то uri = prefix
            $path = $prefix;
        }

        // Нова адреса
        $new = "$scheme://$host/$path$query";

        return $new;
    }

    public function setUserLocale(string $locale): void
    {
        $this->request->session()->put('locale', $locale);

        customer()->update(['locale' => $locale]);
    }

    /**
     * @return array
     */
    public function getSupport(): array
    {
        return $this->support;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->default;
    }

    /**
     * @return bool
     */
    public function isHideDefault(): bool
    {
        return $this->hide_default;
    }
}