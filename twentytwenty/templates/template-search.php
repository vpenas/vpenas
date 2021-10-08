<?php
/**
 * Template Name: Search Template
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
	<form id="idSearch" class= "form-aso"  >
		<div class="tab">
			<div id="title-colectivos" class="title-search"> 
				<h4>Colectivos</h4>	
			</div>
			<div id="group-aso" class="btn-group" action="<?php echo get_template_directory_uri().'/getColectivo.php' ?>"> 				
			</div>
		</div>
		<div class="tab">
			<div id="title-servicios" class="title-search"> 
				<h4>Recursos</h4>	
			</div>
			<div  id="group-ser" class="btn-group" action="<?php echo get_template_directory_uri().'/getServicio.php' ?>"> 				
			</div>
			<div style="overflow:auto;">
				<div style="float:right;">
					<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>				
				</div>
			</div>
		</div>
		<div class="tab">
			<div id="title-centros" class="title-search"> 
				<h4>Centros</h4>	
			</div>
			<div  id="group-centro" class="btn-group" action="<?php echo get_template_directory_uri().'/getCentro.php' ?>"> 				
			</div>
			<div style="overflow:auto;">
				<div style="float:right;">
					<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>				
				</div>
			</div>
		</div>
	</form>

		<!-- The Modal -->
	<div id="modal-erase" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
		<h4> ¿Estás seguro de borrar todo el contenido del centro?</h4>
		<div style="overflow:auto;">
				<div style="float:right;">
					<button type="button" id="accept-erase" >Confirmar</button>	
					<button type="button" id="close-erase" onclick="closeModal('modal-erase')">Cancelar</button>					
				</div>
			</div>
		</div>

	</div>

	<div id="modal-edit-content" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
		<form id="idEditCS" class= "form-aso" action="<?php echo get_template_directory_uri().'/editColectivoServicio.php' ?>"  method="POST" >
				<div class="tabEditCS">	
				</div>
				<div style="overflow:auto;">
						<div style="float:right;">
							<button type="button" id="accept-edit" >Editar</button>	
					<button type="button" id="close-erase" onclick="closeModal('modal-edit-content')">Cancelar</button>					
				</div>					
						</div>
				</div>
		</form>
		</div>

	</div>

		<!-- The Modal -->
	<div id="modal-edit" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
			<h4>Edita el contenido</h4>
			<form id="idEdit" class= "form-aso" action="<?php echo get_template_directory_uri().'/editBase.php' ?>"  method="POST" >
				<div class="tabEdit">	
				</div>
				<div style="overflow:auto; padding-top:15px;">
						<div style="float:right;">
							<button type="button" id="accept-edit" onclick="editForm()" >Editar</button>	
							<button type="button" id="close-edit" onclick="closeModal('modal-edit')">Cancelar</button>					
						</div>
				</div>
			</form>
		</div>		
	</div>


	<?php
		
?>

</main><!-- #site-content -->
<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>
<?php
get_footer();
