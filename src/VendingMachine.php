<?php


class VendingMachine
{
    public $display;
    public $bank = [];
    public $products = [];
    public $currentAmount;
    public $validCoins = [];
    public $invalidCoins = [];
    public $coinReturnContents= [];

    public function __construct()
    {
        $this->display = "INSERT COINS";
        $this->currentAmount = 0;
        $this->coinReturnContents = [];
        $this->validCoins = ['nickel', 'dime', 'quarter'];
        $this->invalidCoins = ['penny'];
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

    public function acceptCoins(array $coins)
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');

        foreach ($coins as $type => $qty) {
            switch ($type) {
                case 'nickel':
                    $this->currentAmount += $qty * 5;
                    $this->bank['nickel'] += $qty;
                    $displayAmount = $this->currentAmount / 100;
                    $this->display = money_format("%.2n", $displayAmount);
                    break;
                case 'dime':
                    $this->currentAmount += $qty * 10;
                    $this->bank['dime'] += $qty;
                    $displayAmount = $this->currentAmount / 100;
                    $this->display = money_format("%.2n", $displayAmount);
                    break;
                case 'quarter':
                    $this->currentAmount += $qty * 25;
                    $this->bank['quarter'] += $qty;
                    $displayAmount = $this->currentAmount / 100;
                    $this->display = money_format("%.2n", $displayAmount);
                    break;
                case 'penny':
                    $this->coinReturnContents = [$qty => $type];
                    break;
            }
        }
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