<?php
/**
 * Template Name: Register Template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
get_header();
?>

<main id="site-content" role="main">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );
		}
	}

	
	?>

	<form id="idForm" class= "form-aso" action="<?php echo get_template_directory_uri().'/dataBase.php' ?>"  method="POST" >

		<div class="tab"> <h4>Paso 1. Información general</h4>
			<label for="centro">Centro:</label><br>
			<input type="text" id="centro" name="centro"><br>
			<label for="descripcion">Descripcion:</label><br>
			<textarea  id="descripcion" name="descripcion" rows="4" maxlength="200"cols="50" placeholder="Describa brevemente el centro"></textarea><br>
			<label for="direccion">Dirección:</label><br>
			<input type="text" id="direccion" name="direccion"><br>
			<label  for="provincia">Provincia:</label><br>
			<input  type="text" id="provincia" formaction="<?php echo get_template_directory_uri().'/searchProvincia.php' ?>" name="provincia" ><br>
			<label for="localidad">Localidad:</label><br>
			<input type="text" id="localidad" formaction="<?php echo get_template_directory_uri().'/searchLocalidad.php' ?>" name="localidad"><br>	
			<label for="codigoPostal">Código Postal:</label><br>
			<input type="number" id="codigoPostal" formaction="<?php echo get_template_directory_uri().'/searchCodigo.php' ?>" name="codigoPostal"><br>
			<label for="paginaWeb">Página web:</label><br>
			<input type="url" id="paginaWeb" name="paginaWeb"><br>
			<label for="email">Email:</label><br>
			<input type="email" id="email" name="email"><br>
		</div>
		<div class="tab"><h4>Paso2. Agregar colectivos</h4>
			<table id="tabla_colectivos">
				<input type="hidden" id="namescolectivo" name="namescolectivo" formaction="<?php echo get_template_directory_uri().'/searchColectivo.php' ?>" ><br>
				<input type="hidden" id="namesservicio" name="namesservicio" formaction="<?php echo get_template_directory_uri().'/searchServicio.php' ?>" ><br>
				<tr id="row1">
					<input type="hidden" id="namesservicio1" name="namesservicio1" ><br>
					<td><input type="text" id="colectivo1"  name="colectivo1" onkeyup="autoColective('#colectivo1')" formaction="<?php echo get_template_directory_uri().'/searchColectivo.php' ?>" placeholder="Añade Colectivos"></td>
					<td><ul id="servicio1-multi-tag" class="tagit">
							<li class="tagit-new">
								<input type="text" id="servicio1"  name="servicio1" onkeyup="autoService('#servicio1')" formaction="<?php echo get_template_directory_uri().'/searchServicio.php' ?>" placeholder="Añade Servicios"></td>									
							</li>
						</ul>
					<td><input type='button' value='DELETE' onclick="delete_row('row1')"></td></tr>
										
				</tr>
			</table>
			<input type="button" onclick="add_row();" value="Añade colectivo">

		</div>
		<div class="tab"><h4>Registro Exitoso</h4>
		</div>
		<div style="overflow:auto;">
			<div style="float:right;">
				<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
				<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
			</div>
		</div>
		<!-- Circles which indicates the steps of the form: -->
		<div style="text-align:center;margin-top:40px;">
			<span class="step"></span>
			<span class="step"></span>			
		</div>
	</form>


	<?php
		
?>
	
<script type="text/javascript">
	var $ = jQuery;
	$(function() {	
		autoComplete();
	});

</script>



</main><!-- #site-content -->
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>
<?php
get_footer();
