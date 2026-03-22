<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '/shop/';
?>
<nav class="ah-nav-bar" aria-label="<?php esc_attr_e( 'ניווט ראשי', 'alwayshere-child' ); ?>">
	<div class="ah-nav-bar__inner">

		<!-- קטגוריות — mega menu -->
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="#">
				<?php esc_html_e( 'קטגוריות', 'alwayshere-child' ); ?>
				<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
			</a>
			<div class="ah-mega-menu">
				<div class="ah-mega-col ah-mega-col--cats">
					<h5><?php esc_html_e( 'לפי נמען', 'alwayshere-child' ); ?></h5>
					<ul>
						<li><a href="<?php echo esc_url( get_term_link( 'mi-mekabel', 'product_cat' ) ?: $shop_url ); ?>"><?php esc_html_e( 'לגבר', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'לאישה', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'לחייל / חיילת', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'ליום הולדת', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'לאירועים', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'לבית', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'ליום אהבה', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'ליום נישואין', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'למשרד', 'alwayshere-child' ); ?></a></li>
					</ul>
				</div>
				<div class="ah-mega-divider"></div>
				<div class="ah-mega-col ah-mega-col--prods">
					<h5><?php esc_html_e( 'מוצרים מומלצים', 'alwayshere-child' ); ?></h5>
					<div class="ah-mega-products">
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1605870445919-838d190e8e1b?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'הדפסה על בלוק עץ', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'הדפסה על בלוק עץ', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'תמונה אהובה על עץ טבעי — מתנה מרהיבה', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'מבצע', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪89', 'alwayshere-child' ); ?></span>
							</div>
						</a>
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'ספל אישי מעוצב', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'ספל אישי מעוצב', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'ספל קרמי איכותי בעיצוב שתבחרו', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'רב מכר', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪69', 'alwayshere-child' ); ?></span>
							</div>
						</a>
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'כרית פאזל אישית', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'כרית פאזל אישית', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'כרית רכה עם תמונתכם כפאזל מקורי', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'חדש', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪99', 'alwayshere-child' ); ?></span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- מוצרים — mega menu -->
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="<?php echo esc_url( $shop_url ); ?>">
				<?php esc_html_e( 'מוצרים', 'alwayshere-child' ); ?>
				<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
			</a>
			<div class="ah-mega-menu">
				<div class="ah-mega-col ah-mega-col--cats">
					<h5><?php esc_html_e( 'לפי סוג מוצר', 'alwayshere-child' ); ?></h5>
					<ul>
						<li><a href="#"><?php esc_html_e( 'הדפסה על עץ', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'הדפסה על זכוכית', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'ספלים מודפסים', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'כריות פאזל', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'חולצות מודפסות', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'מחזיקי מפתחות', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'נרות ריחניים', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'תכשיטים מעוצבים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( $shop_url ); ?>" class="ah-mega-col__all"><?php esc_html_e( '← כל המוצרים', 'alwayshere-child' ); ?></a></li>
					</ul>
				</div>
				<div class="ah-mega-divider"></div>
				<div class="ah-mega-col ah-mega-col--prods">
					<h5><?php esc_html_e( 'מוצרים מומלצים', 'alwayshere-child' ); ?></h5>
					<div class="ah-mega-products">
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1614107151491-6876eecbff89?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'הדפסה על זכוכית', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'הדפסה על זכוכית', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'תמונה מודפסת על זכוכית מחוסמת', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'מבצע', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪109', 'alwayshere-child' ); ?></span>
							</div>
						</a>
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'חולצה מודפסת', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'חולצה מודפסת', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'כותנה איכותית עם הדפסה שלא תדעך', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'רב מכר', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪79', 'alwayshere-child' ); ?></span>
							</div>
						</a>
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'מחזיק מפתחות', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'מחזיק מפתחות אישי', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'מתכת איכותית עם חריטת שם', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'חדש', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪49', 'alwayshere-child' ); ?></span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- לפי אירוע — mega menu -->
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="#">
				<?php esc_html_e( 'לפי אירוע', 'alwayshere-child' ); ?>
				<svg viewBox="0 0 24 24" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
			</a>
			<div class="ah-mega-menu">
				<div class="ah-mega-col ah-mega-col--cats">
					<h5><?php esc_html_e( 'לפי אירוע', 'alwayshere-child' ); ?></h5>
					<ul>
						<li><a href="#"><?php esc_html_e( 'יום הולדת', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'חתונה ואירוסין', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'לידה ובריתות', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'בר / בת מצווה', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'ימי נישואין', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'ימי אהבה', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'חגים', 'alwayshere-child' ); ?></a></li>
						<li><a href="#"><?php esc_html_e( 'סתם כי בא לך', 'alwayshere-child' ); ?></a></li>
					</ul>
				</div>
				<div class="ah-mega-divider"></div>
				<div class="ah-mega-col ah-mega-col--prods">
					<h5><?php esc_html_e( 'מוצרים מומלצים', 'alwayshere-child' ); ?></h5>
					<div class="ah-mega-products">
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'סט מתנה מעוצב', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'סט מתנה מעוצב', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'מארז מתנה מושלם לכל אירוע', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'פופולרי', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪149', 'alwayshere-child' ); ?></span>
							</div>
						</a>
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1605870445919-838d190e8e1b?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'הדפסה על בלוק עץ', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'הדפסה על בלוק עץ', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'מתנה שתישאר לנצח', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'מבצע', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪89', 'alwayshere-child' ); ?></span>
							</div>
						</a>
						<a href="#" class="ah-mega-prod">
							<div class="ah-mega-prod__img"><img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=150&h=150&fit=crop" alt="<?php esc_attr_e( 'תכשיט מעוצב', 'alwayshere-child' ); ?>" loading="lazy"/></div>
							<div class="ah-mega-prod__body">
								<span class="ah-mega-prod__name"><?php esc_html_e( 'תכשיט עם שם אישי', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__desc"><?php esc_html_e( 'תכשיט מעוצב בהתאמה אישית', 'alwayshere-child' ); ?></span>
								<span class="ah-mega-prod__price"><span class="ah-mega-prod__tag"><?php esc_html_e( 'רב מכר', 'alwayshere-child' ); ?></span> <?php esc_html_e( 'החל מ־₪139', 'alwayshere-child' ); ?></span>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="ah-nav-item">
			<a class="ah-nav-link ah-nav-link--sale" href="#"><?php esc_html_e( 'מבצעים 🔥', 'alwayshere-child' ); ?></a>
		</div>
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="#"><?php esc_html_e( 'AI Studio ✨', 'alwayshere-child' ); ?></a>
		</div>
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="#"><?php esc_html_e( 'הנמכרים ביותר', 'alwayshere-child' ); ?></a>
		</div>
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="#"><?php esc_html_e( 'אודות', 'alwayshere-child' ); ?></a>
		</div>
		<div class="ah-nav-item">
			<a class="ah-nav-link" href="#"><?php esc_html_e( 'צרו קשר', 'alwayshere-child' ); ?></a>
		</div>

	</div>
</nav>
