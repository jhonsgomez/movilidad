$('.form-delete').submit(function (e) {
    e.preventDefault();

    Swal.fire({
        title: '¿Está seguro?',
        text: "Está acción no se podrá deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    })
})