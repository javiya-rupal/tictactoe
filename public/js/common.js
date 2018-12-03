$(document).ready(function() {
	var turn = 0;
	var tic = '';
	var api_url = '/tictactoe/api';

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
			url: api_url,
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