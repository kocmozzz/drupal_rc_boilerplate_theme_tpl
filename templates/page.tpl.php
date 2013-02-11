<div id="wrapper" class="page_wrapper">
      <header class="page_header" id="header">
        <?php if($logo): ?>
          <div class="logo"><a href="<?php print $front_page; ?>"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/></a></div>
        <?php endif; ?>
        <?php print render($page['header']); ?> 
        <nav class="main_navigation"><?php print $primary_nav; ?></nav>
      </header>

      <section id="content" class="main_content_wrapper">
          <?php if ($title): ?>
            <h1 class="title"><?php print typograf($title); ?></h1>
          <?php endif; ?>
          <?php if ($tabs): ?><div id="tabs-wrapper"><?php print render($tabs); ?></div><?php endif; ?>
          <?php print render($tabs2); ?>
          <?php print $messages; ?>
          <?php print render($page['help']); ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>

          <?php print render($page['content']); ?>	   
      </section>

      <?php if ($page['sidebar_first']): ?>
      <aside id="sidebar-first" class="column sidebar first">
        <div id="sidebar-first-inner" class="inner">
          <?php print render($page['sidebar_first']); ?>
        </div>
      </aside>
    <?php endif; ?>
    <?php if ($page['sidebar_second']): ?>
      <aside id="sidebar-second" class="column sidebar second">
        <div id="sidebar-second-inner" class="inner">
          <?php print render($page['sidebar_second']); ?>
        </div>
      </aside>
    <?php endif; ?>

      <div class="footer_push"></div>
</div>
<footer id="footer" class="page_footer">
  <div id="page_footer_inner" class="clearfix">
      <?php print render($page['footer']); ?>
      <div class="copyright">
        <div id="copyright">&copy;&nbsp;<?php print '2000&ndash;' . format_date(time(), 'custom', 'Y') . '&nbsp;' . $site_name; ?></div>
        <?php if($page['studio_sign']): print render($page['studio_sign']); endif;?>
      </div>
  </div>
</footer>