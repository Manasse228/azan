

<div class="container">
    <div class="row">

        <div class="col-sm-3 col-sm-offset-4">
            <div class="contact-text">
                <h3>Contact</h3>
                <address>
                    <?php echo $evenement->getContact(); ?>
                </address>
            </div>
            <div class="contact-address">
                <h3>Lieu</h3>
                <address>
                    <?php echo $evenement->getLieu(); ?>
                </address>
            </div>
        </div>

        <div class="col-sm-5">
            <div id="contact-section">
                <h3>Un renseignement ? C'est par ici!!!</h3>
                <div class="status alert alert-success" style="display: none"></div>
                <form id="main-contact-form" class="contact-form" name="contact-form" method="post"
                      action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES); ?>" >

                    <div class="form-group">
                        <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="Nom">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" autocomplete="off" required placeholder="Adresse Email">
                    </div>
                    <div class="form-group">
					                <textarea name="message" id="message" required  class="form-control" rows="4"
                                              placeholder="Entrez votre message"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right" name="envoiEmail" value="envoyer">Envoyer</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>