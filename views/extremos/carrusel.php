<!DOCTYPE html>
<html>
    <title>W3.CSS</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0">
    <link rel="stylesheet" href="estilos/carrusel.css">
    <style>
        .mySlides {display:none}
    </style>
    <body>
    <center>
        <div class="carrusel">
            <div class="Superior" style="display: flex;padding-left: 15%;" >
                <button class="NP" onclick="plusDivs(-1)"><</button>
                <img class="mySlides" src="estilos/Promociones/promoAudifonos.png" >
                <img class="mySlides" src="estilos/Promociones/smartPromo.jpg" >
                <img class="mySlides" src="estilos/Promociones/MicroPromo.jpg">
                <button class="NP" onclick="plusDivs(1)">></button>
            </div>
            <br>
            <div class="Inferior" >
                <button class="buttonM" onclick="currentDiv(1)"></button> 
                <button class="buttonM" onclick="currentDiv(2)"></button> 
                <button class="buttonM" onclick="currentDiv(3)"></button> 
            </div>
        </div>
    </center>
    <script>
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
            showDivs(slideIndex += n);
        }

        function currentDiv(n) {
            showDivs(slideIndex = n);
        }

        function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            if (n > x.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" w3-red", "");
            }
            x[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " w3-red";
        }
    </script>

</body>
</html>
