<?php
declare(strict_types=1);

namespace App\Enum;

/**
 * Contains the names of courses
 */
final class CourseNames
{
    public const HORS_DOEUVRES = 'Hors-d\'oeuvre';
    public const AMUSE_BOUCHE = 'Amuse-Bouche';
    public const SOUP = 'Soep';
    public const APPETIZER = 'Voorgerecht';
    public const SALAD = 'Salade';
    public const FIRST_MAIN_COURSE = 'Eerste hoofdgerecht';
    public const SECOND_MAIN_COURSE = 'Tweede hoofdgerecht';
    public const DESSERT = 'Dessert';
    public const MIGNARDISE = 'Mignardise';
    public const SIDE_DISH = 'Bijgerecht';
    public const WINE = 'Wijn';

    /**
     * @codeCoverageIgnore private by design because this is an ENUM class
     */
    private function __construct()
    {
    }

    /**
     * @return array<string>
     */
    public static function getOptions(): array
    {
        return [
            self::HORS_DOEUVRES => 'HORS_DOEUVRES',
            self::AMUSE_BOUCHE => 'AMUSE_BOUCHE',
            self::SOUP => 'SOUP',
            self::APPETIZER => 'APPETIZER',
            self::SALAD => 'SALAD',
            self::FIRST_MAIN_COURSE => 'FIRST_MAIN_COURSE',
            self::SECOND_MAIN_COURSE => 'SECOND_MAIN_COURSE',
            self::DESSERT => 'DESSERT',
            self::MIGNARDISE => 'MIGNARDISE',
            self::SIDE_DISH => 'SIDE_DISH',
            self::WINE => 'WINE',
        ];
    }
}
