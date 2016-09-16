/*jslint browser: true*/
/*global  $*/

$(function () {
  'use strict';
  
  var randomMatrix = function (cols, rows, minEntryVal, maxEntryVal) {
    var matrix = [],
      row,
      col;
    for (row = 1; row <= rows; row += 1) {
      matrix[row] = [];
      for (col = 1; col <= cols; col += 1) {
        matrix[row][col] = Math.floor(Math.random() * (maxEntryVal - minEntryVal)) + minEntryVal;
      }
    }
    return matrix;
  };

  $('button').click(function () {
    var rows, cols, matrix, row, col;
    $('table').empty();

    rows = Math.floor(Math.random() * 4) + 1;
    cols = Math.floor(Math.random() * 7) + 2;
    matrix = randomMatrix(cols, rows, -12, 12);

    for (row = 1; row <= rows; row += 1) {
      $('table').append($('<tr>'));
      for (col = 1; col <= cols; col += 1) {
        $('tr:last-child').append($('<td>', {
          'text': matrix[row][col]
        }));
      }
    }
  });
});