/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import './components/Example';
import './components/App';



  $('#cambiarEstadoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    $('#confirmarCambioEstado').data('id', id);
  });

  $('#confirmarCambioEstado').click(function() {
    var id = $(this).data('id');
    // Llamar a la función en el controlador
    $.ajax({
      url: 'http://127.0.0.1:8000/api/documentosEstado/' + id,
      type: 'PATCH',
      data: {
        _token: '{{ csrf_token() }}'
      },
      success: function(response) {
        // Cerrar el modal
        $('#cambiarEstadoModal').modal('hide');
        // Actualizar la tabla o mostrar un mensaje de éxito
        window.location.reload(); // Recargar la página para actualizar la tabla
      },
      error: function(error) {
        // Mostrar un mensaje de error
        alert('Error al cambiar el estado del documento.');
      }
    });
  });
