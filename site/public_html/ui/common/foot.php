        <!-- Vue 3 via CDN -->
        <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
        <!-- Bootstrap Bundle JS (Popper + JS) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Código da aplicação Vue -->
        <?php if (isset($vueController) && !empty($vueController)) { ?>
            <script src="<?= constant('cAssets') . 'js/vue/' . $vueController ?>.js"></script>
        <?php } ?>

    </body>

</html>