<?php

namespace App\Enums;

enum BusinessType: string
{
    case Restaurant = 'restaurant';
    case Hamburger = 'hamburger';
    case Acai = 'acai';
    case Pizzeria = 'pizzeria';
    case Bakery = 'bakery';
    case CoffeeShop = 'coffee_shop';
    case LunchBox = 'lunch_box';
    case CandyStore = 'candy_store';
    case FoodTruck = 'food_truck';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Restaurant => 'Restaurante',
            self::Hamburger => 'Hamburgueria',
            self::Acai => 'Loja de açaí',
            self::Pizzeria => 'Pizzaria',
            self::Bakery => 'Padaria',
            self::CoffeeShop => 'Cafeteria',
            self::LunchBox => 'Marmitaria',
            self::CandyStore => 'Doceria',
            self::FoodTruck => 'Food truck',
            self::Other => 'Outro',
        };
    }
}