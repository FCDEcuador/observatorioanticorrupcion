<a class='flotante' href='#' data-toggle="modal" data-target="#modalDenuncias" ><img src='{!! asset('public/frontend/images/denuncia.png') !!}' border="0"/>
</a>

<!-- BEGIN MODAL DENUNCIAS -->
<div class="modal fade" id="modalDenuncias" tabindex="-1" role="dialog" aria-labelledby="modalDenunciasTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background:rgba(47,60,90,0.8);">
        <h5 class="modal-title text-white text-uppercase" id="modalDenunciasTitle"><i class="fas fa-exclamation-triangle mr-3 fz50 text-warning"></i>Instituciones donde se puede denunciar casos de corrupción</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-light">
        <div class="container p-0">
        	<div class="row no-gutters">
        		<div class="col-6 col-sm-2">
        			<p class="text-center mb-0 fz40 text-info"><i class="fas fa-university"></i></p>
        			<p class="text-default text-uppercase letter-spacing-1 text-center font-weight-bold mt-2 fz14 mb-0 align-middle" style="height:40px;">Institución</p>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-4">
        					<img src="{!! asset('public/frontend/images/logo-contraloria.png') !!}" class="w-100" />
        				</div>
        				<div class="col-8 text-uppercase letter-spacing-1 fz12 pl-1 font-weight-bold">
        					CONTRALORÍA GENERAL DEL ESTADO
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-4">
        					<img src="{!! asset('public/frontend/images/logo-cpcc.png') !!}" class="w-100" />
        				</div>
        				<div class="col-8 text-uppercase letter-spacing-1 fz12 pl-1 font-weight-bold">
        					CONCEJO DE PARTICIPACIÓN CIUDADANA Y CONTROL SOCIAL (CPCSS)
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-4">
        					<img src="{!! asset('public/frontend/images/ico-fiscalia.png') !!}" class="w-100" />
        				</div>
        				<div class="col-8 text-uppercase letter-spacing-1 fz12 pl-1 font-weight-bold">
        					FISCALIA GENERAL DEL ESTADO
        				</div>
        			</div>
        		</div>
        		<div class="col-6 col-sm-2">
        			<p class="text-center mb-0 fz40 text-info"><i class="fas fa-map-marker-alt"></i></p>
        			<p class="text-default text-uppercase letter-spacing-1 text-center font-weight-bold mt-2 fz14 mb-0 align-middle" style="height:40px;">Dirección</p>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 letter-spacing-1 fz12 text-center">
        					Quito:<br />
        					Av. 6 de Diciembre,<br />
        					Quito 170136
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 letter-spacing-1 fz12 text-center">
        					Quito:<br />
        					José Tamayo E10 25<br />
        					y Lizardo García
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 letter-spacing-1 fz12 text-center">
        					Quito:<br />
        					Av. Patria y 12 de Octubre<br />
        					Edificio Patria
        				</div>
        			</div>
        		</div>
        		<div class="col-6 col-sm-2">
        			<p class="text-center mb-0 fz40 text-info"><i class="fas fa-phone"></i></p>
        			<p class="text-default text-uppercase letter-spacing-1 text-center font-weight-bold mt-2 fz14 mb-0 align-middle" style="height:40px;">Teléfonos</p>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 text-uppercase letter-spacing-1 fz12 text-center">
        					3 987-100<br />
        					3 987-200<br />
        					3 987-300
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 text-uppercase letter-spacing-1 fz12 text-center">
        					2 3957-210
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 text-uppercase letter-spacing-1 fz12 text-center">
        					2 3985-800
        				</div>
        			</div>
        		</div>
        		<div class="col-6 col-sm-2">
        			<p class="text-center mb-0 fz40 text-info"><i class="fas fa-globe"></i></p>
        			<p class="text-default text-uppercase letter-spacing-1 text-center font-weight-bold mt-2 fz14 mb-0 align-middle" style="height:40px;">Web</p>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 text-uppercase letter-spacing-1 fz12 text-center">
        					<a href="https://servicios.contraloria.gob.ec:4443/CGE_Denuncias_WEB/WFDenuncia.aspx" target="_blank" role="button" class="btn btn-info btn-sm text-uppercase">Ir a la web</a>
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 text-uppercase letter-spacing-1 fz12 text-center">
        					<a href="http://190.152.149.90/sysWORKFLOW/es/neoclassic/66470336956af72990370a7019950626/Formulario_Denuncias.php" target="_blank" role="button" class="btn btn-info btn-sm text-uppercase">Ir a la web</a>
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 text-uppercase letter-spacing-1 fz12 text-center">
        					<a href="https://www.fiscalia.gob.ec/contacto-ciudadano/" target="_blank" role="button" class="btn btn-info btn-sm text-uppercase">Ir a la web</a>
        				</div>
        			</div>
        		</div>
        		<div class="col-6 col-sm-2">
        			<p class="text-center mb-0 fz40 text-info"><i class="far fa-envelope"></i></p>
        			<p class="text-default text-uppercase letter-spacing-1 text-center font-weight-bold mt-2 fz14 mb-0 align-middle" style="height:40px;">Correos de contacto</p>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12  letter-spacing-1 fz12 text-center">
        					DESPACHO CONTRALOR:<br />
        					<a class="text-default" href="#"  data-toggle="modal" data-target="#emailDenuncia" data-whatever="Contraloría General del Estado" data-receptor = "contralor@contraloria.gob.ec">contralor@contraloria.gob.ec</a>
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12  letter-spacing-1 fz12 text-center">
        					CPCCS<br />
        					<a class="text-default" href="#"  data-toggle="modal" data-target="#emailDenuncia" data-whatever="Concejo de Participación Ciudadana y Control Social" data-receptor = "denuncia@cpccs.gob.ec">denuncia@cpccs.gob.ec</a>
                            <br />
                            <a class="text-default" href="#"  data-toggle="modal" data-target="#emailDenuncia" data-whatever="Concejo de Participación Ciudadana y Control Social" data-receptor = "comunicacion@cpccs.gob.ec">comunicacion@cpccs.gob.ec</a>
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12  letter-spacing-1 fz12 text-center">
        					FISCAL<br />
        					<a class="text-default" href="#"  data-toggle="modal" data-target="#emailDenuncia" data-whatever="Fiscalia General del Estado" data-receptor = "salazarmd@fiscalia.gob.ec">salazarmd@fiscalia.gob.ec</a>
        				</div>
        			</div>
        		</div>
        		<div class="col-6 col-sm-2">
        			<p class="text-center mb-0 fz40 text-info"><i class="fas fa-share-alt"></i></p>
        			<p class="text-default text-uppercase letter-spacing-1 text-center font-weight-bold mt-2 fz14 mb-0 align-middle" style="height:40px;">Redes Sociales</p>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 letter-spacing-1 fz12">
        					
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 letter-spacing-1 fz12">
        					<a href="#" class="text-body"><i class="fab fa-twitter text-info"></i> @CPCCS</a><br />
        					<a href="#"  onclick="javascript:window.open('https://twitter.com/intent/tweet?text=Saludos%20@CPCCS%20Me%20contacto%20con%20ustedes%20por%20el%20siguiente%20motivo%20vinculado%20a%20un%20caso%20de%20corrupci%C3%B3n.%20FCD_Ecuador%20webdelobservatorio.ec','popup',width=500,height=500);return false;" class="text-body"><i class="fab fa-twitter text-info"></i> Mandale un tweet</a><br />
        					<a href="#" class="text-body"><i class="fab fa-facebook-f text-default"></i> ParticipaEcuador</a>
							
        				</div>
        			</div>
        			<div class="row no-gutters bg-white border p-1 mb-1 minh80 align-items-center">
        				<div class="col-12 letter-spacing-1 fz12">
        					<a href="#" class="text-body"><i class="fab fa-twitter text-info"></i> @FiscaliaEcuador<br /></a>
        					<a href="#"  onclick="javascript:window.open('https://twitter.com/intent/tweet?text=Saludos%20@FiscaliaEcuador%20Me%20contacto%20con%20ustedes%20por%20el%20siguiente%20motivo%20vinculado%20a%20un%20caso%20de%20corrupci%C3%B3n.%20FCD_Ecuador%20webdelobservatorio.ec','popup',width=500,height=500);return false;" class="text-body"><i class="fab fa-twitter text-info"></i> Mandale un tweet</a><br />
        					<a href="#" class="text-body"><i class="fab fa-facebook-f text-default"></i> FiscaliaGeneralDelEstado</a>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END MODAL DENUNCIAS -->

