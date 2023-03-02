    <footer class="footer">
      <div class="container">
      </div>
    </footer>
    <!-- ====================== MODAL ============================-->
    <!-- СПАСИБО-->
    <div class="graph-modal">
      <!-- МОДАЛКА ЗА 1 МИНУТУ -->
      <div class="graph-modal__container" role="dialog" aria-modal="true" data-graph-target="lead">
        <button class="btn-reset js-modal-close graph-modal__close more-btn" aria-label="Закрыть модальное окно">
        </button>
        <section class="cart__modal">
          <span class="cart__title">Корзина</span>
          <div class="header-quickcart"><?php woocommerce_mini_cart(); ?></div>
          <?php echo do_shortcode('[woocommerce_checkout]');?>
        </section>
      </div>
    </div>
  <!-- КОНЕЦ МОДАЛКА -->
  <!-- ====================== END MODAL ============================-->
    <?php wp_footer() ?>
  </body>
</html>
