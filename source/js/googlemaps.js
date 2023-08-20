
$(document).ready(function () {
    setTimeout(() => {

        console.log("Google Maps - OK");
        var script = document.createElement("script");
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCE5o0AtJCU0I5WeJY1xtbJ_ALt3cle8No&callback=initMap";
        document.body.appendChild(script);
    }, "1000");
});

