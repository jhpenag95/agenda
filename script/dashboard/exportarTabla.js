
function exportTable() {
    // Obtener la tabla por su ID
    var table = document.getElementById("tabla");

    // Crear una cadena para almacenar los datos del CSV
    var csv = [];

    // Iterar sobre las filas de la tabla
    for (var i = 0, row; row = table.rows[i]; i++) {
        var rowData = [];

        // Iterar sobre las celdas de la fila
        for (var j = 0, col; col = row.cells[j]; j++) {
            // Agregar el contenido de la celda a la fila de datos
            rowData.push(col.innerText);
        }

        // Agregar la fila de datos al CSV
        csv.push(rowData.join(","));
    }

    // Crear un enlace temporal para descargar el archivo CSV
    var csvContent = "data:text/csv;charset=utf-8," + encodeURIComponent(csv.join("\n"));
    var link = document.createElement("a");
    link.setAttribute("href", csvContent);
    link.setAttribute("download", "tabla.csv");
    link.click();
}
