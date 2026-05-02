<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<?php if (!function_exists('bac_kup_is_global_part_page') || !bac_kup_is_global_part_page()) : ?>
<?php if (!(function_exists('bac_kup_render_global_part') && bac_kup_render_global_part('footer'))) : ?>
<footer>
  <div class="footer-wrap">
    <div class="footer-grid">
      <div>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo-link" aria-label="Bac-kup home">
          <img src="<?php echo esc_url(bac_kup_logo_url()); ?>" alt="Bac-kup" class="footer-logo-img">
        </a>
        <p class="ftr-tagline">Procesregie voor het MKB. Helder, schaalbaar en zonder onnodige lagen.</p>
        <p class="ftr-disclaimer">Origo levert procesondersteuning en verwerkt geen medische gegevens. Werkgever blijft verantwoordelijk voor regie en UWV-dossieropbouw.</p>
      </div>
      <div>
        <span class="ftr-col-title">Diensten</span>
        <ul class="ftr-links">
          <li><a href="<?php echo esc_url(home_url('/abonnementen/')); ?>">Abonnementen</a></li>
          <li><a href="<?php echo esc_url(home_url('/werkwijze/')); ?>">Werkwijze</a></li>
          <li><a href="<?php echo esc_url(home_url('/artsroute/')); ?>">Basiscontract &amp; arts-route</a></li>
          <li><a href="<?php echo esc_url(home_url('/tarieven/')); ?>">Tarieven (BAC)</a></li>
        </ul>
      </div>
      <div>
        <span class="ftr-col-title">Bedrijf</span>
        <ul class="ftr-links">
          <li><a href="<?php echo esc_url(home_url('/overons/')); ?>">Over ons</a></li>
          <li><a href="<?php echo esc_url(home_url('/faq/')); ?>">FAQ</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a></li>
        </ul>
      </div>
      <div>
        <span class="ftr-col-title">Legal</span>
        <ul class="ftr-links">
          <li><a href="<?php echo esc_url(home_url('/privacyverklaring/')); ?>">Privacyverklaring</a></li>
          <li><a href="<?php echo esc_url(home_url('/cookieverklaring/')); ?>">Cookieverklaring</a></li>
          <li><a href="<?php echo esc_url(home_url('/disclaimer/')); ?>">Disclaimer</a></li>
          <li><a href="<?php echo esc_url(home_url('/klachtenregeling/')); ?>">Klachtenregeling</a></li>
          <li><a href="<?php echo esc_url(home_url('/algemene-voorwaarden/')); ?>">Algemene voorwaarden</a></li>
          <li><a href="<?php echo esc_url(home_url('/colofon/')); ?>">Colofon</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span class="ftr-copy">&copy; <?php echo esc_html(wp_date('Y')); ?> Bac-kup - Anne Frankstraat 35, 2548LA 's-Gravenhage - KvK 99878232</span>
      <span class="ftr-copy">Geen tracking - Geen advertenties</span>
    </div>
  </div>
</footer>
<?php endif; ?>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
