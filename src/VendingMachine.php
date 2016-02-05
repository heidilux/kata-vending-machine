<?php


class VendingMachine
{
    public $display;
    public $products = [];
    public $validCoins = [];
    public $bank = [];

    public function __construct()
    {
        $this->display = "INSERT COINS";
        $this->validCoins = ['nickel', 'dime', 'quarter'];
        $this->bank = [
            'nickel'    => 10,
            'dime'      => 10,
            'quarter'   => 10
        ];
        $this->products = [
            'chips' => [
                'price'     => 50,
                'inventory' => 5
            ],
            'candy' => [
                'price'     => 65,
                'inventory' => 5
            ],
            'cola' => [
                'price'     => 100,
                'inventory' => 5
            ]
        ];
    }

    public function acceptCoins()
    {
        // As a vendor
        // I want a vending machine that accepts coins
        // So that I can collect money from the customer

    }

    public function selectProduct()
    {
        // As a vendor
        // I want customers to select products
        // So that I can give them an incentive to put money in the machine

    }

    public function makeChange()
    {
        // As a vendor
        // I want customers to receive correct change
        // So that they will use the vending machine again

    }

    public function returnCoins()
    {
        // As a customer
        // I want to have my money returned
        // So that I can change my mind about buying stuff from the machine

    }

    public function exactChangeOnly()
    {
        // As a customer
        // I want to ve told when exact change is required
        // So that I can determine if I can buy something with the money
        // I have before inserting it...

    }
}