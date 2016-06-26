/*
    This script causes the headers in the header bar to take on the function of links and cause this website to mimic the behavior of having four main pages.
    Ezra-Shimon (Samuel) Rosenfeld
*/
/*jslint browser: true*/
/*global $*/

$(function () {
    "use strict";
    
    $("#banner h1").click(function () {
        $(".selected").removeClass("selected");
        $(this).addClass("selected");
        
        $(".show").removeClass("show");
        $("#banner").addClass("show");
        
        switch ($(this)[0].innerHTML) {
        case "about":
            $("#about").addClass("show");
            $("#footer").addClass("show");
            break;
        case "projects":
            $("#projects").addClass("show");
            break;
        case "resume":
            $("#resume").addClass("show");
            break;
        case "contact":
            $("#contact").addClass("show");
            $("#footer").addClass("show");
            break;
        }
    });
    
    $("#banner h1:first-child").click();
    
    $("a").attr("target", "_blank");
});