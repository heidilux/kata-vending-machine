<?php


class VendingMachine
{
    public $display;
    public $bank = [];
    public $coins = [];
    public $change = [];
    public $products = [];
    public $currentAmount;
    public $validCoins = [];
    public $productDispensed;
    public $invalidCoins = [];
    public $coinReturnContents= [];

    public function __construct()
    {
        $this->change = [];
        $this->currentAmount = 0;
        $this->coinReturnContents = [];
        $this->display = "INSERT COINS";
        $this->productDispensed = false;
        $this->invalidCoins = ['penny'];
        $this->validCoins = ['nickel', 'dime', 'quarter'];
        $this->bank = [
            'nickel'    => 10,
            'dime'      => 10,
            'quarter'   => 10
        ];
        $this->coins = [
            'nickel'    => 0,
            'dime'      => 0,
            'quarter'   => 0
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

    public function resetInitialState()
    {
        $this->__construct();
    }

    public function checkDisplay()
    {
        $this->checkIfWeRequireExactChange();
        return $this->display;
    }

    public function acceptCoin($coin)
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        switch ($coin) {
            case 'nickel':
                $this->coins['nickel'] += 1;
                $this->currentAmount += 5;
                $displayAmount = $this->currentAmount / 100;
                $this->display = money_format("%.2n", $displayAmount);
                break;
            case 'dime':
                $this->coins['dime'] += 1;
                $this->currentAmount += 10;
                $displayAmount = $this->currentAmount / 100;
                $this->display = money_format("%.2n", $displayAmount);
                break;
            case 'quarter':
                $this->coins['quarter'] += 1;
                $this->currentAmount += 25;
                $displayAmount = $this->currentAmount / 100;
                $this->display = money_format("%.2n", $displayAmount);
                break;
            case 'penny':
                $this->coinReturnContents['penny'] += 1;
                break;
        }

    }

    public function selectProduct($product)
    {
        $productPrice = $this->products[$product]['price'];

        // What do we display if no money is inserted?
        if ($this->currentAmount == 0) {
            if ($this->products[$product]['inventory'] == 0) {
                $this->display = "SOLD OUT";
            } else {
                $displayAmount = $this->products[$product]['price'] / 100;
                $this->display = "PRICE " . money_format("%.2n", $displayAmount);
            }
        }

        // Enough money has been inserted for the selected product
        if ($this->currentAmount >= $productPrice) {
            if ($this->products[$product]['inventory'] == 0) {
                $this->display = "SOLD OUT";
            } else {
                $this->display = 'THANK YOU';
                $this->productDispensed = true;
                foreach ($this->coins as $type => $qty) {
                    $this->bank[$type] += $qty;
                }
                $overPayment = $this->currentAmount - $productPrice;
            }
        }

        if ($overPayment > 0) {
            $this->makeChange($overPayment);
        }
    }

    public function makeChange($overPayment)
    {
        while ($overPayment >= 5) {
            if ($overPayment >= 25) {
                $this->change['quarter'] += 1;
                $this->bank['quarter'] -= 1;
                $overPayment -= 25;
            } elseif ($overPayment >= 10) {
                $this->change['dime'] += 1;
                $this->bank['dime'] -= 1;
                $overPayment -= 10;
            } elseif ($overPayment >= 5) {
                $this->change['nickel'] += 1;
                $this->bank['nickel'] -= 1;
                $overPayment -= 5;
            }
        }
        $this->coinReturnContents = $this->change;
    }

    public function returnCoins()
    {
        $this->coinReturnContents = $this->coins;
    }

    public function checkIfWeRequireExactChange()
    {
        if ($this->bank['nickel'] < 2 || $this->bank['dime'] == 0) {
            $this->display = 'EXACT CHANGE ONLY';
        }
    }
}