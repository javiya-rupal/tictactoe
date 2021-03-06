<?php 
namespace TicTac\Classes;
/**
 * Class Move
 * @package TicTac\Classes\Move
 */
class Move implements MoveInterface {
	protected $boardPosition = [["0", "1", "2"], ["0", "1", "2"],["0", "1", "2"]];

	/* 
	 * Function for makes a move using the $boardState
	 * 
     * @param array $boardState Current board state
 	 * @param string $playerUnit Player unit representation
 	 *
 	 * @return an array containing x and y coordinates for next move, and the unit that now occupies it.
     * Example: [2, 0, 'O'] - upper right corner - O player
	 */
	public function makeMove($boardState, $playerUnit = 'X') 
	{
		for($i=0; $i<count($this->boardPosition); $i++)
		{			
			$boardIndexedPosition[] = array_combine($this->boardPosition[$i], $boardState[$i]);			
		}
	    foreach($boardIndexedPosition as $k => $v)
	    {
	    	foreach($v as $k1 => $v1) {
	    		if(empty($v1))
		        {
		            $arr[] = [$k, $k1, $playerUnit];
		        }
	    	}
	    }
		$randomPosition = array_rand($arr, 1);
		return $arr[$randomPosition];
	}
}