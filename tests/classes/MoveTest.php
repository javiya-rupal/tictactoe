<?php
namespace TicTac;

use TicTac\Classes\Move;

class MoveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers :: Move class functionality test
     */
    public function test_makeMove() {
        $moveObj = new Move();
        $result = $moveObj->makeMove([['X','O',''],['X','O','O'],['','','']], 'X');
        $this->assertInternalType("array", $result);
        /*$expected = [[2,1,'X'],[2,0,'X'],[2,2,'X'],[0,2,'X']];
        var_dump($result);
        var_dump($expected);
        print_r(array_diff($expected, $result));
        print_r(array_diff($result, $expected));
        //$this->assertSame(array_diff($expected, $result), array_diff($result, $expected));*/
    }
}