<!-- BEGIN MODAL PARA ENVIO DE EMAILS DE DENUNCIAS -->
<div class="modal fade" id="emailDenuncia" tabindex="-1" role="dialog" aria-labelledby="emailDenunciaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="emailDenunciaLabel">Nueva denuncia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="container">
          <div class="form-group row">
            <label for="recipient-name" class="col-form-label col-sm-3">Nombre:</label>
            <input type="text" class="form-control col-sm-8" id="recipient-name" required>
          </div>
          <div class="form-group row">
            <label for="recipient-name" class="col-form-label col-sm-3">Email:</label>
            <input type="text" class="form-control col-sm-8" id="email" name="email" required>
          </div>
          <div class="form-group row">
            <label for="recipient-name" class="col-form-label col-sm-3">Teléfono:</label>
            <input type="text" class="form-control col-sm-8" id="telefono" name="telefono" required>
            <input type="hidden"  id="receptor" name="receptor">
          </div>
          <div class="form-group row mb-0">
            <label for="message-text" class="col-form-label col-sm-3">Denuncia:</label>
            <textarea class="form-control col-sm-8" id="denuncia" name="denuncia" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-info btn-sm">Enviar</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL PARA ENVIO DE EMAILS DE DENUNCIAS -->


<!-- BEGIN FOOOTER -->
<div class="container-fluid mt-4">
	<div class="row bg-secondary text-white p-3">
		<div class="col-sm-4 align-self-center d-flex justify-content-center mt-4 mt-sm-0">
			<!--a href="" class="text-white border pt-1 pb-1 pl-3 pr-3" style="background: rgba(255,255,255,0.4);border-radius: 5px;"><span class="pr-3">Suscríbete a nuestro newsletter</span> <i class="far fa-envelope"></i> </a-->
            <div> Con el apoyo de: <a href="" target="_blank">
                        <img src="{!! asset('public/images/padf-white.png') !!}" />
            </a></div>
		</div>
		<div class="col-sm-4 align-self-center d-flex justify-content-center mt-4 mt-sm-0">
			@if($oConfiguration->facebook_account != '')
				<a href="{!! $oConfiguration->facebook_account !!}" class="text-white fz24 border redes-ico mr-3" target="_blank" rel="noopener noreferrer">
					<span class="">
						<i class="fab fa-facebook-f"></i>
					</span>
				</a>
			@endif
			@if($oConfiguration->twitter_account != '')
				<a href="{!! $oConfiguration->twitter_account !!}" class="text-white fz24 border redes-ico mr-3" target="_blank" rel="noopener noreferrer">
					<span class="">
						<i class="fab fa-twitter"></i>
					</span>
				</a>
			@endif
			@if($oConfiguration->instagram_account != '')
				<a href="{!! $oConfiguration->instagram_account !!}" class="text-white fz24 border redes-ico" target="_blank" rel="noopener noreferrer">
					<span class="">
						<i class="fab fa-instagram"></i>
					</span>
				</a>
			@endif
		</div>

		<div class="col-sm-4 align-self-center d-flex justify-content-center mt-4 mt-sm-0">
			<div> Una iniciativa de: <a href="" target="_blank">
                    @if($oConfiguration->backend_logo != '')
                        <img src="{!! asset($oStorage->url($oConfiguration->backend_logo)) !!}" />
                    @else
                        <img src="{!! asset('public/frontend/images/fcd.png') !!}" class="pl-3" />
                    @endif
                

            </a></div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<p class="text-secondary mt-3">Bajo la licencia de:</p>
			<p><a class="text-secondary fz40" href="https://creativecommons.org/licenses/by-nc-sa/3.0/ec/" target="_blank" rel="noopener noreferrer"><i class="fab fa-creative-commons"></i></a> <a class="text-secondary fz40" href="" target="_blank"><i class="fab fa-github"></i></a></p>
		</div>
	</div>
</div>
<!-- END FOOTER -->