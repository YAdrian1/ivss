<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visor de Excel con Edición</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        #excel-container {
            overflow: auto;
            max-height: 80vh;
            border: 1px solid #ddd;
            padding: 10px;
        }
        table {
            border-collapse: collapse;
        }
        td {
            border: 1px solid #888;
            padding: 5px;
            font-size: 12px;
        }
        input[type="text"] {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
        }
    </style>
</head>
<body>
    <input type="file" id="input-excel" accept=".xlsx, .xls"/>
    <button id="export-button" style="display:none;">Exportar Cambios</button>
    <div id="file-name"></div>
    <div id="excel-container"></div>

    <script>
        let workbook, firstSheet;

        document.getElementById('input-excel').addEventListener('change', function(e) {
            const file = e.target.files[0];
            document.getElementById('file-name').textContent = "Archivo seleccionado: " + file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                try {
                    workbook = XLSX.read(data, {type: 'array'});
                    firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                    const htmlTable = XLSX.utils.sheet_to_html(firstSheet, {editable: false});
                    document.getElementById('excel-container').innerHTML = htmlTable;

                    // Hacer las celdas editables
                    const table = document.querySelector('#excel-container table');
                    const rows = table.querySelectorAll('tr');
                    rows.forEach((row, rowIndex) => {
                        const cells = row.querySelectorAll('td');
                        cells.forEach((cell, cellIndex) => {
                            const cellAddress = XLSX.utils.encode_cell({r: rowIndex, c: cellIndex});
                            const cellData = firstSheet[cellAddress];
                            cell.innerHTML = `<input type="text" value="${cellData ? cellData.v : ''}" data-address="${cellAddress}" />`;
                        });
                    });

                    // Mostrar botón de exportación
                    document.getElementById('export-button').style.display = 'block';
                } catch (error) {
                    console.error("Error al procesar el archivo:", error);
                    document.getElementById('excel-container').innerHTML = "Error al procesar el archivo: " + error.message;
                }
            };
            reader.onerror = function(e) {
                console.error("Error al leer el archivo:", e);
                document.getElementById('excel-container').innerHTML = "Error al leer el archivo";
            };
            reader.readAsArrayBuffer(file);
        });

        // Escuchar cambios en los inputs de texto
        document.getElementById('excel-container').addEventListener('input', function(event) {
            if (event.target.tagName === 'INPUT' && event.target.type === 'text') {
                const cellAddress = event.target.getAttribute('data-address');
                const newValue = event.target.value;

                // Actualizar el valor en la hoja de cálculo
                firstSheet[cellAddress].v = newValue; // Actualiza el valor en la hoja
                console.log(`Actualizado ${cellAddress} a "${newValue}"`);
            }
        });

        // Exportar el archivo modificado
        document.getElementById('export-button').addEventListener('click', function() {
            // Crear un nuevo libro de trabajo
            const newWorkbook = XLSX.utils.book_new();
            // Agregar la hoja modificada al nuevo libro
            XLSX.utils.book_append_sheet(newWorkbook, firstSheet, workbook.SheetNames[0]);
            // Generar el archivo Excel
            const wbout = XLSX.write(newWorkbook, {bookType: 'xlsx', type: 'binary'});

           // Convertir a un formato que se pueda descargar

            const blob = new Blob([s2ab(wbout)], {type: 'application/octet-stream'});

            const link = document.createElement('a');

            link.href = URL.createObjectURL(blob);

            link.download = 'archivo_modificado.xlsx'; // Nombre del archivo a descargar

            link.click();

            URL.revokeObjectURL(link.href); // Liberar memoria

        });


        // Función para convertir string a array buffer

        function s2ab(s) {

            const buf = new ArrayBuffer(s.length);

            const view = new Uint8Array(buf);

            for (let i = 0; i < s.length; i++) {

                view[i] = s.charCodeAt(i) & 0xFF;

            }

            return buf;

        }

    </script>

</body>

</html>