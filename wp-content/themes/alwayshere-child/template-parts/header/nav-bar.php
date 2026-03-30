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
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/matana-leisha/' ) ); ?>"><?php esc_html_e( 'לאישה', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/matana-legever/' ) ); ?>"><?php esc_html_e( 'לגבר', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/labayit/' ) ); ?>"><?php esc_html_e( 'לבית', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/lechaver-chavera/' ) ); ?>"><?php esc_html_e( 'לחבר/חברה', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/matana-lechayyal/' ) ); ?>"><?php esc_html_e( 'לחייל/חיילת', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/lemore-mechanech/' ) ); ?>"><?php esc_html_e( 'למורה', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/lamisrad/' ) ); ?>"><?php esc_html_e( 'למשרד', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/mi-mekabel/lesaba-savta/' ) ); ?>"><?php esc_html_e( 'לסבא/סבתא', 'alwayshere-child' ); ?></a></li>
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
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/כוסות/' ) ); ?>"><?php esc_html_e( 'ספלים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/כובעים/' ) ); ?>"><?php esc_html_e( 'כובעים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/בקבוקים/' ) ); ?>"><?php esc_html_e( 'בקבוקים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/תיקים/' ) ); ?>"><?php esc_html_e( 'תיקים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/נרות/' ) ); ?>"><?php esc_html_e( 'נרות', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/תחתיות/' ) ); ?>"><?php esc_html_e( 'תחתיות', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/מחברות/' ) ); ?>"><?php esc_html_e( 'מחברות', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/מחזיקי-מפתחות/' ) ); ?>"><?php esc_html_e( 'מחזיקי מפתחות', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/פד-עכבר/' ) ); ?>"><?php esc_html_e( 'פד עכבר', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/מוצרים/הדפסה-על-עץ/' ) ); ?>"><?php esc_html_e( 'הדפסה על עץ', 'alwayshere-child' ); ?></a></li>
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
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/יום-הולדת/' ) ); ?>"><?php esc_html_e( 'יום הולדת', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/חתונה/' ) ); ?>"><?php esc_html_e( 'חתונה', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/יום-נישואים/' ) ); ?>"><?php esc_html_e( 'יום נישואים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/ולנטיין/' ) ); ?>"><?php esc_html_e( 'ולנטיין', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/חגים/' ) ); ?>"><?php esc_html_e( 'חגים', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/בר-בת-מצווה/' ) ); ?>"><?php esc_html_e( 'בר/בת מצווה', 'alwayshere-child' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/product-category/אירועים/לידה-וברית/' ) ); ?>"><?php esc_html_e( 'לידה וברית', 'alwayshere-child' ); ?></a></li>
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
