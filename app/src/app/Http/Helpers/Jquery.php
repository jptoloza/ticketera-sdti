<?php

namespace App\Http\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Session;

class Jquery
{

  /**
   * 
   */
  public static function ajaxPost($form, $page)
  {
    $code = <<<EOD
<script type="text/javascript">
  $().ready(function(){
    $('#$form').submit(function(e){
      e.preventDefault();
      var response;
      var msg;
      var url;
      $.ajax({
        type    : 'POST',
        url     : $(this).attr('action'),
        data    : $(this).serialize(),
        timeout : 1200000,
        beforeSend: function(){
            start();
        },
        error   : function(response){   
          console.log(response); 
          const message = response.responseJSON.message || response.statusText;
          $('#error-flash-message').html(message);
          $('#error-flash').show('slow');
        },
        success : function(response){
          console.log(response); 
          var response = response;
          try{
            if (response.success=='ok'){
                url = `$page`;
              if (response.url){
                url = response.url
              }
              window.location.href = url;
            } else {
              throw new Error();
            }
          } catch(e){                    
          }
        },
        complete: function(){
          stop();
        }
      });
      return false;
    });
  });
</script>
EOD;

    return $code;
    #preg_replace("/\n|\ \ /","",$code) . "\n";
  }


  /**
   * 
   */
  public static function ajaxPostEditor($form, $page, $editor)
  {
    $code = <<<EOD
<script type="text/javascript">
  $().ready(function(){
    $('#$form').submit(function(e){
      e.preventDefault();
      const editorData = quill.root.innerHTML;
      $('#$editor').val(editorData);
      var response;
      var msg;
      var url;
      $.ajax({
        type    : 'POST',
        url     : $(this).attr('action'),
        data    : $(this).serialize(),
        timeout : 1200000,
        beforeSend: function(){
            start();
        },
        error   : function(response){   
          console.log(response); 
          const message = response.responseJSON.message || response.statusText;
          $('#error-flash-message').html(message);
          $('#error-flash').show('slow');
        },
        success : function(response){
          console.log(response); 
          var response = response;
          try{
            if (response.success=='ok'){
                url = `$page`;
              if (response.url){
                url = response.url
              }
              window.location.href = url;
            } else {
              throw new Error();
            }
          } catch(e){                    
          }
        },
        complete: function(){
          stop();
        }
      });
      return false;
    });
  });
</script>
EOD;

    return $code;
    #preg_replace("/\n|\ \ /","",$code) . "\n";
  }

  /**
   * 
   */
  public static function ajaxGet($url, $page)
  {
    $code = <<<EOD
<script type="text/javascript">
	function ajaxGet($url){
		var response;
		var msg;
		$.ajax({
			type	: 'GET',
			url		: $url,
			timeout : 1200000,
			beforeSend: function(){
        start();
      },
      error   : function(response){
        console.log(response);
        const message = response.responseJSON.message || response.statusText;
        if ( document.getElementById("message") !== null) {
          $('#message').modal('hide');
          $('#message').remove();
        }
        var modal =  `<div id="messageError" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="uc-message error siga-message">
        <a href="#" class="uc-message_close-button" data-bs-dismiss="modal"><i class="uc-icon">close</i></a>
        <div class="uc-message_body">
          <h2 class="mb-24">
            <i class="uc-icon warning-icon">error</i> Error
          </h2>
          <p class="no-margin">
            \${message}
          </p>
        </div>
      </div>
      <div class="modal-footer modal-footer-confirm">
        <button type="button" class="uc-btn btn-cta btn-cancel" data-bs-dismiss="modal">Continuar</button>
      </div>
    </div>
  </div>
</div>`;
        $('body').append(modal);
        $('#messageError').modal('show');
        $('#messageError').on('hidden.bs.modal', function (event) {
          $('#messageError').remove();          
        })
        
      },
			success	: function(response){
        console.log(response);
        var response = response;
        try{
          if (response.success=='ok'){
            url = '$page';
            if (response.url){
              url = response.url
            }
            window.location.href = url;
          } else {
            throw new Error();
          }
        } catch(e){         
        }
			},
			complete: function(){
				stop();
			}
        });
	}
</script>
EOD;
    return $code . "\n";
  }


  /**
   * 
   * 
   */
  public static function ajaxValidate($form)
  {
    $code = <<<EOD
  <script type="text/javascript">
    $().ready(function(){
      $('#$form').submit(function(e){
        e.preventDefault();
        var response;
        $.ajax({
          type    : 'POST',
          url     : $(this).attr('action'),
          data    : $(this).serialize(),
          timeout : 1200000,
          beforeSend: function(){
              start();
          },
          error   : function(xhr, status, error){   
            console.log(xhr); 
            $('#error-flash-message').html(xhr.responseJSON.message || xhr.statusText);
            $('#error-flash').show('slow');
            $('#ok-flash').hide(); // Ocultar ok-flash en caso de error
          },
          success : function(response){ 
            try{
              if (response.success == 'ok'){
                console.log(response.url)
                // Actualizar valores de los inputs con los datos recibidos
                $('#ok-flash input[name="folio"]').val(response.data.invoice);
                $('#ok-flash input[name="tipo"]').val(response.data.type_card);
                $('#ok-flash input[name="estado"]').val(response.status.status_card);
                $('#ok-flash input[name="run"]').val(response.studentData.run);
                $('#ok-flash input[name="nombre"]').val(response.studentData.social_name);
                $('#ok-flash input[name="date"]').val(response.data.updated_at);
                $('#ok-flash a[id="pdfDownload"]').attr('href', response.url);
                $('#ok-flash-message').html(response.message || 'Success');
                $('#ok-flash').show('slow');
                $('#error-flash').hide(); // Ocultar error-flash en caso de éxito
              } else {
                throw new Error(response.message || 'Error');
              }
            } catch(e){                    
              $('#error-flash-message').html(e.message);
              $('#error-flash').show('slow');
              $('#ok-flash').hide(); // Ocultar ok-flash en caso de error
            }
          },
          complete: function(){
            stop();
          }
        });
        return false;
      });
    });
  </script>
  EOD;

    return $code;
  }
}
