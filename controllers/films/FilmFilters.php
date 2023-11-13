<?php

namespace films;

class FilmFilters
{
    private $movies = [];

    public function __construct()
    {
        include "movies.php";
        $this->movies = $movies;

    }


    /**
     * metoda wywołująca filtry w zależności od parametrów
     * @param $param
     * @return array
     */
    public function filterByParams($param): array
    {
        switch ($param) {
            case 'random':
            {
                $films = $this->filterRandom(3);
                break;
            }
            case 'wnames':
            {
                $films = $this->filterFirstLetterName('W');
                break;
            }
            case 'count':
            {
                $films = $this->filterNameByCountWords(1);
                break;
            }
            default:
            {
                $films = $this->movies;
            }
        }
        return $films;
    }

    /**
     * Zwracane są 3 losowe tytuły
     * @param $countFilms
     * @return mixed
     */
    public function filterRandom($countFilms)
    {
        if ($countFilms && $countFilms > 0) {
            return array_rand($this->movies, $countFilms);
        }
        return [];
    }

    /**
     * Zwracane są wszystkie filmy na literę ‘W’ ale tylko jeśli mają parzystą liczbę znaków w tytule.
     * @param string $letter
     * @return array
     */
    private function filterFirstLetterName(string $letter): array
    {
        $result = [];
        if ($letter && $letter !== '') {
            foreach ($this->movies as $film) {
                if (is_string($film)) {
                    // jeśli uważamy przestrzeń między słowami za znak
                    if (strtolower(substr($film, 0, 1)) === 'w'
                        && mb_strlen($film) % 2 == 0) {
                        $result[] = $film;
                    }
                    // jeśli nie uważamy przestrzeń między słowami za znak
//                    if (strtolower(substr($film, 0, 1)) === 'w'
//                        && strlen(str_replace(' ', '', $film)) % 2 == 0 ) {
//                        $result[] = $film;
//                    }
                }
            }
        }
        return $result;
    }

    /**
     * Zwracany są wszystkie tytuły, które składają się z więcej niż 1 słowa.
     * @param int $wordsCount
     * @return array
     */
    private function filterNameByCountWords(int $wordsCount): array
    {
        $result = [];
        if ($wordsCount && is_integer($wordsCount)) {
            foreach ($this->movies as $film) {
                if (is_string($film)) {
                    $nameArray = explode(' ', $film);
                    $nameArray = array_filter($nameArray);
                    // jeśli uważamy przestrzeń między słowami za znak
                    if (count($nameArray) > $wordsCount) {
                        $result[] = $film;
                    }
                }
            }
        }
        return $result;
    }
}