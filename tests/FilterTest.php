<?php
require __DIR__ . "/../controllers/films/FilmFilters.php";

use films\FilmFilters;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{

    /**
     * @var FilmFilters
     */
    public $filmFilter;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->filmFilter = new FilmFilters();
    }

    /**
     * test filtru, który zwraca 3 losowe tytuły.
     * @return void
     */
    public function testRandomFilter()
    {
        $expected = 3;
        $this->assertEquals($expected, count($this->filmFilter->filterByParams('random')));
    }

    /**
     * test filtru, który
     * zwraca wszystkie filmy na literę ‘W’ ale tylko jeśli mają parzystą liczbę znaków w tytule.
     * @return void
     */
    public function testWnamesFilter()
    {
        $films = $this->filmFilter->filterByParams('wnames');
        $expected = [
            'Władca Pierścieni: Drużyna Pierścienia',
            'Wyspa tajemnic',
            'Whiplash'
        ];
        // jeśli nie uważamy przestrzeń między słowami za znak
        $expectedSecond = [
            'Wielki Gatsby',
            'Władca Pierścieni: Dwie wieże',
            'Wielki Gatsby',
            'Władca Pierścieni: Powrót króla'
        ];
        foreach ($films as $film) {
            $this->assertContains($film, $expected);
        }

    }

    /**
     * test filtru, który
     * zwraca wszystkie tytuły, które składają się z więcej niż 1 słowa
     * @return void
     */
    public function testCountWordsFilter()
    {
        $films = $this->filmFilter->filterByParams('count');
        foreach ($films as $film) {
            $film == trim($film);
            $this->assertTrue(strpos($film, ' ') !== false);
        }
    }
}
