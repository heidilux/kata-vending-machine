<?php

class VendingMachineClassTest extends PHPUnit_Framework_TestCase
{
    protected $machine;

    public function setUp()
    {
        $this->machine = new VendingMachine();
    }

    /***************************************************
     * Test inserting coins of various combinations
     ***************************************************/

    public function testInitialStateOfVendingMachine()
    {
        $this->assertEquals('INSERT COINS', $this->machine->display);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([], $this->machine->coinReturnContents);
    }

    public function testCustomerInsertsOneNickel()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->display);
    }

    public function testCustomerInsertsOneDime()
    {
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->display);
    }

    public function testCustomerInsertsOneQuarter()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(25, $this->machine->currentAmount);
        $this->assertEquals('$0.25', $this->machine->display);
    }

    public function testCustomerInsertsTwoNickels()
    {
        $this->machine->acceptCoins(['nickel' => 2]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->display);
    }

    public function testCustomerInsertsTwoDimes()
    {
        $this->machine->acceptCoins(['dime' => 2]);
        $this->assertEquals(20, $this->machine->currentAmount);
        $this->assertEquals('$0.20', $this->machine->display);
    }

    public function testCustomerInsertsTwoQuarters()
    {
        $this->machine->acceptCoins(['quarter' => 2]);
        $this->assertEquals(50, $this->machine->currentAmount);
        $this->assertEquals('$0.50', $this->machine->display);
    }

    public function testCustomerInsertsOnePenny()
    {
        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([1 => 'penny'], $this->machine->coinReturnContents);
        $this->assertEquals('INSERT COINS', $this->machine->display);
    }

    public function testCustomerInsertsTwoPennies()
    {
        $this->machine->acceptCoins(['penny' => 2]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([2 => 'penny'], $this->machine->coinReturnContents);
        $this->assertEquals('INSERT COINS', $this->machine->display);
    }

    public function testCustomerInsertsOneNickelAndOneDime()
    {
        $this->machine->acceptCoins(['nickel' => 1, 'dime' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->display);
    }

    public function testCustomerInsertsOneNickelAndOneDimeAndOneQuarter()
    {
        $this->machine->acceptCoins(['nickel' => 1, 'dime' => 1, 'quarter' => 1]);
        $this->assertEquals(40, $this->machine->currentAmount);
        $this->assertEquals('$0.40', $this->machine->display);
    }

    public function testCustomerInsertsTwoNickelsTwoDimesAndTwoQuarters()
    {
        $this->machine->acceptCoins(['nickel' => 2, 'dime' => 2, 'quarter' => 2]);
        $this->assertEquals(80, $this->machine->currentAmount);
        $this->assertEquals('$0.80', $this->machine->display);
    }

    public function testCustomerInsertsOneNickelAndOnePenny()
    {
        $this->machine->acceptCoins(['penny' => 1, 'nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals([1 => 'penny'], $this->machine->coinReturnContents);
        $this->assertEquals('$0.05', $this->machine->display);
    }

    public function testCustomerInsertsOneNickelTwoDimesThreeQuartersAndFourPennies()
    {
        $this->machine->acceptCoins([
            'penny'     => 4,
            'nickel'    => 1,
            'dime'      => 2,
            'quarter'   => 3
        ]);
        $this->assertEquals(100, $this->machine->currentAmount);
        $this->assertEquals([4 => 'penny'], $this->machine->coinReturnContents);
        $this->assertEquals('$1.00', $this->machine->display);
    }

    public function testCustomerGetsNickelBackAfterInsertingANickelAndCoinReturnIsPushed()
    {
        $coins = ['nickel' => 1];
        $this->machine->acceptCoins($coins);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->display);

        $this->machine->returnCoins($coins);
        $this->assertEquals($coins, $this->machine->coinReturnContents);
    }

    // this one might be a bit off with the way the coins are returned...
    public function testCustomerGetsAllCoinsBackAfterCoinReturnIsPushed()
    {
        $coins = ['nickel' => 1, 'dime' => 4, 'quarter' => 6];
        $this->machine->acceptCoins($coins);
        $this->assertEquals(195, $this->machine->currentAmount);
        $this->assertEquals('$1.95', $this->machine->display);

        $this->machine->returnCoins($coins);
        $this->assertEquals($coins, $this->machine->coinReturnContents);
    }

    /***************************************************
     * Test various combinations of selecting a product
     ***************************************************/

    public function testCustomerMakesASelectionWithNoMoneyInserted()
    {
        $this->machine->selectProduct('cola');
        $this->assertEquals('PRICE $1.00', $this->machine->display);
        $this->machine->selectProduct('chips');
        $this->assertEquals('PRICE $0.50', $this->machine->display);
        $this->machine->selectProduct('candy');
        $this->assertEquals('PRICE $0.65', $this->machine->display);
    }

    public function testCustomerMakesASelectionWithExactChangeInserted()
    {
        $coins = ['quarter' => 4];
        $this->machine->acceptCoins($coins);
        $this->machine->selectProduct('cola');
        $this->assertEquals([
            'nickel'    => 10,
            'dime'      => 10,
            'quarter'   => 14
        ], $this->machine->bank);
        $this->assertEquals('THANK YOU', $this->machine->display);
        $this->assertTrue($this->machine->productDispensed);
    }
}