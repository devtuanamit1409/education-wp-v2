<?php
/**
 * Template: Levels
 * Version: 3.0.2
 * Version of PMS, for not out of date
 */
global $current_user;
if ( version_compare( PMPRO_VERSION, '2.5.8', '<' ) ) {
	$levels = lp_pmpro_get_all_levels();
} else {
	$levels = pmpro_sort_levels_by_order( lp_pmpro_get_all_levels() );
}
$list_courses = lp_pmpro_list_courses( $levels );
asort( $list_courses );
?>

<?php do_action( 'learn_press_pmpro_before_levels' ); ?>
<table class="lp-pmpro-membership-list">
	<thead>
		<tr class="lp-pmpro-header">
			<th class="header-list-main list-main"></th>

			<?php
			$class_count = ' has-' . count( $levels );

			foreach ( $levels as $index => $level ) :
				$current_level = false;

				if ( isset( $current_user->membership_level->ID ) ) {
					if ( $current_user->membership_level->ID == $level->id ) {
						$current_level = true;
					}
				}
				?>

				<th class="header-item list-item<?php echo $class_count . ' position-' . $index; ?>"
					<?php echo apply_filters( 'learn_press_pmpro_style_header', '', $level->id ); ?>>
				<h2 class="lp-title"><?php echo esc_html( $level->name ); ?></h2>
					<?php
					if ( ! empty( $level->description ) ) {
						echo '<div class="lp-desc">' . $level->description . '</div>';
					}
					?>
					<div class="lp-price">
						<?php if ( pmpro_isLevelFree( $level ) ) : ?>
							<?php esc_html_e( 'Free', 'learnpress-paid-membership-pro' ); ?>
						<?php else : ?>
							<?php
							$cost_text = pmpro_getLevelCost( $level, true, true );
							echo ent2ncr( $cost_text );
							?>
						<?php endif; ?>
					</div>
				</th>
			<?php endforeach; ?>
		</tr>
	</thead>

	<tbody class="lp-pmpro-main">
		<tr class="item-row">
			<td class="list-main item-td item-desc"><?php esc_html_e( 'Number of courses', 'learnpress-paid-membership-pro' ); ?></td>
			<?php
			foreach ( $levels as $index => $level ) {
				$the_query = lp_pmpro_query_course_by_level( $level->id );
				$count     = count( $the_query->posts );

				echo '<td class="list-item item-td">' . esc_html( $count ) . '</td>';
			}
			?>
		</tr>

		<?php
		if ( ! empty( $list_courses ) ) {
			foreach ( $list_courses as $key => $course_item ) {
				$class_course = '';

				if ( isset( $_GET['course_id'] ) && ! empty( $_GET['course_id'] ) ) {
					$course_id = $_GET['course_id'];

					if ( absint( $course_id ) === $course_item['id'] ) {
						$class_course = apply_filters( 'learn-press-pmpro-levels-page-current-course', 'learn-press-course-current', $course_item, $course_id );

					}
				}
				?>
				<tr class="item-row <?php echo esc_attr( $class_course ); ?>">
					<?php
					echo apply_filters( 'learn_pres_pmpro_course_header_level', '<td class="list-main item-td">' . wp_kses_post( $course_item['link'] ) . '</td>', $course_item['link'], $course_item, $key );

					foreach ( $levels as $index => $level ) {
						if ( in_array( $level->id, $course_item['level'] ) ) {
							echo apply_filters( 'learn_press_pmpro_course_is_level', '<td class="list-item item-td item-check">&#10003;</td>', $level, $index, $course_item, $key );
						} else {
							echo apply_filters( 'learn_press_pmpro_course_is_not_level', '<td class="list-item item-td item-none"><i class="fa fas fa-times"></i></td>', $level, $index, $course_item, $key );
						}
					}

					?>
				</tr>
				<?php
			}
		}
		?>
	</tbody>

	<tfoot class="lp-pmpro-footer">
		<tr>
			<td class="footer-left-main list-main"></td>
			<?php
			foreach ( $levels as $index => $level ) :
				$current_level = false;

				if ( isset( $current_user->membership_level->ID ) ) {
					if ( $current_user->membership_level->ID == $level->id ) {
						$current_level = true;
					}
				}
				?>
				<td class="list-item">
					<?php if ( empty( $current_user->membership_level->ID ) || ! $current_level ) { ?>
						<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ); ?>"><?php _e( 'GET IT NOW', 'learnpress-paid-membership-pro' ); ?></a>
					<?php } elseif ( $current_level ) { ?>
						<?php
						if ( pmpro_isLevelExpiringSoon( $current_user->membership_level ) && $current_user->membership_level->allow_signups ) {
							?>
							<a class="pmpro_btn pmpro_btn-select"
							href="<?php echo pmpro_url( 'checkout', '?level=' . $level->id, 'https' ); ?>"><?php _e( 'Renew', 'learnpress-paid-membership-pro' ); ?></a>
							<?php
						} else {
							?>
							<a class="pmpro_btn disabled" href="<?php echo pmpro_url( 'account' ); ?>"><?php _e( 'Your Level', 'learnpress-paid-membership-pro' ); ?></a>
							<?php
						}
						?>

					<?php } ?>
				</td>
			<?php endforeach; ?>
		</tr>
	</tfoot>
</table>
<?php do_action( 'learn_press_pmpro_after_levels' ); ?>
