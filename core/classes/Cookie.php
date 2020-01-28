<?php


namespace Core;


class Cookie extends \Core\Abstracts\Cookie
{

    /**
     * Konstruktorius paprasčiausia turi nuset'tintis $name
     */
    public function __construct(string $name)
    {
        $this->name($name);
    }

    /**
     * Turi patikrinti ar cookie duotu pavadinimu
     * egzistuoja
     */
    public function exists(): bool
    {
        if (!isset($this->name))
        {
            return true;
        }
    }

    /**
     * Turi return'inti json_decode'intą cookie'o
     * turinį.
     *
     * Jei nepavyko json_decode'inti,
     * return'inti tuščią array
     *
     * Jei cookie'is nustatytu pavadinimu neegzistuoja,
     * turi return'inti tuščią array'ų
     */
    public function read(): array
    {
        $cookie_array = [];
        if (isset($_COOKIE[$this->name])) {
            return json_decode(($_COOKIE[$this->name]), true);
        } else {
            return $cookie_array;
        }
    }

    /**
     * Turi į Cookie duotu pavadinimu
     * išsaugoti json_encode'intą $data array'jų
     * (Google setcookie)
     *
     * Į cookie galima įrašyt tik string'ą.
     * Kadangi mes norim galimybę turėti į tą patį
     * Cookie storinti daugiau data'os, galim tiesiog
     * encode'inti ir decode'inti array'jų su json'u.
     *
     * Mes į cookie įrašysim už'json_encodinę $data
     * ir atkursim atgal json_decode'inę tai ką radom Cookie
     *
     * @param $data array
     * @param $expires_in int Už kiek laiko sekundemis cookie nebegalios
     */
    public function save(array $data, int $expires_in = 3600): void
    {
        $cookie_string = json_encode($data);
        setcookie($this->name, $cookie_string, $expires_in);
    }

    /**
     * Turi ištrinti Cookie
     * (Use google)
     */
    public function delete(): void
    {
        setcookie($this->name, null, -1);
    }
}