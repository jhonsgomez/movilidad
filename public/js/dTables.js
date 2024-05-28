$(document).ready(function () {
    $('#queryTable').DataTable({
        responsive: true,
        autoWidth: false,
        "language": {
            "lengthMenu": "Mostrar " +
                `   <select>
                                    <option value = '5'>5</option>
                                    <option value = '10'>10</option>
                                    <option value = '25'>25</option>
                                    <option value = '50'>50</option>
                                    <option value = '100'>100</option>
                                    <option value = '-1'>All</option>
                                </select>`
                + " registros por página",
            "zeroRecords": "Nada encontrado - disculpe",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar",
            "paginate": {
                'next': 'Siguiente',
                'previous': 'Anterior'
            }
        }
    });
});