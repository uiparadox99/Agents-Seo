var basePath = $("meta[name=basePath]").attr("content");
function zakatcalulation() {
    var e = Number($("#silver").val()) + Number($("#bank").val()) + Number($("#business").val()) + Number($("#debts").val());
    $("#assets").html("$" + e);
    var o = (2.5 * e) / 100;
    $("#zakat").html("$" + o);
}
function downloadJSAtOnload() {
    var e = document.createElement("script");
    (e.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"), document.body.appendChild(e);
}
/*$(document).ready(function () {
    "use strict";
    var e = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            cache: !1,
            url: basePath + "public/ajax/proccessajax.php?key=%QUERY",
            wildcard: "%QUERY",
            filter: function (e) {
                return e;
            },
        },
    });
    e.initialize(),
        $(".select-search").typeahead(null, { limit: 20, order: "asc", hint: !1, highlight: !0, minLength: 2, displayKey: "mosque", source: e.ttAdapter() }),
        $(".select-search").on("typeahead:selected", function (e, o, a) {
            window.location.href = basePath + "mosquelisting?name=" + o.mosque;
        }),
        new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                cache: !1,
                url: basePath + "public/ajax/themeajax.php?theme=%QUERY",
                wildcard: "%QUERY",
                filter: function (e) {
                    return e;
                },
            },
        }).initialize(),
        new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                cache: !1,
                url: basePath + "public/ajax/managementajax.php?management=%QUERY",
                wildcard: "%QUERY",
                filter: function (e) {
                    return e;
                },
            },
        }).initialize(),
        new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                cache: !1,
                url: basePath + "public/ajax/councilajax.php?council=%QUERY",
                wildcard: "%QUERY",
                filter: function (e) {
                    return e;
                },
            },
        }).initialize(),
        $(window).scroll(function () {
            $(this).scrollTop() > 450 ? ($(".hom-top-menu").fadeIn(), $(".cat-menu").hide()) : $(".hom-top-menu").fadeOut();
        });
    }),*/
    window.addEventListener ? window.addEventListener("load", downloadJSAtOnload, !1) : window.attachEvent ? window.attachEvent("onload", downloadJSAtOnload) : (window.onload = downloadJSAtOnload);

    function scrollToBottomSocial(event) {
      $('html, body').animate({
        scrollTop: $("#socialIcons").offset().top
    }, 2000);
  }

  var geocoder;
  var map; 


  function myMap() {
  var postcodeaddedd = document.getElementById("postcode").value;

    if(postcodeaddedd != ''){

        geocoder = new google.maps.Geocoder();
        codeAddress();

        var myOptions = {
            zoom: 12,
        }

    }else{

        var latlng = new google.maps.LatLng(51.5074, 0.1278);
        var myOptions = {
            zoom: 8,
            center: latlng,
        }

    }



    map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
    return;
}

function onblurAddress() {

    geocoder = new google.maps.Geocoder();
    codeAddress('no');
    
    var myOptions = {
        zoom: 12,
    }
    map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
    return;
}


function codeAddress(location = "") {
  var postcodeaddedd = document.getElementById("postcode").value;
    if (location == "no") {
        location = document.getElementById("postcode").value;
    } else {
        if(postcodeaddedd != ''){
            location = postcodeaddedd;
        }else{
            location = "london";
        }
        
    }

    geocoder.geocode({
        'address': location
    },
    function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
            $('#lat').val(results[0].geometry.location.lat());
            $('#lng').val(results[0].geometry.location.lng());
        } else {
            /*alert("Geocode was not successful for the following reason: " + status);*/
        }
    });
    return;
}
