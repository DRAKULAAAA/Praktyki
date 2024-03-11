<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <title>Dynamiczna Tabela</title>
</head>
<body>
    <div id="table-container"></div>

    <script>
        function fetchTableData() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    createTable(data);
                }
            };
            xhttp.open("GET", "dane.php", true);
            xhttp.send();
        }

        function createTable(data) {
            var tableContainer = document.getElementById("table-container");
            var table = document.createElement("table");

            var thead = document.createElement("thead");
            var headerRow = document.createElement("tr");

            Object.keys(data[0]).forEach(function(key) {
                var th = document.createElement("th");
                th.appendChild(document.createTextNode(key));
                headerRow.appendChild(th);
            });

            thead.appendChild(headerRow);
            table.appendChild(thead);

            var tbody = document.createElement("tbody");

            data.forEach(function(rowData) {
                var row = document.createElement("tr");

                Object.keys(rowData).forEach(function(key) {
                    var cell = document.createElement("td");
                    if (key === 'zdjecia') {
                        var img = document.createElement('img');
                        img.src = 'uploads/' + rowData[key];
                        img.alt = 'Zdjęcie';
                        img.style.maxWidth = '100px';
                        cell.appendChild(img);
                    } else {
                        cell.appendChild(document.createTextNode(rowData[key]));
                    }
                    row.appendChild(cell);
                });

                tbody.appendChild(row);
            });

            table.appendChild(tbody);

            tableContainer.appendChild(table);
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchTableData();
        });
    </script>
</body>
</html>

