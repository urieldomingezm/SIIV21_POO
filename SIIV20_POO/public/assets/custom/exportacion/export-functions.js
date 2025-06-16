// Funciones de exportación para tablas
class ExportManager {
    constructor(tableId, fileName = 'datos') {
        this.tableId = tableId;
        this.fileName = fileName;
        this.table = document.getElementById(tableId);
    }

    // Exportar a Excel
    exportToExcel() {
        try {
            if (!this.table) {
                throw new Error('Tabla no encontrada');
            }

            // Crear un nuevo workbook
            const wb = XLSX.utils.book_new();
            
            // Obtener datos de la tabla
            const tableData = this.getTableData();
            
            // Crear worksheet con datos
            const ws = XLSX.utils.aoa_to_sheet([
                // Título principal
                ['GESTIÓN DE PAGOS Y DESCUENTOS'],
                [], // Fila vacía
                [`Fecha de exportación: ${new Date().toLocaleDateString('es-ES')}`],
                [`Hora: ${new Date().toLocaleTimeString('es-ES')}`],
                [], // Fila vacía
                // Headers
                tableData.headers,
                // Datos
                ...tableData.rows
            ]);
            
            // Configurar estilos y formato
            const range = XLSX.utils.decode_range(ws['!ref']);
            
            // Configurar ancho de columnas
            const colWidths = [];
            for (let i = 0; i <= range.e.c; i++) {
                colWidths.push({ wch: 15 }); // Ancho de 15 caracteres
            }
            ws['!cols'] = colWidths;
            
            // Estilo para el título principal (A1)
            if (ws['A1']) {
                ws['A1'].s = {
                    font: { bold: true, sz: 16, color: { rgb: "FFFFFF" } },
                    fill: { fgColor: { rgb: "0D6EFD" } },
                    alignment: { horizontal: "center", vertical: "center" }
                };
            }
            
            // Estilo para fecha y hora
            if (ws['A3']) {
                ws['A3'].s = {
                    font: { italic: true, sz: 10 },
                    fill: { fgColor: { rgb: "F8F9FA" } }
                };
            }
            if (ws['A4']) {
                ws['A4'].s = {
                    font: { italic: true, sz: 10 },
                    fill: { fgColor: { rgb: "F8F9FA" } }
                };
            }
            
            // Estilo para headers (fila 6)
            for (let col = 0; col < tableData.headers.length; col++) {
                const cellRef = XLSX.utils.encode_cell({ r: 5, c: col });
                if (ws[cellRef]) {
                    ws[cellRef].s = {
                        font: { bold: true, color: { rgb: "FFFFFF" } },
                        fill: { fgColor: { rgb: "0D6EFD" } },
                        alignment: { horizontal: "center", vertical: "center" },
                        border: {
                            top: { style: "thin", color: { rgb: "000000" } },
                            bottom: { style: "thin", color: { rgb: "000000" } },
                            left: { style: "thin", color: { rgb: "000000" } },
                            right: { style: "thin", color: { rgb: "000000" } }
                        }
                    };
                }
            }
            
            // Estilo para datos (filas alternas)
            for (let row = 6; row < 6 + tableData.rows.length; row++) {
                for (let col = 0; col < tableData.headers.length; col++) {
                    const cellRef = XLSX.utils.encode_cell({ r: row, c: col });
                    if (ws[cellRef]) {
                        const isEvenRow = (row - 6) % 2 === 0;
                        ws[cellRef].s = {
                            fill: { fgColor: { rgb: isEvenRow ? "FFFFFF" : "F8F9FA" } },
                            border: {
                                top: { style: "thin", color: { rgb: "DEE2E6" } },
                                bottom: { style: "thin", color: { rgb: "DEE2E6" } },
                                left: { style: "thin", color: { rgb: "DEE2E6" } },
                                right: { style: "thin", color: { rgb: "DEE2E6" } }
                            },
                            alignment: { vertical: "center" }
                        };
                    }
                }
            }
            
            // Combinar celdas para el título
            ws['!merges'] = [
                { s: { r: 0, c: 0 }, e: { r: 0, c: tableData.headers.length - 1 } }
            ];
            
            // Agregar la worksheet al workbook
            XLSX.utils.book_append_sheet(wb, ws, 'Gestión de Pagos');
            
            // Generar el archivo y descargarlo
            XLSX.writeFile(wb, `${this.fileName}_${new Date().toISOString().split('T')[0]}.xlsx`);
            
            this.showSuccessMessage('Archivo Excel descargado exitosamente');
        } catch (error) {
            console.error('Error al exportar a Excel:', error);
            this.showErrorMessage('Error al exportar a Excel: ' + error.message);
        }
    }

