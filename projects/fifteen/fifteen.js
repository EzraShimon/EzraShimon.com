//Fifteen puzzle JavaScript code
//This file defines the event behavior for the Fifteen puzzle.

"use strict";

// constants
var empty_tile_row = 3;
var empty_tile_col = 3;
var LENGTH_OF_PUZZLE = 4 /*tiles*/;
var LENGTH_OF_TILE = 100 /*pixels*/;

$(function() {
	$("#puzzlearea > div").addClass("puzzlepiece").css("background-image", "url('background.jpg')");
	for (var row = 0; row < LENGTH_OF_PUZZLE; row++) {
		$(".puzzlepiece").slice(row * LENGTH_OF_PUZZLE, (row + 1) * LENGTH_OF_PUZZLE).css("top", row * LENGTH_OF_TILE + "px");
	}
	for (var col = 0; col < LENGTH_OF_PUZZLE; col++) {
		$(".puzzlepiece:nth-child(4n + " + (col + 1) + ")").css("left", col * LENGTH_OF_TILE + "px");
	}
	for (row = 0; row < LENGTH_OF_PUZZLE; row++) {
		for (col = 0; col < LENGTH_OF_PUZZLE; col++) {
			$($(".puzzlepiece")[row * LENGTH_OF_PUZZLE + col]).css("background-position", (-1 * col *LENGTH_OF_TILE) + "px " + (-1 * row * LENGTH_OF_TILE) + "px").attr("id", "tile_" + col + "_" + row);
		}
	}

	//Return the row of the tile.
	var getRow = function(tile) {
		return parseInt(tile.css("top")) / LENGTH_OF_TILE;
	}

	//Return the column of the tile.
	var getCol = function(tile) {
		return parseInt(tile.css("left")) / LENGTH_OF_TILE;
	}

	//Return true if the column is adjacent to the empty square and false if it is not.
	var canMove = function(tile) {
		return (Math.abs(getRow(tile) - empty_tile_row) <= 1 &&
				Math.abs(getCol(tile) - empty_tile_col) <= 1 &&
				Math.abs(getRow(tile) - empty_tile_row) +
				Math.abs(getCol(tile) - empty_tile_col) == 1);
	}

	//Whenever a puzzle piece is clicked, if it is adjacent to the empty square, move it into the empty square.
	$(".puzzlepiece").click(function() {
		if (canMove($(this))) {
			var prev_tile_row = getRow($(this));
			var prev_tile_col = getCol($(this));
			$(this).css({
				"top": empty_tile_row * LENGTH_OF_TILE + "px",
				"left": empty_tile_col * LENGTH_OF_TILE + "px"
			});
			empty_tile_row = prev_tile_row;
			empty_tile_col = prev_tile_col;
		}
	});

	//Shuffle all of the tiles.
	$("#shufflebutton").click(function() {
		var tile;
		for (var i = 0; i < 1000; i++) {
			do {
				tile = $($(".puzzlepiece")[parseInt(Math.random() * 15)]);
			}
			while(!canMove(tile));
			tile.click();
		}
	});
});