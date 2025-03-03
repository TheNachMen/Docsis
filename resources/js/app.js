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
    $.ajax({
        url: '/cambiarestado/' + id,
        type: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#cambiarEstadoModal').modal('hide');
            window.location.reload();
        },
        /*
        error: function(error) {
           alert('Error al cambiar el estado del documento');
        }
           */
        error: function(error) {
          $('#cambiarEstadoModal').modal('hide');
          window.location.reload();
       }
    });
});
