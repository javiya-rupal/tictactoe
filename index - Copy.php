<?php 
require_once __DIR__ . '/vendor/autoload.php';

require('conf.php');
//Reset Game
$sql = mysqli_query($conn, "UPDATE gameboard SET symbol = ''") or die (mysqli_error());
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
		makeMove(e.target.id);
		$(this).addClass('clicked-'+tic).off(e);
	});
	function makeMove(square){
		$.ajax({
			type: "POST",
			url: "ticAjax.php",
			data: { clicked: square, symbol: tic, bot: 0 }
		})
		.done(function(response){	
			var square = response;
			$("#"+square).html(tic);

			// Check win
			if (checkWin(tic)) {
				setTimeout(function () { alert("You Won!"); }, 200);
				$('td').unbind('click');
				return false;
			}
			turn = 2;
			aiTurn(square);
		});
	}
	function aiTurn(square)
	{
		turn = 2;
		if(turn == 2){
			tic = 'X';
		}
		$.ajax({
			type: "POST",
			url: "ticAjax.php",
			data: { clicked: square, symbol: tic, bot: 1 }
		})
		.done(function(response){		
			$("#" + response).html(tic);
			$("#" + response).addClass('clicked-'+tic).unbind('click');

			if (checkWin(tic)) {
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
		winningPlaces = [[1,2,3],[4,5,6],[7,8,9],
							 [1,4,7], [2,5,8],[3,6,9],
							 [1,5,9],[3,5,7]];
		
		//Get filled places for symbol
		var filledPlaces = $('.clicked-'+symbol).map(function() {
		  return parseInt($(this).attr('id'));
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
});
</script>
<body>
	<table border="1" width="300" height="300" id="tictactoe" name="table">
		<tr>
			<td align="center" id='1'></td>
			<td align="center" id='2'></td>
			<td align="center" id='3'></td>
		</tr>
		<tr>
			<td align="center" id='4'></td>
			<td align="center" id='5'></td>
			<td align="center" id='6'></td>
		</tr>
		<tr>
			<td align="center" id='7'></td>
			<td align="center" id='8'></td>
			<td align="center" id='9'></td>
		</tr>
		<tr><td colspan="3" align="center"><a href="">Reset Gameboard</a></td></tr>
	</table>
</body>
</html>