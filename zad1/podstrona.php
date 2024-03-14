<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <title>Dynamiczna Tabela</title>
</head>
<body>
    <header>
        <label for="numerInput">Wprowadź wartość (max 255):</label>
        <input type="number" id="numerInput" value="255" min="1" max="255">
        <label for="procent1">Procent 1:</label>
        <input type="number" id="procent1" value="50" min="0" max="100">
        <label for="procent2">Procent 2:</label>
        <input type="number" id="procent2" value="75" min="0" max="100">
        <button onclick="generujKolor()">Generuj Kolor</button>
    </header>

    <div id="tabela-container"></div>

    <script>
        function generujKolor() {
            var numerInput = parseInt(document.getElementById("numerInput").value);
            var procent1 = parseInt(document.getElementById("procent1").value);
            var procent2 = parseInt(document.getElementById("procent2").value);

            var czerwony = numerInput;
            var zielony = Math.round(numerInput * procent1 / 100);
            var niebieski = Math.round(numerInput * procent2 / 100);

            var wygenerowanyKolor = 'rgb(' + czerwony + ', ' + zielony + ', ' + niebieski + ')';

            var komorkiTabeli = document.querySelectorAll("table tr:nth-child(odd) td:nth-child(even), table tr:nth-child(even) td:nth-child(odd)");
            komorkiTabeli.forEach(function (komorka) {
                komorka.style.backgroundColor = wygenerowanyKolor;
            });
        }

        function pobierzDaneTabeli() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var dane = JSON.parse(this.responseText);
                    utworzTabele(dane);
                }
            };
            xhttp.open("GET", "dane.php", true);
            xhttp.send();
        }

        function utworzTabele(dane) {
            var tabelaContainer = document.getElementById("tabela-container");
            tabelaContainer.innerHTML = "";
            var tabela = document.createElement("table");
            var thead = document.createElement("thead");
            var wierszNaglowka = document.createElement("tr");

            Object.keys(dane[0]).forEach(function (key) {
                var th = document.createElement("th");
                th.appendChild(document.createTextNode(key));
                wierszNaglowka.appendChild(th);
            });

            thead.appendChild(wierszNaglowka);
            tabela.appendChild(thead);

            var tbody = document.createElement("tbody");

            dane.forEach(function (daneWiersza) {
                var wiersz = document.createElement("tr");

                Object.keys(daneWiersza).forEach(function (key) {
                    var komorka = document.createElement("td");
                    if (key === 'zdjecia') {
                        var img = document.createElement('img');
                        img.src = 'uploads/' + daneWiersza[key];
                        img.alt = 'Zdjęcie';
                        img.style.maxWidth = '100px';
                        if (wiersz.rowIndex % 2 === 1 && komorka.cellIndex % 2 === 1 || wiersz.rowIndex % 2 === 0 && komorka.cellIndex % 2 === 0) {
                            img.style.backgroundColor = wygenerowanyKolor;
                        }
                        komorka.appendChild(img);
                    } else {
                        komorka.appendChild(document.createTextNode(daneWiersza[key]));
                    }
                    wiersz.appendChild(komorka);
                });

                tbody.appendChild(wiersz);
            });

            tabela.appendChild(tbody);

            tabelaContainer.appendChild(tabela);
        }

        pobierzDaneTabeli();
    </script>
</body>
</html>
