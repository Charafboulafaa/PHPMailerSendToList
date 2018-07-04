/*global $, jQuery, alert*/
$(document).ready(function () {
    'use strict';
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#alert").slideUp(500);
    });

});
