/*
    This file encodes the behavior of a site where the user can look up trivia about various "baby
    names."
    Ezra-Shimon (Samuel) Rosenfeld
*/
/*jslint browser: true*/
/*global $*/

$(function () {
    "use strict";
    
    //This helped function removes repeats from arrays.
    function removeDuplicates(array) {
        $.each(array, function (idx, e) {
            if (array.lastIndexOf(e) !== idx) {
                array.splice(idx, 1);
            }
        });
        return array;
    }
    
    //Show an error message at the bottom of the page.
    function err(data) {
        $("#errors").append($("<p>", {"text": data.status + ": " + data.statusText}));
    }
    
    var babyNamesFile = "babynames.php";
    //Populate the list of baby names. 
    $.get(babyNamesFile, {"type": "list"})
        .done(function (data) {
            $("#allnames").removeAttr("disabled");
            $.each(removeDuplicates(data.split("\n")), function (idx, e) {
                $("#allnames").append($("<option>", {"text": e}));
            });
        })
        .fail(function (data) {
            err(data);
        })
        .always(function (data) {
            $("#loadingnames").hide();
        });


    $("#search").click(function () {
        var selectedName = $("#allnames").find(":selected").text(),
            gender = $("[name='gender']:checked").attr("value");
        $("#meaning").empty();
        $("#graph").empty();
        $("#norankdata").hide();
        $("#celebs").empty();
        $(".loading").show();
        $("#loadingnames").hide();
        if (selectedName !== "(choose a name)") {
            //Show the meaning of the chosen name.
            $.get(babyNamesFile, {"type": "meaning", "name": selectedName})
                .done(function (data) {
                    $("#meaning")[0].innerHTML = data;
                    $("#resultsarea").show();
                })
                .fail(function (data) {
                    err(data);
                })
                .always(function () {
                    $("#loadingmeaning").hide();
                });

            //Create a bar graph showing how popular the name has been in the past hundred years.
            $.get(babyNamesFile, {"type": "rank", "name": selectedName, "gender": gender})
                .done(function (data) {
                    $("#graph").append($("<tr>"));
                    $("#graph").append($("<tr>", {"id": "rankingBars"}));
                    $.each($(data).find("rank"), function (idx, e) {
                        $($("#graph tr")[0]).append($("<th>"));
                        $("#graph th:last-child").append($("<div>", {"text": $(e).attr("year")}));
                        $($("#graph tr")[1]).append($("<td>", {"class": "rankingBarCell"}));
                        $("#graph td:last-child").append($("<div>", {
                            "text": $(e).text(),
                            "class": "rankingBarDiv",
                            "height": parseInt((1000 - parseInt($(e).text(), 10)) / 4, 10) % 250
                        }));
                        if (parseInt($(e).text(), 10) <= 10 && parseInt($(e).text(), 10) > 0) {
                            $("#graph td:last-child div").css("color", "red");
                        }
                    });
                })
                .fail(function (data) {
                    if (data.status === 410) {
                        $("#norankdata").show();
                    } else {
                        err(data);
                    }
                })
                .always(function () {
                    $("#loadinggraph").hide();
                });

            //List famours actors with this name.
             $.getJSON(babyNamesFile, {"type": "celebs", "name": selectedName, "gender": gender})
                .done(function (data) {
                    $("#celebs").append("<ul>");
                    $.each(data.actors, function (idx, e) {
                        $("#celebs ul").append($("<li>", {"text": e.firstname + " " + e.lastname/* + " (" + e.filmcount + ")"*/}));
                    });
                })
                .fail(function (data) {
                    err(data);
                })
                .always(function () {
                    $("#loadingcelebs").hide();
                });
        }
    });
});