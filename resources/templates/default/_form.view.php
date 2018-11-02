<?php
global $rafMember;

echo "<pre>";
print_r($rafMember);
echo "</pre>";
?>
loool easy
<div class="social-icon">
	<ul>
		<li class="email"><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> </li>
		<li class="facebook">
		<a class="raf-social-share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(wc_get_page_id('shop')) . '?raf-mem=' . $rafMember->memberAffID; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
		<li class="twitter"><a class="raf-social-share" href="https://twitter.com/share?text=<?php echo get_permalink(wc_get_page_id('shop')) . '?raf-mem=' . $rafMember->memberAffID; ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
	</ul>
</div>

<div class="email-field">
	<form id="raf-refer-product-form">
		<input type="hidden" name="controller" value="refer">
		<input type="hidden" name="rafAction" value="processRefer">
		<input type="email" name="rafReferEmail" placeholder="Enter your friend email">
		<textarea name="rafReferMessage">CuraLin helped me manage my glucose levels safely, fast and naturally. Here's a 5% discount from me for your first order. Give it try, you won't regret it.</textarea>
		<button type="button" data-raf-prod-id>Send Email</button>
	</form>
</div>
<div class="share-the-link">
	<h4>or share the link below</h4>
	<aside> <span class="link-text" title="<?php echo get_permalink(wc_get_page_id('shop')) . '?raf-mem=' . $rafMember->memberAffID; ?>"><?php echo get_permalink(wc_get_page_id('shop')) . '?raf-mem=' . $rafMember->memberAffID; ?></span><button data-raf-copy-link>Copy Link</button>
	<span class="raf-tooltip">Link copied!</span>
	</aside>
</div>