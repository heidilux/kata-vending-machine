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
        $this->assertEquals('INSERT COINS', $this->machine->checkDisplay());
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals([
            'nickel'  => 10,
            'dime'    => 10,
            'quarter' => 10,
        ], $this->machine->bank);
        $this->assertEquals([], $this->machine->coinReturnContents);
    }

    public function testInitialStateIfUnableToMakeChange()
    {
        $this->machine->bank = [
            'nickel'    => 0,
            'dime'      => 0,
            'quarter'   => 0
        ];
        $this->assertEquals('EXACT CHANGE ONLY', $this->machine->checkDisplay());
        $this->machine->bank = [
            'nickel'    => 10,
            'dime'      => 10,
            'quarter'   => 10
        ];
    }

    public function testCustomerInsertsOneNickel()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsOneDime()
    {
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsOneQuarter()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(25, $this->machine->currentAmount);
        $this->assertEquals('$0.25', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsTwoNickels()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsTwoDimes()
    {
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(10, $this->machine->currentAmount);
        $this->assertEquals('$0.10', $this->machine->checkDisplay());
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(20, $this->machine->currentAmount);
        $this->assertEquals('$0.20', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsTwoQuarters()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(25, $this->machine->currentAmount);
        $this->assertEquals('$0.25', $this->machine->checkDisplay());
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(50, $this->machine->currentAmount);
        $this->assertEquals('$0.50', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsOnePenny()
    {
        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals(['penny' => 1], $this->machine->coinReturnContents);
        $this->assertEquals('INSERT COINS', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsTwoPennies()
    {
        $this->machine->acceptCoins(['penny' => 2]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals(['penny' => 2], $this->machine->coinReturnContents);
        $this->assertEquals('INSERT COINS', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsOneNickelAndOneDime()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsOneNickelAndOneDimeAndOneQuarter()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());
        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->checkDisplay());
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(40, $this->machine->currentAmount);
        $this->assertEquals('$0.40', $this->machine->checkDisplay());
    }

    public function testCustomerInsertsOneNickelAndOnePenny()
    {
        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(0, $this->machine->currentAmount);
        $this->assertEquals('INSERT COINS', $this->machine->checkDisplay());
        $this->assertEquals(['penny' => 1], $this->machine->coinReturnContents);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());
    }

    // Okay, here's the mother test...
    public function testCustomerInsertsOneNickelTwoDimesThreeQuartersAndFourPennies()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->checkDisplay());
        $this->assertEquals(['penny' => 1], $this->machine->coinReturnContents);

        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(40, $this->machine->currentAmount);
        $this->assertEquals('$0.40', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(50, $this->machine->currentAmount);
        $this->assertEquals('$0.50', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(75, $this->machine->currentAmount);
        $this->assertEquals('$0.75', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(75, $this->machine->currentAmount);
        $this->assertEquals('$0.75', $this->machine->checkDisplay());
        $this->assertEquals(['penny' => 2], $this->machine->coinReturnContents);

        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(75, $this->machine->currentAmount);
        $this->assertEquals('$0.75', $this->machine->checkDisplay());
        $this->assertEquals(['penny' => 3], $this->machine->coinReturnContents);

        $this->machine->acceptCoins(['penny' => 1]);
        $this->assertEquals(75, $this->machine->currentAmount);
        $this->assertEquals('$0.75', $this->machine->checkDisplay());
        $this->assertEquals(['penny' => 4], $this->machine->coinReturnContents);

        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(100, $this->machine->currentAmount);
        $this->assertEquals('$1.00', $this->machine->checkDisplay());
    }

    public function testCustomerGetsNickelBackAfterInsertingANickelAndCoinReturnIsPushed()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());

        $this->machine->returnCoins();
        $this->assertEquals([
            'nickel'    => 1,
            'dime'      => 0,
            'quarter'   => 0
        ], $this->machine->coinReturnContents);
    }

    // get a whole bunch of coins back...
    public function testCustomerGetsAllCoinsBackAfterCoinReturnIsPushed()
    {
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(5, $this->machine->currentAmount);
        $this->assertEquals('$0.05', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(15, $this->machine->currentAmount);
        $this->assertEquals('$0.15', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['dime' => 1]);
        $this->assertEquals(25, $this->machine->currentAmount);
        $this->assertEquals('$0.25', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(50, $this->machine->currentAmount);
        $this->assertEquals('$0.50', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(75, $this->machine->currentAmount);
        $this->assertEquals('$0.75', $this->machine->checkDisplay());

        $this->machine->acceptCoins(['quarter' => 1]);
        $this->assertEquals(100, $this->machine->currentAmount);
        $this->assertEquals('$1.00', $this->machine->checkDisplay());

        $this->machine->returnCoins();
        $this->assertEquals([
            'nickel'    => 1,
            'dime'      => 2,
            'quarter'   => 3
        ], $this->machine->coinReturnContents);
    }

    /***************************************************
     * Test various combinations of selecting a product
     ***************************************************/

    public function testCustomerMakesASelectionWithNoMoneyInserted()
    {
        $this->machine->selectProduct('cola');
        $this->assertEquals('PRICE $1.00', $this->machine->checkDisplay());
        $this->machine->selectProduct('chips');
        $this->assertEquals('PRICE $0.50', $this->machine->checkDisplay());
        $this->machine->selectProduct('candy');
        $this->assertEquals('PRICE $0.65', $this->machine->checkDisplay());
    }

    public function testNoMoneyInsertedAndSelectedProductIsSoldOut()
    {
        $previousInventory = $this->machine->products['cola']['inventory'];
        $this->machine->products['cola']['inventory'] = 0;
        $this->machine->selectProduct('cola');
        $this->assertEquals('SOLD OUT', $this->machine->checkDisplay());
        $this->machine->products['cola']['inventory'] = $previousInventory;
    }

    public function testExactChangeInsertedAndProductSoldOut()
    {
        $previousInventory = $this->machine->products['cola']['inventory'];
        $this->machine->products['cola']['inventory'] = 0;
        $coins = ['quarter' => 4];
        $this->machine->acceptCoins($coins);
        $this->machine->selectProduct('cola');
        $this->assertEquals('SOLD OUT', $this->machine->checkDisplay());
        $this->machine->products['cola']['inventory'] = $previousInventory;
    }

    public function testCustomerMakesASelectionWithExactChangeInserted()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->selectProduct('cola');
        $this->assertEquals('THANK YOU', $this->machine->checkDisplay());
        $this->assertTrue($this->machine->productDispensed);
        $this->assertEquals([
            'nickel'    => 10,
            'dime'      => 10,
            'quarter'   => 14
        ], $this->machine->bank);
    }

    public function testCustomerMakesASelectionThatRequiresChange()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->selectProduct('candy');
        $this->assertEquals('THANK YOU', $this->machine->checkDisplay());
        $this->assertTrue($this->machine->productDispensed);
        $this->assertEquals(['dime' => 1], $this->machine->coinReturnContents);
        $this->assertEquals([
            'nickel'    => 10,
            'dime'      => 9,
            'quarter'   => 13
        ], $this->machine->bank);
    }

    public function testCustomerMakesASelectionThatRequiresMoreChange()
    {
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['quarter' => 1]);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->machine->acceptCoins(['nickel' => 1]);
        $this->assertEquals(130, $this->machine->currentAmount);
        $this->assertEquals("$1.30", $this->machine->checkDisplay());
        $this->machine->selectProduct('cola');
        $this->assertEquals('THANK YOU', $this->machine->checkDisplay());
        $this->assertTrue($this->machine->productDispensed);
        $this->assertEquals(['nickel' => 1, 'quarter' => 1], $this->machine->coinReturnContents);
        $this->assertEquals([
            'nickel'    => 15,
            'dime'      => 10,
            'quarter'   => 13
        ], $this->machine->bank);
    }
}