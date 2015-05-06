<section>
    <div class="container">
        <div class="row">
            
            <div class="col-md-6 col-md-offset-3">
                <h2>CONNEXION</h2></br>
                <form method="POST" action="index.php?uc=connexion">
                    <div class="form-group">
                        <label for="login">LOGIN</label>
                        <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="form-group">
                        <label for="mdp">MOT DE PASSE</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" >
                    </div>

                    <div class="col-md-3 col-md-offset-2">
                        <button type="submit" name="connexion" value="Connexion" class="btn btn-lg btn-success">Connexion</button>
                    </div>
                    <div class="col-md-3 col-lg-offset-1">
                        <button type="reset" value="Annuler" class="btn btn-lg btn-danger">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php unset($_SESSION['error']); ?>