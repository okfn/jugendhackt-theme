<?php 
/*
Template Name: Page Projekte
*/
get_header(); 

// Get the categories for regions:
$region_parent_obj	= get_term_by('name', 'region', 'page_category');
$region_parent_id 	= $region_parent_obj->term_id;

$args = array(
	'child_of'                 => $region_parent_id,
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 1,
	'hierarchical'             => 1,
	'taxonomy'                 => 'page_category',
); 

$regions = get_categories( $args );


// Get the categories for years:

$year_parent_obj 	= get_term_by('slug', 'year', 'page_category');
$year_parent_id 	= $year_parent_obj->term_id;

var_dump($year_parent_obj);

$args = array(
	'child_of'                 => $year_parent_id,
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'hide_empty'               => 0,
	'hierarchical'             => 1,
	'taxonomy'                 => 'page_category',
); 

$years = get_categories( $args );


// Get the projects
$projects = get_field('hackdash_projects');

// Extract all Badges in use -> build the legend
// foreach ($projects as $key => $project) {
// 	$allBadges[] = $project['project_badge'][0];
// }
// $allBadges = array_unique($allBadges);

$field = get_field_object('hackdash_projects');

// get the proper names for badge choices
// foreach ($field['sub_fields'] as $key => $subfield) {
// 	if($subfield['name'] === 'project_badge'){
// 		$choiceNames = $subfield['choices'];
// 	}
// }

?>

<div id="content" data-speed="3" >
	<div id="inner-content" class="wrap clearfix">

	
		<div id="main"  role="main">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<section class="isotope-container twelvecol first entry-content" >
		<div class="grid-sizer"></div>
		<div class="gutter-sizer"></div>

		<div id="filters" class="entry-content background-panel teaser-item" itemprop="articleBody">
				
			<h2 class="filter" data-filter="*" >Alle</h2>
			<?php 
			if(!empty($regions)) {
					foreach ($regions as $key => $value) { ?>
						<h2 class="filter" data-filter=".term-<?php echo $value->term_id; ?>" > <?php echo $value->name;  ?> </h2>
					<?php 	
				}
			} 

			?> 

			<div>
				<?php 
					if(!empty($regions)) {
							foreach ($years as $key => $value) { 
				?>
								<h3 class="filter" data-filter=".year-<?php echo $value->term_id; ?>" > <?php echo $value->name;  ?> </h3>
				<?php 	
						}
					} 
				?> 
			</div>

			<!-- <div class="badge-legend-wrap">
				<?php
				foreach ($allBadges as $key => $badge) { ?>
					<h3 class="badge-legend badge-legend-<?php echo $badge; ?> filter" data-filter=".badge-<?php echo $badge; ?>" > <?php echo $choiceNames[$badge]; ?> </h3>
				<?php }
				?>	
			</div> -->


		</div> <!-- end article section -->

		<!-- project teasers-->

		<?php 

		if( !empty($projects) ) {
			foreach ($projects as $key => $project) {
				include('partials/project-teaser.php');
			}
		} ?>

	</section>



	<?php endwhile; else : ?>

		<article id="post-not-found" class="hentry clearfix">
			<header class="article-header">
				<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
			</header>
			<section class="entry-content">
				<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
			</section>
			<footer class="article-footer">
				<p><?php _e("This is the error message in the page.php template.", "bonestheme"); ?></p>
			</footer>
		</article>

	<?php endif; ?>

	</div> <!-- end #main -->

	</div> <!-- end #inner-content -->
</div> <!-- end #content -->

<?php get_footer(); ?>