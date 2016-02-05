<?php


class VendingMachine
{
    public $display;
    public $coins = [];
    public $bank = [];
    public $products = [];
    public $currentAmount;
    public $validCoins = [];
    public $productDispensed;
    public $invalidCoins = [];
    public $coinReturnContents= [];

    public function __construct()
    {
        $this->display = "INSERT COINS";
        $this->productDispensed = false;
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
        $this->coins = $coins;

        foreach ($coins as $type => $qty) {
            switch ($type) {
                case 'nickel':
                    $this->currentAmount += $qty * 5;
                    $displayAmount = $this->currentAmount / 100;
                    $this->display = money_format("%.2n", $displayAmount);
                    break;
                case 'dime':
                    $this->currentAmount += $qty * 10;
                    $displayAmount = $this->currentAmount / 100;
                    $this->display = money_format("%.2n", $displayAmount);
                    break;
                case 'quarter':
                    $this->currentAmount += $qty * 25;
                    $displayAmount = $this->currentAmount / 100;
                    $this->display = money_format("%.2n", $displayAmount);
                    break;
                case 'penny':
                    $this->coinReturnContents = [$qty => $type];
                    break;
            }
        }
    }

    public function selectProduct($product)
    {
        if ($this->currentAmount == 0) {
            $displayAmount = $this->products[$product]['price'] / 100;
            $this->display = "PRICE " . money_format("%.2n", $displayAmount);
        }

        if ($this->currentAmount >= $this->products[$product]['price']) {
            $this->display = 'THANK YOU';
            $this->productDispensed = true;
            foreach ($this->coins as $type => $qty) {
                $this->bank[$type] += $qty;
            }
        }

    }

    public function makeChange()
    {
        // As a vendor
        // I want customers to receive correct change
        // So that they will use the vending machine again

    }

    public function returnCoins(array $coins)
    {
        $this->coinReturnContents = $coins;
    }

    public function exactChangeOnly()
    {
        // As a customer
        // I want to ve told when exact change is required
        // So that I can determine if I can buy something with the money
        // I have before inserting it...

    }
}