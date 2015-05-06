<div class="alert alert-danger" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <ul class="list-unstyled">
        <?php
        if (nbErreurs() > 0) {

            foreach ($_POST['erreurs'] as $erreur) {
                echo '<li>' . htmlentities($erreur) . '</li>';
            }
        }
        ?>
    </ul>
</div>
