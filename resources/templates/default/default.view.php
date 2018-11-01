<?php get_header(); ?>

	<section class="banner-sec">
		<div class="banner-left">
			<span>Refer<br />a Friend</span>
			<span>Change a Life</span>
		</div>
		<div class="banner-right">
			<h2>Don't Leave Your Friends Behind.</h2>
			<h2>Help Them Control Glucose Levels, Naturally.</h2>
			<h3>Give 5% Get 10%</h3>
			<p>For every friend that purchases, we'll give them 5% OFF their first order, and we'll reward you with a 10%
				discount!</p>


			<div class="social-icon">
				<ul>
					<li class="email"><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> </li>
					<li class="facebook"><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
					<li class="twiiter"><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
				</ul>
			</div>

			<div class="email-field">
				<form id="raf-refer-product-form">
					<input type="hidden" name="controller" value="templates">
					<input type="hidden" name="rafAction" value="referProduct">
					<input type="" name="" placeholder="Enter your friend email">
					<textarea>CuraLin helped me manage my glucose levels safely, fast and naturally. Here's a 5% discount from me for your first order. Give it try, you won't regret it.</textarea>
					<button type="button" data-raf-prod-id>Send Email</button>
				</form>
			</div>
			<div class="share-the-link">
				<h4>or share the link below</h4>
				<aside> <input type="" name="" placeholder="https://curalife.co/refer-a-friend/#"><button>Copy Link</button></aside>
			</div>
		</div>
	</section>
	<!--  Contrary-sec-->
	<section class="work-sec">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<h2>Here's How it works</h2>
					<div class="wrapo">
						<div class="count-bar">
							<ul>
								<li><span data-text-up="0" data-text-down=""></span></li>
								<li><span data-text-up="1" data-text-down="10% Discount on any order"></span></li>
								<li><span data-text-up="5" data-text-down="50% Discount on any order"></span></li>
								<li><span data-text-up="10" data-text-down="Free Unit or CuraLin"></span></li>
								<li><span data-text-up="30" data-text-down="Free 3-Pack of CuraLin"></span></li>
								<li><span data-text-up="60" data-text-down="Free 6-Pack of CuraLin"></span></li>
							</ul>
						</div>
						<div class="raf-progress-wrapper" data-text-up="Friends Referrals" data-text-down="CuraLife Rewards">
							<div class="raf-progress">
								<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer(); ?>
