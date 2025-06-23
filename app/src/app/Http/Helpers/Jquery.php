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
        dataType: 'json',
        timeout : 1200000,
        beforeSend: function(){
            start();
        },
        error   : function(response){   
          console.log(response); 
          let message = "Error desconocido";
          if (response.responseJSON) {
            message = response.responseJSON.message;
          } else if (response.statusText) {
            message = response.statusText;
          }
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
            $('#error-flash-message').html(e);
            $('#error-flash').show('slow');      
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



  /**
   * 
   */
  public static function ajaxPostError($form, $div, $page)
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
          $('#$div-message').html(message);
          $('#$div').show('slow');
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
            $('#$div-message').html(e);
            $('#$div').show('slow');      
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

  /**
   * 
   */
  public static function ajaxPostEditor($form, $input, $page,)
  {
    $code = <<<EOD
<script type="text/javascript">
  $().ready(function(){
    $('#$form').submit(function(e){
      e.preventDefault();
      const delta = quill.getContents();
      let data = '';
      if (delta.ops.length === 1 && delta.ops[0].insert.trim() === '') {
        $('#$input').val('');
      } else {
        $('#$input').val(quill.root.innerHTML);
      }


      
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
           console.log(e);                    
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
      function ajaxGet($url) {
        var response;
        var msg;
        $.ajax({
          type: 'GET',
          url: $url,
          timeout: 1200000,
          beforeSend: function () {
            start();
          },
          error: function (response) {
            const message = response.responseJSON.message || response.statusText;
            if (document.getElementById("message") !== null) {
              $('#message').modal('hide');
              $('#message').remove();
            }
            var modal = `<div id="messageError" class="modal">
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
              </div>
            `;
    
            $('body').append(modal);
            $('#messageError').modal('show');
            $('#messageError').on('hidden.bs.modal', function (event) {
              $('#messageError').remove();          
            });
          },
          success	: function(response){
            var response = response;
            try{
              if (response.success=='ok'){
                url = '$page';
                if (response.url){
                  url = response.url
                }
                window.location.href = url;
              } else {
              throw new Error('Error desconocido.');
              }
            } catch(e){
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
                          \${e}
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
              $('#ok-flash').hide();
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
                  $('#error-flash').hide();
                } else {
                  throw new Error(response.message || 'Error');
                }
              } catch(e){                    
                $('#error-flash-message').html(e.message);
                $('#error-flash').show('slow');
                $('#ok-flash').hide();
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
