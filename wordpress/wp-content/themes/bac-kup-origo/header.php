<?php
if (!defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if (!function_exists('bac_kup_is_global_part_page') || !bac_kup_is_global_part_page()) : ?>
<?php if (function_exists('bac_kup_render_global_part') && bac_kup_render_global_part('header')) { return; } ?>
<nav id="mainNav" role="navigation" aria-label="Hoofdnavigatie">
  <div class="nav-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="Bac-kup terug naar home">
      <img src="<?php echo esc_url(bac_kup_logo_url()); ?>" alt="Bac-kup" class="nav-logo-img">
    </a>
    <ul class="nav-links" role="list">
      <?php foreach (bac_kup_origo_pages() as $page) : ?>
        <?php $active = bac_kup_is_current_slug($page['slug']); ?>
        <li>
          <a href="<?php echo esc_url($page['url']); ?>"<?php echo $active ? ' class="active" aria-current="page"' : ''; ?>><?php echo esc_html($page['label']); ?></a>
        </li>
      <?php endforeach; ?>
      <?php $contact_active = is_page('contact'); ?>
      <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="nav-cta<?php echo $contact_active ? ' active' : ''; ?>">Plan kennismaking</a></li>
    </ul>
    <button class="nav-ham" id="navHam" aria-label="Menu openen" aria-expanded="false" aria-controls="mobMenu">
      <svg id="hamIcon" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true">
        <line x1="3" y1="6" x2="21" y2="6"/>
        <line x1="3" y1="12" x2="21" y2="12"/>
        <line x1="3" y1="18" x2="21" y2="18"/>
      </svg>
    </button>
  </div>
</nav>
<div class="mob-menu" id="mobMenu" role="dialog" aria-label="Navigatiemenu" aria-modal="true">
  <div class="mob-overlay" id="mobOverlay"></div>
  <div class="mob-panel">
    <ul class="mob-links" role="list">
      <?php foreach (bac_kup_origo_pages() as $page) : ?>
        <?php $active = bac_kup_is_current_slug($page['slug']); ?>
        <li>
          <a href="<?php echo esc_url($page['url']); ?>"<?php echo $active ? ' class="active" aria-current="page"' : ''; ?>>
            <?php echo esc_html($page['label']); ?>
            <svg class="arr" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="mob-divider"></div>
    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mob-cta">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.42 2 2 0 0 1 3.6 1.27h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.92-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
      Plan kennismaking
    </a>
  </div>
</div>
<?php endif; ?>