    // Exportar a PDF
    exportToPDF() {
        try {
            if (!this.table) {
                throw new Error('Tabla no encontrada');
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4'); // Orientación horizontal
            
            // Configurar colores y estilos
            const primaryColor = [13, 110, 253]; // Azul Bootstrap
            const lightGray = [248, 249, 250];
            const darkGray = [108, 117, 125];
            
            // Header con logo/título
            doc.setFillColor(...primaryColor);
            doc.rect(0, 0, 297, 25, 'F');
            
            // Título principal
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(20);
            doc.setFont('helvetica', 'bold');
            doc.text('GESTIÓN DE PAGOS Y DESCUENTOS', 148.5, 15, { align: 'center' });
            
            // Información de exportación
            doc.setTextColor(0, 0, 0);
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text(`Fecha de exportación: ${new Date().toLocaleDateString('es-ES')}`, 20, 35);
            doc.text(`Hora: ${new Date().toLocaleTimeString('es-ES')}`, 20, 42);
            doc.text(`Total de registros: ${this.table.querySelectorAll('tbody tr').length}`, 200, 35);
            
            // Línea separadora
            doc.setDrawColor(...darkGray);
            doc.setLineWidth(0.5);
            doc.line(20, 48, 277, 48);
            
            // Obtener datos de la tabla
            const tableData = this.getTableData();
            
            // Configurar autoTable si está disponible
            if (doc.autoTable) {
                doc.autoTable({
                    head: [tableData.headers],
                    body: tableData.rows,
                    startY: 55,
                    theme: 'grid',
                    styles: {
                        fontSize: 9,
                        cellPadding: 4,
                        textColor: [0, 0, 0],
                        lineColor: [222, 226, 230],
                        lineWidth: 0.1
                    },
                    headStyles: {
                        fillColor: primaryColor,
                        textColor: [255, 255, 255],
                        fontStyle: 'bold',
                        halign: 'center',
                        valign: 'middle'
                    },
                    bodyStyles: {
                        valign: 'middle'
                    },
                    alternateRowStyles: {
                        fillColor: lightGray
                    },
                    columnStyles: {
                        0: { halign: 'center' }, // ID
                        1: { halign: 'left' },   // Nombre
                        2: { halign: 'center' }, // Matrícula
                        3: { halign: 'center' }, // Carrera
                        4: { halign: 'right' },  // Monto
                        5: { halign: 'right' },  // Descuento
                        6: { halign: 'right' },  // Total
                        7: { halign: 'center' }  // Estado
                    },
                    margin: { left: 20, right: 20 },
                    tableWidth: 'auto',
                    didDrawPage: function(data) {
                        // Footer en cada página
                        const pageCount = doc.internal.getNumberOfPages();
                        const pageSize = doc.internal.pageSize;
                        const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                        
                        doc.setFontSize(8);
                        doc.setTextColor(...darkGray);
                        doc.text(
                            `Página ${data.pageNumber} de ${pageCount}`,
                            pageSize.width / 2,
                            pageHeight - 10,
                            { align: 'center' }
                        );
                        
                        doc.text(
                            `Generado el ${new Date().toLocaleString('es-ES')}`,
                            20,
                            pageHeight - 10
                        );
                    }
                });
            } else {
                // Fallback básico sin autoTable
                let yPosition = 60;
                doc.setFontSize(10);
                doc.setFont('helvetica', 'bold');
                
                // Headers
                let xPosition = 20;
                tableData.headers.forEach((header, index) => {
                    doc.setFillColor(...primaryColor);
                    doc.rect(xPosition, yPosition - 5, 35, 8, 'F');
                    doc.setTextColor(255, 255, 255);
                    doc.text(header, xPosition + 2, yPosition);
                    xPosition += 35;
                });
                
                yPosition += 10;
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(0, 0, 0);
                
                // Rows
                tableData.rows.forEach((row, rowIndex) => {
                    xPosition = 20;
                    
                    // Fila alterna
                    if (rowIndex % 2 === 1) {
                        doc.setFillColor(...lightGray);
                        doc.rect(20, yPosition - 5, 35 * tableData.headers.length, 8, 'F');
                    }
                    
                    row.forEach(cell => {
                        doc.text(String(cell).substring(0, 20), xPosition + 2, yPosition);
                        xPosition += 35;
                    });
                    yPosition += 8;
                    
                    if (yPosition > 180) { // Nueva página
                        doc.addPage();
                        yPosition = 20;
                    }
                });
            }
            
            // Descargar el PDF
            doc.save(`${this.fileName}_${new Date().toISOString().split('T')[0]}.pdf`);
            
            this.showSuccessMessage('Archivo PDF descargado exitosamente');
        } catch (error) {
            console.error('Error al exportar a PDF:', error);
            this.showErrorMessage('Error al exportar a PDF: ' + error.message);
        }
    }

    // Imprimir tabla
    printTable() {
        try {
            if (!this.table) {
                throw new Error('Tabla no encontrada');
            }

            // Crear ventana de impresión
            const printWindow = window.open('', '_blank');
            
            // Obtener estilos de Bootstrap
            const bootstrapCSS = document.querySelector('link[href*="bootstrap"]')?.href || '';
            
            // HTML para impresión
            const printHTML = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Gestión de Pagos y Descuentos</title>
                    <link href="${bootstrapCSS}" rel="stylesheet">
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            margin: 20px;
                            color: #000;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 2px solid #0d6efd;
                            padding-bottom: 10px;
                        }
                        .table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        .table th, .table td {
                            border: 1px solid #dee2e6;
                            padding: 8px;
                            text-align: left;
                        }
                        .table th {
                            background-color: #0d6efd;
                            color: white;
                            font-weight: bold;
                        }
                        .table tr:nth-child(even) {
                            background-color: #f8f9fa;
                        }
                        .badge {
                            display: inline-block;
                            padding: 0.25em 0.4em;
                            font-size: 0.75em;
                            font-weight: 700;
                            line-height: 1;
                            text-align: center;
                            white-space: nowrap;
                            vertical-align: baseline;
                            border-radius: 0.25rem;
                        }
                        .bg-success { background-color: #198754 !important; color: white; }
                        .bg-danger { background-color: #dc3545 !important; color: white; }
                        .bg-info { background-color: #0dcaf0 !important; color: black; }
                        .bg-secondary { background-color: #6c757d !important; color: white; }
                        .bg-primary { background-color: #0d6efd !important; color: white; }
                        @media print {
                            .no-print { display: none !important; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Gestión de Pagos y Descuentos</h1>
                        <p>Fecha de impresión: ${new Date().toLocaleDateString('es-ES')}</p>
                    </div>
                    ${this.getTableHTML()}
                </body>
                </html>
            `;
            
            printWindow.document.write(printHTML);
            printWindow.document.close();
            
            // Esperar a que cargue y luego imprimir
            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
            
            this.showSuccessMessage('Ventana de impresión abierta');
        } catch (error) {
            console.error('Error al imprimir:', error);
            this.showErrorMessage('Error al imprimir: ' + error.message);
        }
    }

    // Obtener datos de la tabla
    getTableData() {
        const headers = [];
        const rows = [];
        
        // Obtener headers
        const headerCells = this.table.querySelectorAll('thead th');
        headerCells.forEach(cell => {
            headers.push(cell.textContent.trim());
        });
        
        // Obtener filas de datos
        const bodyRows = this.table.querySelectorAll('tbody tr');
        bodyRows.forEach(row => {
            const rowData = [];
            const cells = row.querySelectorAll('td');
            cells.forEach((cell, index) => {
                // Excluir la columna de acciones (última columna)
                if (index < cells.length - 1) {
                    // Limpiar texto de badges y elementos HTML
                    let text = cell.textContent.trim();
                    rowData.push(text);
                }
            });
            if (rowData.length > 0) {
                rows.push(rowData);
            }
        });
        
        // Remover la columna de acciones de los headers también
        if (headers.length > 0) {
            headers.pop();
        }
        
        return { headers, rows };
    }

    // Obtener HTML de la tabla para impresión
    getTableHTML() {
        const tableClone = this.table.cloneNode(true);
        
        // Remover columna de acciones
        const actionHeaders = tableClone.querySelectorAll('thead th:last-child');
        actionHeaders.forEach(header => header.remove());
        
        const actionCells = tableClone.querySelectorAll('tbody td:last-child');
        actionCells.forEach(cell => cell.remove());
        
        return tableClone.outerHTML;
    }

    // Mostrar mensaje de éxito
    showSuccessMessage(message) {
        this.showToast(message, 'success');
    }

    // Mostrar mensaje de error
    showErrorMessage(message) {
        this.showToast(message, 'error');
    }

    // Mostrar toast notification
    showToast(message, type = 'info') {
        // Crear toast si no existe
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
            `;
            document.body.appendChild(toastContainer);
        }

        const toastId = 'toast-' + Date.now();
        const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        
        toast.show();
        
        // Remover el toast después de que se oculte
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }
}

// Función global para inicializar exportaciones
function initializeExportFunctions(tableId, fileName = 'datos') {
    const exportManager = new ExportManager(tableId, fileName);
    
    // Configurar event listeners
    const btnExcel = document.getElementById('btnExcel');
    const btnPDF = document.getElementById('btnPDF');
    const btnImprimir = document.getElementById('btnImprimir');
    
    if (btnExcel) {
        btnExcel.addEventListener('click', () => exportManager.exportToExcel());
    }
    
    if (btnPDF) {
        btnPDF.addEventListener('click', () => exportManager.exportToPDF());
    }
    
    if (btnImprimir) {
        btnImprimir.addEventListener('click', () => exportManager.printTable());
    }
    
    return exportManager;
}