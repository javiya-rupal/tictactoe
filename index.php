<?php 
require_once __DIR__ . '/vendor/autoload.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>Tic-Tac-Toe</title>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <style type="text/css">
  	.wonBox-O {
  		background-color: yellowgreen;
  		color: #fff;
  	}
  	.wonBox-X {
  		background-color: red;
  		color: #fff;
  	}
  	td {
  		width: 33.3%
  	}
  </style>
</head>
<script>
$(document).ready(function() {
	var turn = 0;
	var tic = '';

	$('td').click(function(e) {
		turn = 1;
		if(turn == 1){
			tic = 'O';
		}
		$(this).addClass('clicked-'+tic).off(e);
		makeMove(e.target.id);
	});
	function makeMove(square){
		$("#"+square).html(tic);

		// Check win
		if (checkWin(tic)) {
			setTimeout(function () { alert("You Won!"); }, 200);
			$('td').unbind('click');
			return false;
		}
		else {
			if ($('.clicked-'+tic).length < 5) {
				turn = 2;
				aiTurn(square);		
			}
			else {
				setTimeout(function () { alert("Game Drawn!"); }, 200);
				return false;
			}
		}
	}
	function aiTurn(square)
	{
		turn = 2;
		if(turn == 2){
			tic = 'X';
		}
		//Create an array of current positions
		var currentPositions = $('td').map(function() {
		  return $(this).text();
		});
		var result = chunkArray(currentPositions.toArray(), 3);
		
		$.ajax({
			type: "POST",
			url: "ticAjaxNew.php",
			data: { boardState: result, symbol: tic}
		})
		.done(function(response){
			var obj = jQuery.parseJSON(response);
			
			var boxPosition = (obj[0].toString()+obj[1].toString());
			var symbol = obj[2];

			$("#" + boxPosition).html(symbol);
			$("#" + boxPosition).addClass('clicked-'+symbol).unbind('click');

			if (checkWin(symbol)) {
				setTimeout(function () { alert("You Loss!"); }, 200);
				$('td').unbind('click');
				return false;
			}

		});
	}
	function checkWin(symbol) {
		//Get count of filled element on screen
		var win = false;
		var winningPlaces = Array();
		winningPlaces = [["00","01","02"],["10","11","12"],["20","21","22"],
							 ["00","10","20"], ["01","11","21"],["02","12","22"],
							 ["00","11","22"],["02","11","20"]];
		
		//Get filled places for symbol
		var filledPlaces = $('.clicked-'+symbol).map(function() {
		  return $(this).attr('id');
		});
		
		$.each(winningPlaces, function(key, value) {		
		    var matchedElementLength = $(value).filter(filledPlaces.toArray()).length;
		    if (matchedElementLength == 3) {
		    	win = true;
		    	$.each(value, function(key, val) {
		    		$('#'+val).addClass('wonBox-'+symbol);
		    	});
		    	return false;
		    }
		});
		return win;
	}
	/**
	 * Returns an array with arrays of the given size.
	 *
	 * @param myArray {Array} array to split
	 * @param chunk_size {Integer} Size of every group
	 */
	function chunkArray(myArray, chunk_size){
	    var index = 0;
	    var arrayLength = myArray.length;
	    var tempArray = [];
	    
	    for (index = 0; index < arrayLength; index += chunk_size) {
	        myChunk = myArray.slice(index, index+chunk_size);
	        // Do something if you want with the group
	        tempArray.push(myChunk);
	    }
	    return tempArray;
	}
});
</script>
<body>
	<table border="1" width="300" height="300" id="tictactoe" name="table">
		<tr>
			<td align="center" id="00"></td>
			<td align="center" id="01"></td>
			<td align="center" id="02"></td>
		</tr>
		<tr>
			<td align="center" id="10"></td>
			<td align="center" id="11"></td>
			<td align="center" id="12"></td>
		</tr>
		<tr>
			<td align="center" id="20"></td>
			<td align="center" id="21"></td>
			<td align="center" id="22"></td>
		</tr>		
	</table>
	<div align="center"><a href="">Reset Gameboard</a></div>
</body>
</html>